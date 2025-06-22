<form action="{{ route('memberships.store') }}" method="POST">
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
