{{--
    This form is used for the creation, editing and viewing of User (family menber) data
    This view is part of class component FamilyMemberForm.php.

    The $forUpdating method checks if the form recieved user data.
    If data was recievd the form renders ready to update user data.

    If the form recieves no user data it renders ready to create a
    new user.
--}}
<form
    id="family-member-form"
    action="{{ $forUpdating() ? route('family_member.update', $familyMemberId()) : route('family_member.store') }}"
    method="POST"
>
    @csrf

    @if($forUpdating())
        @method('PUT')
    @endif

{{--
    When the form is used to create a new user.
    The family id is passed via the $familIdProp into a hidden input
    so the user (family member) can be added to the correct family
    in the Controller.
--}}
    @if(!$forUpdating())
        <div>
            <input
                hidden
                name="family_id"
                type="text"
                class="form-control read-only-toggle"
                id="family_id"
                placeholder="Familie ID"
                value="{{ $familyIdProp }}"
            >
        </div>
    @endif

    <div class="form-group">
        <label for="name">Naam</label>
        <input
            @if($forUpdating()) readonly @endif
            required
            name="name"
            type="text"
            class="form-control read-only-toggle"
            id="name"
            placeholder="Naam"
            value="{{ $name() }}"
        >
    </div>
    @if($forUpdating())
        <div class="form-group">
            <label for="access_level_name">Toegangsniveau</label>
            <input
                readonly
                required
                name="access_level_name"
                type="text"
                class="form-control"
                id="access_level_name"
                placeholder="Selecteer Toegangsniveau"
                value="{{ $accessLevelName() }}"
            >
        </div>
    @endif
    <div class="form-group">
        <label for="date_of_birth">Geboortedatum</label>
        <input
            @if($forUpdating()) readonly @endif
            required
            name="date_of_birth"
            type="date"
            class="form-control read-only-toggle"
            id="date_of_birth"
            placeholder="Selecteer Geboortedatum"
            value="{{ $dateOfBirth() }}"
        >
    </div>
    <div class="form-group" @if($accessLevelName() == 'admin' ) hidden @endif>
        <div>
            <label for="age_discount_id">Leeftijd Categorie</label>
        </div>
        <select
            name="age_discount_id"
            id="age_discount_id"
            class="form-select w-100 custom-form-select read-only-toggle"
            aria-label=".form-select-lg"
            @if($forUpdating()) disabled @endif
            required
        >
            {{--If the form is used for updating it doesn't need the standaard value.--}}
            <option value="0" @if(!$forUpdating())selected @endif>
                Selecteer de Leeftijd Categorie
            </option>

            @php
                // Here we exclude the admin discount from the options if we are processing user data.
                $discountsInForm = $accessLevelName() == 'admin' ? $ageDiscounts : $ageDiscountsNoAdmin;
            @endphp

            @foreach($discountsInForm as $ageDiscount)
                <option
                    value="{{ $ageDiscount->id }}"
                    @if($ageDiscountId() == $ageDiscount->id) selected @endif
                >
                    {{ $ageDiscount->name }}: {{ $ageDiscount->min_age }} t/m {{ $ageDiscount->max_age }} jaar
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group" @if($accessLevelName() == 'admin' ) hidden @endif>
        <div>
            <label for="membership_id">Lidmaatschap</label>
        </div>
        <select
            name="membership_id"
            id="membership_id"
            class="form-select w-100 custom-form-select read-only-toggle"
            aria-label=".form-select-lg"
            @if($forUpdating()) disabled @endif
            required
        >
            {{--If the form is used for updating it doesn't need the standaard value to be selected.--}}
            <option value="0" @if(!$forUpdating())selected @endif>
                Selecteer de Lidmaatschap
            </option>

            @php
                // Here we exclude the admin memberships from the options if we are processing user data.
                $membershipsInForm = $accessLevelName() == 'admin' ? $memberships : $membershipsNoAdmin;
            @endphp

            @foreach($membershipsInForm as $membership)
                <option
                    value="{{ $membership->id }}"
                    @if($membershipId() == $membership->id) selected @endif
                >
                    {{ $membership->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group" @if($accessLevelName() == 'admin' ) hidden @endif>
        <div>
            <label for="book_year_id">Boekjaar</label>
        </div>
        <select
            name="book_year_id"
            class="form-select w-100 custom-form-select read-only-toggle"
            aria-label=".form-select-lg"
            @if($forUpdating()) disabled @endif
            required
        >
            {{--If the form is used for updating it doesn't need the standaard value to be selcted.--}}
            <option value="0" @if(!$forUpdating())selected @endif>
                Selecteer de boekjaar
            </option>

            @php
                // Here we exclude the admin memberships from the options if we are processing user data.
                $bookYearsInForm = $accessLevelName() == 'admin' ? $bookYears : $bookYearsNoAdmin;
            @endphp

            @foreach($bookYearsInForm as $bookYear)
                <option
                    value="{{ $bookYear->id }}"
                    @if($bookYearId() == $bookYear->id) selected @endif
                >
                    {{ $bookYear->name }}
                </option>
            @endforeach
        </select>
    </div>
    @if($forUpdating())
        <div class="form-group" @if($accessLevelName() == 'admin' ) hidden @endif>
            <label for="contribution_name">Contributie</label>
            <input
                readonly
                required
                name="contribution_name"
                type="text"
                class="form-control"
                id="contribution_name"
                placeholder="Contributie"
                value="{{ $contributionName() }}"
            >
        </div>
        <div class="form-group" @if($accessLevelName() == 'admin' ) hidden @endif>
            <label for="total_contribution_fee">Contributie Bedrag</label>
            <input
                readonly
                required
                name="total_contribution_fee"
                type="text"
                class="form-control"
                id="total_contribution_fee"
                placeholder="Contributie Bedrag"
                value="{{ $totalContributionFee() }}"
            >
        </div>
    @endif
    <div class="form-group">
        <label for="email">email</label>
        <input
            @if($forUpdating()) readonly @endif
            required
            name="email"
            type="email"
            class="form-control read-only-toggle"
            id="email"
            placeholder="email"
            value="{{ $email() }}"
        >
    </div>
    @if($forUpdating())
        <div class="form-group" @if($accessLevelName() == 'admin' ) hidden @endif>
            <label for="family_id">Familie ID</label>
            <input
                readonly
                required
                name="family_id"
                type="text"
                class="form-control read-only-toggle"
                id="family_id"
                placeholder="Voer in Familie ID"
                value="{{ $familyId() }}"
            >
        </div>
        <div class="form-group">
            <label for="family_name">Behoort tot Familie</label>
            <input
                readonly
                required
                name="family_name"
                type="text"
                class="form-control"
                id="family_name"
                placeholder="family_name"
                value="{{ $familyName() }}"
            >
        </div>
    @endif
    <div class="form-group" @if($accessLevelName() == 'admin' ) hidden @endif>
        <div>
            <label for="family_role_id">Rol Binnen Familie</label>
        </div>
        <select
            name="family_role_id"
            class="form-select w-100 custom-form-select read-only-toggle"
            aria-label=".form-select-lg"
            @if($forUpdating()) disabled @endif
            required
        >
            {{--If the form is used for updating it doesn't need the standaard value to be selected.--}}
            <option value="0" @if(!$forUpdating())selected @endif>
                Selecteer Rol Binnen Familie
            </option>

            @php
                // Here we exclude the admin family Roles from the options if we are processing user data.
                $familyRolesInForm = $accessLevelName() == 'admin' ? $familyRoles : $familyRolesNoAdmin;
            @endphp

            @foreach($familyRolesInForm as $familyRole)
                <option
                    value="{{ $familyRole->id }}"
                    @if($familyRoleId() == $familyRole->id) selected @endif
                >
                    {{ $familyRole->name }}
                </option>
            @endforeach
        </select>
    </div>
    @if(auth()->user()->accessLevel->name == 'admin')
        <div class="text-center">
            @if($forUpdating())
                <button
                    id="read-only-toggle-button"
                    type="button"
                    class="btn btn-primary"
                    onclick="toggleReadOnlyFamilyMemberForm()">
                    Aanpassen
                </button>
            @else
                <button
                    id="read-only-toggle-button"
                    type="submit"
                    class="btn btn-primary">
                    Opslaan
                </button>
            @endif
        </div>
    @endif
</form>
@if( $forUpdating() && auth()->user()->accessLevel->name == 'admin' )
    <div id="read-only-controls" class="d-none">
        <form class="pb-0" action="{{ route('family_member.delete', $familyMemberId()) }}" method="POST">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="btn btn-danger">
                Verwijder Lid
            </button>
        </form>
        <div class="d-flex">
            <form class="pb-0" action="{{ route('family_member.show', $familyMemberId()) }}" method="GET">
                @csrf
                <button
                    type="submit"
                    class="btn btn-info"
                    onclick="toggleReadOnlyFamilyMemberForm()">
                    Terug
                </button>
            </form>
            <div>
                <button
                    type="submit"
                    form="family-member-form"
                    class="btn btn-primary ml-1">
                    Opslaan
                </button>
            </div>
        </div>
    </div>
@endif
