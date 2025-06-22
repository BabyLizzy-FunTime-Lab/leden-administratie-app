<x-layout>
    <x-headerWrapper>
        @if($familyMember->id === auth()->user()->id)
            <h1>Mijn Informatie</h1>
            <p class="lead">ID: {{ $familyMember->id }}</p>
            <a class="btn btn-primary" href="#editPassword" role="button">Watchwoord Aanpassen</a>
        @else
            <h1>Familie lid: {{ $familyMember->name }}</h1>
            <p class="lead">ID: {{ $familyMember->id }}</p>
            <a class="btn btn-primary" href="{{ route('family.show', $familyMember->family_id) }}" role="button">Bekijk Familie</a>
        @endif
    </x-headerWrapper>
    <x-contentWrapper>
        <x-family-member-form :family-member="$familyMember" />
    </x-contentWrapper>
    @if($familyMember->id === auth()->user()->id)
        <x-contentWrapper id="editPassword">
            <h2>Wachtwoord Aanpassen</h2>
            <x-password-edit :user-id="auth()->user()->id"/>
        </x-contentWrapper>
    @endif
</x-layout>
