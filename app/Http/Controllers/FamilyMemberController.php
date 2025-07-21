<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FamilyMemberController extends Controller
{
    /**
     * Toont een familielid
     * @param $id
     * @return Factory|View|Application|RedirectResponse|object
     */
    public function show($id)
    {
        // Fetch all data of one family member with $id
        $familyMember = User::with(
            'contribution.age_discount',
            'membership',
            'familyRole',
            'accessLevel',
            'family'
        )->findOrFail($id);

        // Logged in user.
        $user = Auth::user();

        // Non admin users can only see members of their own family.
        if($user->accessLevel->name !== "admin" && $user->family_id == $familyMember->family_id)
        {
            return view('families.show_family_member', ['familyMember' => $familyMember]);
        }

        // Admins can call up info on all users.
        if($user->accessLevel->name === "admin")
        {
            return view('families.show_family_member', ['familyMember' => $familyMember]);
        }

        // If auth checks fail redirects to home page.
        return redirect()->route('family.index')->with('error', 'Geen toegang tot dit familielid.');
    }

    /**
     * Slaat een familielid op
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_id' => 'required|exists:families,id',
            'name' => 'required|string|max:20|unique:users,name',
            'date_of_birth' => 'required|date',
            'age_discount_id' => 'required|string|exists:age_discounts,id',
            'membership_id' => 'required|string|exists:memberships,id',
            'book_year_id' => 'required|string|exists:book_years,id',
            'email' => 'required|string|email|max:100',
            'family_role_id' => 'required|string|exists:family_roles,id',
        ]);

        // It automatically searches for the correct contribution
        // and adds it to the validated array
        $contribution = Contribution::where([
            ['age_discount_id', $validated['age_discount_id']],
            ['membership_id', $validated['membership_id']],
            ['book_year_id', $validated['book_year_id']],
        ])->first();

        if (!$contribution) {
            return back()
                ->withErrors([
                    'contribution_id' =>
                        'Er is geen geldige contributie gevonden met deze combinatie
                        van boekjaar, lidmaatschap en leeftijdscategorie.'
                ])
                ->withInput();
        }

        $validated['contribution_id'] = $contribution->id;
        // Every new family member gets a standard password.
        $validated['password'] = Hash::make('password');
        // Every family member has an access lv of "familie lid"
        $validated['access_level_id'] = 2;

        User::create($validated);

        return redirect()->route('family.show', $validated['family_id'])
            ->with('success', 'Nieuwe familie lid is toegevoegd');
    }

    /**
     * Past een familielid aan
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'family_id' => 'required|exists:families,id',
            'name' => 'required|string|max:50|unique:users,name,' . $user->id,
            'date_of_birth' => 'required|date',
            'age_discount_id' => 'required|string|exists:age_discounts,id',
            'membership_id' => 'required|string|exists:memberships,id',
            'book_year_id' => 'required|string|exists:book_years,id',
            'email' => 'required|string|email|max:100',
            'family_role_id' => 'required|string|exists:family_roles,id',
        ]);

        // Only the user can change their own password.
        // access level can not be changed.
        $validated['password'] = Hash::make('password');
        $validated['access_level_id'] = $user->access_level_id;

        // Familie met id 1 is uitsluitend voor personeel.
        if($validated['family_id'] == 1) {
            return redirect()->back()->with('warning', 'Ingevoerde familie id is niet toegestaan');
        }

        // Check if the contribution needs to change.
        // if age_discount_id, membership_id or book_year_id change
        // Look for a contribution that matches.
        $contribution = Contribution::where([
            ['age_discount_id', $validated['age_discount_id']],
            ['membership_id', $validated['membership_id']],
            ['book_year_id', $validated['book_year_id']],
        ])->first();

        if (!$contribution) {
            return back()
                ->withErrors([
                    'contribution_id' =>
                        'Er is geen geldige contributie gevonden met deze combinatie
                        van boekjaar, lidmaatschap en leeftijdscategorie.'
                ])
                ->withInput();
        }
        $validated['contribution_id'] = $contribution->id;


        $user->fill($validated);
        if ($user->isDirty()) {
            $user->save();
            return redirect()->route('family_member.show', $user->id)
                ->with('success', 'Familie lid is bijgewerkt');
        }

        return redirect()->back()->with('warning', 'Geen nieuwe data is gedetecteerd nog opgeslagen');
    }

    /**
     * Verwijdert een familielid
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        if($id == 1) {
            return redirect()->back()->with('error', 'De standaard admin kan niet verwijderd worden');
        }

        $familyMember = User::findOrFail($id);
        $familyId = $familyMember->family_id;
        $familyMember->delete();

        return redirect()->route('family.show', $familyId)->with('success', 'Familie lid is succesvol verwijderd');
    }
}
