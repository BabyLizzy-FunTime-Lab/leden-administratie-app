<form
    id="contribution-form"
    action="{{ $forUpdating() ? route('contribution.update', $contributionId()) : route('contribution.store') }}"
    method="POST"
>
    @csrf

    {{--When updating the method is PUT--}}
    @if($forUpdating())
        @method('PUT')
    @endif

    @if($forUpdating())
        <div class="form-group">
            <label for="name">Naam</label>
            <input
                readonly
                required
                name="name"
                type="text"
                class="form-control"
                id="name"
                placeholder="Categorie Naam"
                value="{{ $name() }}"
            >
        </div>
        <div class="form-group">
            <label for="total_contribution_fee">Totaal Bedrag</label>
            <input
                readonly
                required
                name="total_contribution_fee"
                type="text"
                class="form-control"
                id="total_contribution_fee"
                placeholder="Euros"
                value="{{ $totalContributionFee() }}"
            >
        </div>
    @endif

    <div class="form-group">
        <div>
            <label for="age_discount_id">Leeftijdscategorie</label>
        </div>
        <select
            name="age_discount_id"
            id="age_discount_id"
            class="form-select w-100 custom-form-select read-only-toggle"
            aria-label=".form-select-lg"
            @if($forUpdating()) disabled @endif
            required
        >
            <option value="0">
                Selecteer de Leeftijdscategorie
            </option>

            @foreach($ageDiscounts as $ageDiscount)
                <option
                    value="{{ $ageDiscount->id }}"
                    @if($ageDiscountId() == $ageDiscount->id) selected @endif
                >
                    {{ $ageDiscount->name }}: {{ $ageDiscount->min_age }} t/m {{ $ageDiscount->max_age }} jaar
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
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
            <option value="0">
                Selecteer de Lidmaatschap
            </option>

            @foreach($memberships as $membership)
                <option
                    value="{{ $membership->id }}"
                    @if($membershipId() == $membership->id) selected @endif
                >
                    {{  $membership->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <div>
            <label for="book_year_id">Boekjaar</label>
        </div>
        <select
            name="book_year_id"
            id="book_year_id"
            class="form-select w-100 custom-form-select read-only-toggle"
            aria-label=".form-select-lg"
            @if($forUpdating()) disabled @endif
            required
        >
            <option value="0">
                Selecteer de Boek Jaar
            </option>

            @foreach($bookYears as $bookYear)
                <option
                    value="{{ $bookYear->id }}"
                    @if($bookYearId() == $bookYear->id) selected @endif
                >
                    {{ $bookYear->name }}
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
            <form class="pb-0" action="{{ route('contribution.delete', $contributionId()) }}" method="POST">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="btn btn-danger">
                    Verwijder Contributie
                </button>
            </form>
            <div class="d-flex">
                <form class="pb-0" action="{{ route('contribution.edit', $contributionId()) }}" method="GET">
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
                        form="contribution-form"
                        class="btn btn-primary ml-1">
                        Opslaan
                    </button>
                </div>
            </div>
        </div>
    @endif
