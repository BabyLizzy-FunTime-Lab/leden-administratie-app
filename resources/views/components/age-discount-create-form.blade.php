<form action="{{ route('age_discounts.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Naam</label>
        <input
            name="name"
            type="text"
            class="form-control"
            id="name"
            placeholder="Naam invoeren"
            value="{{ old('name') }}"
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
            value="{{ old('min_age') }}"
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
            value="{{ old('max_age') }}"
        >
    </div>
    <div class="form-group">
        <label for="discount_percentage">Korting %</label>
        <input
            name="discount_percentage"
            type="number"
            class="form-control"
            id="discount_percentage"
            placeholder="Korting percentage invoeren"
            value="{{ old('discount_percentage') }}"
        >
    </div>
    <div class="text-center">
        <button
            type="submit"
            class="btn btn-primary">
            Opslaan
        </button>
    </div>
</form>
