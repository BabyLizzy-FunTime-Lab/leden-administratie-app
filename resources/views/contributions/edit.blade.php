<x-layout>
    <x-headerWrapper>
        <h2>Contributie Bewerken</h2>
        <p class="lead">Hier kunt U een bestaande contributie aanpassen of verwijderen.</p>
        <p class="lead">Als de contributie toegewezen is aan een user, kan het niet verwijderd worden.</p>
    </x-headerWrapper>
    <x-contentWrapper>
        <x-contribution-form :contribution="$contribution"/>
    </x-contentWrapper>
</x-layout>
