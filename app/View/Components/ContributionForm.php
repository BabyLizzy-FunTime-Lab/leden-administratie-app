<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use App\Models\BookYear;
use App\Models\Membership;
use App\Models\AgeDiscount;
use App\Models\Contribution;

class ContributionForm extends Component
{
    public ?Contribution $contribution;
    public Collection $bookYears;

    public Collection $memberships;
    public Collection $ageDiscounts;

    /**
     * Create a new component instance.
     */
    public function __construct(Contribution $contribution = null)
    {
        $this->contribution = $contribution;
        $this->bookYears = BookYear::where('name', '!=', 'n.v.t.')->get();
        $this->memberships = Membership::where('name', '!=', 'personeel')->get();
        $this->ageDiscounts = AgeDiscount::where('name', '!=', 'personeel')->get();
    }

    public function forUpdating(): ?Contribution
    {
        return $this->contribution;
    }

    public function name(): string
    {
        return old('name', $this->contribution?->name ?? '');
    }

    public function contributionId(): string
    {
        return old('name', $this->contribution?->id ?? '');
    }

    public function totalContributionFee(): string
    {
        return old('totalContributionFee', $this->contribution?->total_contribution_fee ?? '');
    }

    public function ageDiscountId(): string
    {
        return old('ageDiscountId', $this->contribution?->age_discount_id ?? '');
    }

    public function membershipId(): string
    {
        return old('membershipId', $this->contribution?->membership_id ?? '');
    }

    public function bookYearId(): string
    {
        return old('bookYearId', $this->contribution?->book_year_id ?? '');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.contribution-form');
    }
}
