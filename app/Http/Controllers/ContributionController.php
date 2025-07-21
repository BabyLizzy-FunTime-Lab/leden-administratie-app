<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\BookYear;
use App\Models\Membership;
use App\Models\AgeDiscount;

class ContributionController extends Controller
{
    /**
     * Toont alle contributies
     */
    public function index()
    {
        // Fetch data of their own family.
        $contributions = Contribution::with(
            'membership',
            'age_discount',
            'book_year'
        )
            ->where('name', '!=', 'personeel')
            ->orderBy('id', 'desc')
            ->paginate(8);

        $adminContribution = Contribution::where('name', 'personeel')->first();

        return view('contributions.index', [
            'contributions' => $contributions,
            'adminContribution' => $adminContribution,
        ]);
    }

    /**
     * Slaat een nieuwe contributie op, mits dat de naam unieke is.
     * De naam wordt samengesteld uit de van de geselecteerde leeftijdscategorie (ageDiscount),
     * het boekjaar (bookYear) en het lidmaatschaap (membership). Het berekent de totale contributiebedrag
     * voor de user (total_contribution_fee).
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'age_discount_id' => 'required|exists:age_discounts,id',
            'book_year_id' => 'required|exists:book_years,id',
            'membership_id' => 'required|exists:memberships,id',
        ]);

        $ageDiscount = AgeDiscount::findOrFail($validated['age_discount_id']);
        $bookYear = BookYear::findOrFail($validated['book_year_id']);
        $membership = Membership::findOrFail($validated['membership_id']);

        // Contribution names are unique. If the name exists, throw error.
        $name = $ageDiscount->name . " " . $membership->name . " " . $bookYear->name;
        if (Contribution::where('name', $name)->exists()) {
            return redirect()->back()->with('error', 'Die combinatie is al een geldige contributie.');
        }

        // The total fee is calculated based on the discount percentages.
        // The total discount may not go over 100%
        $totalDiscount = min(100,$ageDiscount->discount_percentage + $membership->discount_percentage);
        $totalFee = 100 - (100 * ($totalDiscount / 100));

        // Now we add the name and total fee to the validated inputs.
        $validated['total_contribution_fee'] = $totalFee;
        $validated['name'] = $name;

        // A new contribution is created.
        Contribution::create($validated);

        return redirect()->route('contribution.index')->with('success', 'Nieuwe Contributie is aangemaakt');
    }

    /**
     * Toont een contributie zodat je deze kunt aanpassen, behalve als het om de “personeel” contributie gaat.
     * @param Contribution $contribution
     * @return Factory|View|Application|RedirectResponse|object
     */
    public function edit(Contribution $contribution)
    {
        // The Admin contribution (personeel) may not be edited.
        if ($contribution->name == 'personeel') {
            return redirect()->route('contribution.index');
        }

        return view('contributions.edit', ['contribution' => $contribution]);
    }

    /**
     * Past een contributie aan, tenzij de nieuwe combinatie al bestaat. Hierbij wordt ook het totaalbedrag
     * (total_contribution_fee) opnieuw berekend en de naam opnieuw samengesteld
     * @param Request $request
     * @param Contribution $contribution
     * @return RedirectResponse|void
     */
    public function update(Request $request, Contribution $contribution)
    {
        $validated = $request->validate([
            'age_discount_id' => 'required|exists:age_discounts,id',
            'book_year_id' => 'required|exists:book_years,id',
            'membership_id' => 'required|exists:memberships,id',
        ]);

        // The Admin contribution may not be edited.
        if ($contribution->name == 'personeel') {
            return redirect()->route('contribution.index');
        }

        // Als de contributie gekoppeld is aan een user, kan het niet worden aangepast.
        if ($contribution->users()->exists()) {
            return redirect()->route('contribution.edit', $contribution->id)
                ->with('error', 'Deze contributie is gekoppeld aan een user en kan niet worden aangepast.');
        }

        $ageDiscount = AgeDiscount::findOrFail($validated['age_discount_id']);
        $bookYear = BookYear::findOrFail($validated['book_year_id']);
        $membership = Membership::findOrFail($validated['membership_id']);

        // Contribution names are unique. If the name exists, throw error.
        $name = $ageDiscount->name . " " . $membership->name . " " . $bookYear->name;
        if (Contribution::where('name', $name)->exists()) {
            return redirect()->back()->with('error', 'Deze combinatie is al een geldige contributie.');
        }

        // The total fee is calculated based on the discount percentages.
        // The total discount may not go over 100%
        $totalDiscount = min(100,$ageDiscount->discount_percentage + $membership->discount_percentage);
        $totalFee = 100 - (100 * ($totalDiscount / 100));

        // Now we add the name and total fee to the validated inputs.
        $validated['total_contribution_fee'] = $totalFee;
        $validated['name'] = $name;

        $contribution->fill($validated);
        if ($contribution->isDirty()) {
            $contribution->save();
            return redirect()->route('contribution.edit', $contribution->id)->with('success', 'Contributie is aangepast');
        }
    }

    /**
     * Verwijdert een contributie, tenzij het om de “personeel” contributie gaat of de contributie gekoppeld is
     * aan een gebruiker.
     * @param Contribution $contribution
     * @return RedirectResponse
     */
    public function destroy(Contribution $contribution)
    {
        if ($contribution->name == 'personeel') {
            return redirect()->route('contribution.index')
                ->with('error', 'De "personeel" contributie hoort bij een admin en kan niet verwijderd worden');
        }

        try {
            if ($contribution->delete()) {
                return redirect()->route('contribution.index')
                    ->with('success', 'Contributie is verwijderd');
            }
        } catch (QueryException $error) {
            // The contribution can't be deleted if it's assigned to a user.
            if ($error->getCode() == 23000) {
                return redirect()->route('contribution.edit', $contribution->id)
                    ->with('error', 'Contributie is gekoppeld aan een user en kan niet verwijderd worden.');
            }
        }

        // Unknown error
        return redirect()->route('contribution.index')
            ->with('error', 'Er is iets misgegaan bij het verwijderen van de contributie.');
    }
}
