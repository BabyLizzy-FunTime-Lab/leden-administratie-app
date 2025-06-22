<x-layout>
    <x-headerWrapper>
        <h2>Leeftijd Categorie Aanpassen</h2>
        <p class="lead">Leeftijd Categorieën die gekoppeld zijn aan een contributie kunnen niet aangespast worden.</p>
        <a
            class="btn btn-primary"
            href="{{ route('age_discounts.index') }}"
            role="button">
            Alle Leeftijd Categorieën
        </a>
    </x-headerWrapper>
    <x-contentWrapper>
        <form action="{{ route('age_discounts.update', $ageDiscount->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="id">Id</label>
                <input
                    readonly
                    required
                    name="id"
                    type="text"
                    class="form-control"
                    id="id"
                    placeholder="Lidmaatschap id"
                    value="{{ $ageDiscount->id }}"
                >
            </div>
            <div class="form-group">
                <label for="name">Naam</label>
                <input
                    required
                    name="name"
                    type="text"
                    class="form-control read-only-toggle"
                    id="name"
                    placeholder="Naam invoeren"
                    value="{{ old('name', $ageDiscount->name) }}"
                >
            </div>
            <div class="form-group">
                <label for="min_age">Min Leeftijd</label>
                <input
                    name="min_age"
                    type="number"
                    class="form-control"
                    id="min_age"
                    placeholder="Minimum Leeftijd invoeren"
                    value="{{ old('min_age', $ageDiscount->min_age) }}"
                >
            </div>
            <div class="form-group">
                <label for="max_age">Max Leeftijd</label>
                <input
                    name="max_age"
                    type="number"
                    class="form-control"
                    id="max_age"
                    placeholder="Maximum Leeftijd invoeren"
                    value="{{ old('max_age', $ageDiscount->max_age) }}"
                >
            </div>
            <div class="form-group">
                <label for="discount_percentage">Korting %</label>
                <input
                    required
                    name="discount_percentage"
                    type="number"
                    class="form-control read-only-toggle"
                    id="Korting"
                    placeholder="Korting invoeren"
                    value="{{ old('discount_percentage', $ageDiscount->discount_percentage) }}"
                >
            </div>
            <div class="text-center">
                <a
                    class="btn btn-info"
                    href="{{ route('age_discounts.edit', $ageDiscount->id) }}"
                    role="button">
                    Reset
                </a>
                <button
                    type="submit"
                    class="btn btn-primary">
                    Opslaan
                </button>
            </div>
        </form>
    </x-contentWrapper>
</x-layout>
