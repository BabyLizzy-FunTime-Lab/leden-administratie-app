<x-layout>
    <x-headerWrapper>
        <h2>Lidmaatschappen</h2>
        <p class="lead">Hier kunt U lidmaatschappen aanmaken en bewerken.</p>
    </x-headerWrapper>
    <x-contentWrapper>
        <h2>Alle Lidmaatschappen</h2>
        <x-memberships-table :memberships="$memberships" />
    </x-contentWrapper>
    <x-contentWrapper>
        <h2>Lidmaatschap Aanmaken</h2>
        <x-memberships-create-form/>
    </x-contentWrapper>
</x-layout>
