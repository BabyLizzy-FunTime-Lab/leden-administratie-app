{{--This form is used for storing and editing family information--}}
@props(['familyInfo' => null] )

{{--The action changes depending on the roll the form needs to play.--}}
<form
    id="family-form"
    action="{{ $familyInfo ? route('family.update', $familyInfo->id) : route('family.store') }}"
    method="POST"
>
    @csrf

    @if($familyInfo)
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="name">Naam</label>
        <input
            @if($familyInfo) readonly @endif
            name="name"
            type="text"
            class="form-control read-only-toggle-family-form"
            id="name"
            placeholder="Naam Invoeren"
            value="{{ old('name', $familyInfo?->name ?? '') }}"
        >
    </div>
    <div class="form-group">
        <label for="address">Adres</label>
        <input
            @if($familyInfo) readonly @endif
            name="address"
            type="text"
            class="form-control read-only-toggle-family-form"
            id="address"
            placeholder="Adres Invoeren"
            value="{{ old('address', $familyInfo?->address ?? '') }}"
        >
    </div>
    <div class="text-center" id="read-only-toggle-button-container">
        @if($familyInfo)
            <button
                type="button"
                class="btn btn-primary"
                onclick="toggleReadOnlyFamilyForm()">
                Aanpassen
            </button>
        @else
            <button
                type="submit"
                class="btn btn-primary">
                Opslaan
            </button>
        @endif
    </div>
</form>
@if($familyInfo)
    <div id="read-only-controls-container" class="d-none">
        <form class="pb-0" action="{{ route('family.delete', $familyInfo->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="btn btn-danger">
                Verwijder Familie en leden
            </button>
        </form>
        <div class="d-flex">
            <form class="pb-0" action="{{ route('family.show', $familyInfo->id) }}" method="GET">
                @csrf
                <button
                    type="submit"
                    class="btn btn-info"
{{--                    onclick="toggleReadOnlyFamilyForm()"--}}
                >
                    Terug
                </button>
            </form>
            <div>
                <button
                    type="submit"
                    form="family-form"
                    class="btn btn-primary ml-1">
                    Opslaan
                </button>
            </div>
        </div>
    </div>
@endif
