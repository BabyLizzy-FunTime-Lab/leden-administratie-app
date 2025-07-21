<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\AgeDiscount;
use Illuminate\Validation\Rule;

class AgeDiscountController extends Controller
{
    /**
     * Toont alle leeftijdscategorieën met hun bijbehorende korting, behalve de personeel categorie. Deze categorie kan
     * niet worden aangepast nog vernietigd.
     */
    public function index()
    {
        $ageDiscounts = AgeDiscount::where('name', '!=', 'personeel')->orderBy('created_at', 'desc')->paginate(5);
        return view('age_discounts.index', ['ageDiscounts' => $ageDiscounts]);
    }

    /**
     * Slaat een nieuwe leeftijdscategorie op, zolang de naam en het kortingspercentage uniek zijn. De minimumleeftijd
     * moet kleiner zijn dan de maximumleeftijd en groter dan nul.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated  = $request->validate([
            'name' => 'required|max:20|unique:age_discounts,name',
            'min_age' => 'required|numeric|min:0',
            'max_age' => 'required|numeric|min:0|max:150',
            'discount_percentage' => 'required|numeric|min:0|max:100|unique:age_discounts,discount_percentage',
        ]);

        // The min_age must be lower than the max_age
        if($validated['min_age'] >= $validated['max_age']){
            return redirect()->back()->with('warning', 'De min leeftijd moet kleiner zijn dan de max leeftijd');
        }

        AgeDiscount::create($validated);
        return redirect()->route('age_discounts.index')->with('success', 'Leeftijd Categorie is aangemaakt');
    }

    /**
     * Toont de "Leeftijdscategorie Aanpassen" pagina met de informatie van de geselecteerde categorie.
     * @param AgeDiscount $ageDiscount
     * @return Factory|View|Application|object
     */
    public function edit(AgeDiscount $ageDiscount)
    {
        return view('age_discounts.edit', ['ageDiscount' => $ageDiscount]);
    }

    /**
     * Past een leeftijdscategorie aan, zolang de naam en kortingspercentage uniek zijn en deze niet gekoppeld is aan
     * een contributie. Ook hier moet de minimumleeftijd kleiner zijn dan de maximumleeftijd en groter dan nul.
     * @param Request $request
     * @param AgeDiscount $ageDiscount
     * @return \Illuminate\Http\RedirectResponse
     */
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
            'max_age' => 'required|numeric|min:0|max:150',
            'discount_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
                Rule::unique('age_discounts')->ignore($ageDiscount->id),
            ],
        ]);

        // The min_age must be lower than the max_age
        if($validated['min_age'] >= $validated['max_age']){
            return redirect()->back()->with('warning', 'De min leeftijd moet kleiner zijn dan de max leeftijd');
        }

        $ageDiscount->fill($validated);
        if($ageDiscount->isDirty()){
            $ageDiscount->save();
            return redirect()->route('age_discounts.edit', ['ageDiscount' => $ageDiscount])
                ->with('success', 'Categorie is aangepast');
        }

        return redirect()->back()->with('warning', 'Geen nieuwe data is gedeceteerd nog opgeslagen');
    }

    /**
     * Verwijdert een leeftijdscategorie, zolang deze niet gekoppeld is aan een contributie.
     * @param AgeDiscount $ageDiscount
     * @return \Illuminate\Http\RedirectResponse
     */
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
