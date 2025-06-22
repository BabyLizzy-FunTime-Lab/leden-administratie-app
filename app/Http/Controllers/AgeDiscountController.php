<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\AgeDiscount;
use Illuminate\Validation\Rule;

class AgeDiscountController extends Controller
{
    public function index()
    {
        $ageDiscounts = AgeDiscount::where('name', '!=', 'personeel')->orderBy('created_at', 'desc')->paginate(5);
        return view('age_discounts.index', ['ageDiscounts' => $ageDiscounts]);
    }

    public function store(Request $request)
    {
        $validated  = $request->validate([
            'name' => 'required|max:20|unique:age_discounts,name',
            'min_age' => 'required|numeric|min:0',
            'max_age' => 'required|numeric|max:150',
            'discount_percentage' => 'required|numeric|min:0|max:100|unique:age_discounts,discount_percentage',
        ]);

        AgeDiscount::create($validated);
        return redirect()->route('age_discounts.index')->with('success', 'Leeftijd Categorie is aangemaakt');
    }

    public function edit(AgeDiscount $ageDiscount)
    {
        return view('age_discounts.edit', ['ageDiscount' => $ageDiscount]);
    }

    public function update(Request $request, AgeDiscount $ageDiscount)
    {
        if($ageDiscount->contributions()->exists()){
            return redirect()->route('age_discounts.edit', $ageDiscount->id)
                ->with('error', 'Leefttijd Categorie is niet aangepast want het is gekoppeld aan een contributie');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'max:20',
                Rule::unique('age_discounts')->ignore($ageDiscount->id),
            ],
            'min_age' => 'required|numeric|min:0',
            'max_age' => 'required|numeric|max:150',
            'discount_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
                Rule::unique('age_discounts')->ignore($ageDiscount->id),
            ],
        ]);

        $ageDiscount->fill($validated);
        if($ageDiscount->isDirty()){
            $ageDiscount->save();
            return redirect()->route('age_discounts.edit', ['ageDiscount' => $ageDiscount])
                ->with('success', 'Categorie is aangepast');
        }

        return redirect()->back()->with('warning', 'Geen nieuwe data is gedeceteerd nog opgeslagen');
    }

    public function destroy(AgeDiscount $ageDiscount)
    {
        if($ageDiscount->contributions()->exists()){
            return redirect()->route('age_discounts.index')
                ->with('error', 'Leefttijd Categorie is niet verwijderd het is gekoppeld aan een contributie');
        }

        try {
            if($ageDiscount->delete()){
                return redirect()->route('age_discounts.index')
                    ->with('success', 'Leeftijd Categorie is verwijderd');
            }
        } catch (QueryException $error) {
            if ($error->getCode() == '23000') {
                return redirect()->route('age_discounts.index')
                    ->with('error', 'Leeftijd Categorie is gekoppeld en dus niet verwijderd');
            }
        }

        // Unknown error
        return redirect()->route('age_discounts.index')
            ->with('error', 'Er is iets misgegaan bij het verwijderen van de leeftijd Categorie.');
    }
}
