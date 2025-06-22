<x-layout>
    <x-headerWrapper>
        <h2>Lidmaatschap Aanpassen</h2>
        <p class="lead">Hier kunt U de lidmaatschap aanpassen. </p>
        <p class="lead">Lidmaatschappen die gekoppeld zijn aan een familie
            lid en/of contributie kunnen niet worden aangepast</p>
        <a
            class="btn btn-primary"
            href="{{ route('memberships.index') }}"
            role="button">
            Alle Lidmaatschappen
        </a>
    </x-headerWrapper>
    <x-contentWrapper>
        <form action="{{ route('memberships.update', $membership->id) }}" method="POST">
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
                    value="{{ $membership->id }}"
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
                    value="{{ $membership->name }}"
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
                    value="{{ $membership->discount_percentage }}"
                >
            </div>
            <div class="text-center">
                <a
                    class="btn btn-info"
                    href="{{ route('memberships.edit', $membership->id) }}"
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
