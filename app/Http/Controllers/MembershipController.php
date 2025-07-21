<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Membership;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    /**
     * Toont alle lidmaatschappen
     */
    public function index()
    {
        $memberships = Membership::where('name', '!=', 'personeel')->paginate(5);
        return view('memberships.index', ['memberships' => $memberships]);
    }

    /**
     * Slaat een lidmaatschap op zolang de naam en het kortingspercentage uniek zijn
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|object
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:20|unique:memberships,name',
            'discount_percentage' => 'required|numeric|min:0|max:100|unique:memberships,discount_percentage',
        ]);

        Membership::create($validated);
        return redirect('/memberships')->with('success', 'Nieuwe Lidmaatschap is aangemaakt');
    }

    /**
     * Toont de pagina “Lidmaatschap Aanpassen”.
     * @param Membership $membership
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application|object
     */
    public function edit(Membership $membership)
    {
        return view('memberships.edit', ['membership' => $membership]);
    }

    /**
     * Past een lidmaatschap aan zolang het niet gekoppeld is aan een user en/of een contributie. Ook de naam en het
     * kortingspercentage moeten uniek zijn.
     * @param Request $request
     * @param Membership $membership
     * @return RedirectResponse
     */
    public function update(Request $request, Membership $membership)
    {
        if($membership->contributions()->exists()){
            return redirect()->back()
                ->with('error', 'Lidmaatschap is niet aangepast want het is gekoppeld aan een contributie');
        }
        if($membership->users()->exists()){
            return redirect()->back()
                ->with('error', 'Lidmaatschap is niet aangepast want het is gekoppeld aan een familie lid');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'max:20',
                Rule::unique('memberships')->ignore($membership->id),
            ],
            'discount_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
                Rule::unique('memberships')->ignore($membership->id),
            ],
        ]);

        $membership->fill($validated);
        if($membership->isDirty()) {
            $membership->save();
            return redirect()->route('memberships.edit', $membership->id)
                ->with('success', 'Lidmaatschap is bijgewerkt');
        }

        return redirect()->back()->with('warning', 'Geen nieuwe data is gedeceteerd nog opgeslagen');
    }

    /**
     * Verwijderd een lidmaatschap, zolang het niet gekoppeld is aan een user of een contributie.
     * @param Membership $membership
     * @return RedirectResponse
     */
    public function destroy(Membership $membership)
    {
        // The membership can't be deleted if it has a relation to a user or a membership.
        if($membership->contributions()->exists()){
            return redirect()->route('memberships.index')
                ->with('error', 'Lidmaatschap is niet verwijderd het is gekoppeld aan een contributie');
        }
        if($membership->users()->exists()){
            return redirect()->route('memberships.index')
                ->with('error', 'Lidmaatschap is niet verwijderd het is gekoppeld aan een familie lid');
        }

        try {
            if($membership->delete()){
                return redirect()->route('memberships.index')->with('success', 'Lidmaatschap is verwijderd');
            }
        } catch (QueryException $error) {
            if ($error->getCode() == '23000') {
                return redirect()->route('memberships.index')
                    ->with('error', 'Lidmaatschap is gekoppeld en dus niet verwijderd');
            }
        }

        // Unknown error
        return redirect()->route('memberships.index')
            ->with('error', 'Er is iets misgegaan bij het verwijderen van de lidmaatschap.');
    }
}
