<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FamilyController extends Controller
{
    // Start van de app na inloggen.
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:50",
            'address' => 'required|string|max:50|unique:families,address',
        ]);

        Family::create($validated);

        return redirect()->route('family.index')->with('success', 'Family toegevoegd');
    }

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

    public function destroy(Family $family)
    {
        $family->delete();

        return redirect()->route('family.index')->with('success', 'Familie info is verwijderd');
    }
}
