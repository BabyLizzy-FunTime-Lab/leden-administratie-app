<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use App\Models\BookYear;
use App\Models\Membership;
use App\Models\AgeDiscount;
use App\Models\FamilyRole;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class FamilyMemberForm extends Component
{
    public ?User $familyMember;
    public ?string $familyIdProp;
    public Collection $bookYears;

    public Collection $memberships;
    public Collection $ageDiscounts;
    public Collection $familyRoles;

    public Collection $bookYearsNoAdmin;
    public Collection $membershipsNoAdmin;

    public Collection $ageDiscountsNoAdmin;
    public Collection $familyRolesNoAdmin;

    /**
     * Create a new component instance.
     */
    public function __construct(User $familyMember = null, ?string $familyIdProp = null)
    {
        $this->familyMember = $familyMember;
        $this->familyIdProp = $familyIdProp;
        $this->bookYears = BookYear::all();
        $this->memberships = Membership::all();
        $this->ageDiscounts = AgeDiscount::all();
        $this->familyRoles = FamilyRole::all();
        $this->bookYearsNoAdmin = BookYear::where('name', '!=', 'n.v.t.')->get();
        $this->membershipsNoAdmin = Membership::where('name', '!=', 'personeel')->get();
        $this->ageDiscountsNoAdmin = AgeDiscount::where('name', '!=', 'personeel')->get();
        $this->familyRolesNoAdmin = FamilyRole::where('name', '!=', 'n.v.t.')->get();
    }

    public function forUpdating(): ?User
    {
        return $this->familyMember;
    }

    public function name(): string
    {
        return old('name', $this->familyMember?->name ?? '');
    }

    public function accessLevelName(): string
    {
        return old('access_level_name', $this->familyMember?->accessLevel?->name ?? '');
    }

    public function dateOfBirth(): string
    {
        return old('date_of_birth', $this->familyMember?->date_of_birth ?? '');
    }

    public function ageDiscountId(): string
    {
        return old('age_discount_id', $this->familyMember?->contribution?->age_discount?->id ?? '');
    }

    public function membershipId(): string
    {
        return old('membership_id', $this->familyMember?->membership?->id ?? '');
    }

    public function contributionName(): string
    {
        return old('contribution_name', $this->familyMember?->contribution?->name ?? '');
    }

    public function bookYearId(): string
    {
        return old('book_year_id', $this->familyMember?->contribution?->book_year?->id ?? '');
    }

    public function totalContributionFee(): string
    {
        $fee = old('total_contribution_fee', $this->familyMember?->contribution?->total_contribution_fee ?? '');

        // Avoid double € symbols when old() is used to populate the input after a validation error.
        if (!Str::startsWith($fee, '€') && is_numeric($fee)) {
            return '€' . $fee;
        }

        return $fee;
    }

    public function email(): string
    {
        return old('email', $this->familyMember?->email ?? '');
    }

    public function familyName(): string
    {
        return old('family_name', $this->familyMember?->family?->name ?? '');
    }

    public function familyId(): string
    {
        return old('family_id', $this->familyMember?->family?->id ?? '');
    }

    public function familyRoleId(): string
    {
        return old('family_role_id', $this->familyMember?->familyRole?->id ?? '');
    }

    public function familyMemberId(): string
    {
        return old('family_member_id', $this->familyMember?->id ?? '');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.family-member-form');
    }
}
