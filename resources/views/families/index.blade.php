<x-layout>
    <x-headerWrapper>
        <div>
            <h1>Welkom: {{ $userName }}</h1>
            <p class="lead">Toegangsniveau: {{ $accessLevel }}</p>
        </div>
        <a class="btn btn-primary" href="#nieuweFamilieToevoegen" role="button">Nieuwe Familie Toevoegen</a>
    </x-headerWrapper>
    <x-contentWrapper id="allFamilies">
        <h2>Alle Families</h2>
        <ul class="list-group">
            @foreach($families as $family)
                <x-listItem>
                    <a class="list-item_link" href="{{ route('family.show', $family->id) }}">
                        <div class="d-flex flex-column">
                            <h5>{{ $family->name }}</h5>
                            <span>{{"ID: " . $family->id }}</span>
                            <span>{{"Aantal Familie leden: " . count($family->users) }}</span>
                            <span>{{"Gemaakt op: " . $family->created_at->format('d-m-Y')}}</span>
                        </div>
                        <a class="list-item_action" href="{{ route('family.show', $family->id) }}">Bekijken</a>
                    </a>
                </x-listItem>
            @endforeach
        </ul>
        <x-paginationWrapper>
            {{ $families->links() }}
        </x-paginationWrapper>
    </x-contentWrapper>
    <x-contentWrapper id="nieuweFamilieToevoegen">
        <h2>Nieuwe Familie Toevoegen</h2>
        <x-family-form/>
    </x-contentWrapper>
</x-layout>
