<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FamilyController extends Controller
{
    /**
     * Index() is het startpunt van de app na inloggen. Bepaalt wat een gewone user of een admin te zien krijgen.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('show.login');
        }

        if ($user->accessLevel?->name === "admin") {
            // This is the admin dashboard with all the families.
            return $this->showFamilies();
        } else {
            // Fetch data of the user's family.
            return $this->showFamily(Auth::user()->family_id);
        }
    }

    /**
     * Roept alle families op en toont ze
     */
    public function showFamilies()
    {
        // Fetch all family data and add pagination.
        $user = Auth::user();
        $families = Family::where('name', '!=', 'Personeel')->orderBy('created_at', 'desc')->paginate(8);
        return view('families.index', [
            'families' => $families,
            'userName' => $user->name,
            'accessLevel' => $user->accessLevel?->name
        ]);
    }

    /**
     * Roept één familie op en toont deze.
     * @param $id
     * @return Factory|View|Application|RedirectResponse|object
     */
    public function showFamily($id)
    {
        $user = Auth::user();
        $family = Family::with('users.contribution.age_discount', 'users.membership')->findOrFail($id);

        // Admins can see the info of any family.
        if($user->accessLevel->name === "admin"){
            return view('families.show_family', ['family' => $family]);
        }

        // Family members can only see the info of their own familie.
        if($user->accessLevel->name !== "admin" && $user->family_id === $family->id) {
            return view('families.show_family', ['family' => $family]);
        }

        // If authorization checks are not passed redirects to index.
        return redirect()->route('family.index')->with('error', 'Geen toegang tot gevraagde familie');
    }

    /**
     * Slaat een nieuwe familie op
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:50",
            'address' => 'required|string|max:50|unique:families,address',
        ]);

        Family::create($validated);

        return redirect()->route('family.index')->with('success', 'Family toegevoegd');
    }

    /**
     * Past een bestaande familie aan
     * @param Request $request
     * @param Family $family
     * @return RedirectResponse
     */
    public function update(Request $request, Family $family)
    {
        $validated = $request->validate([
            "name" => "required|string|max:50",
            'address' => [
                'required',
                'string',
                'max:50',
                Rule::unique('families', 'address')->ignore($family->id),
            ],
        ]);

        $family->fill($validated);
        if ($family->isDirty()) {
            $family->save();
            return redirect()->route('family.show', $family->id)
                ->with('success', 'Familie info is bijgewerkt');
        }

        return redirect()->back()->with('warning', 'Familie informatie is niet opgeslagen.');
    }

    /**
     * Verwijdert een familie (destroy). Dit heeft een cascade-effect en verwijdert ook de bijbehorende familieleden.
     * @param Family $family
     * @return RedirectResponse
     */
    public function destroy(Family $family)
    {
        $family->delete();

        return redirect()->route('family.index')->with('success', 'Familie ' . $family->name .' is verwijderd');
    }
}
