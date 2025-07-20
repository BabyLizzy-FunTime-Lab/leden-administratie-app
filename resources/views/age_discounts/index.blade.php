<x-layout>
    <x-headerWrapper>
        <h2>Leeftijdscategorieën</h2>
        <p class="lead">Hier kunt U leeftijdscategorieën aanmaken en aanpassen.</p>
        <p class="lead">Leeftijdscategorieën die gekoppeld zijn aan een
            contributie kunnen niet verwijderd nog aangepast worden</p>
    </x-headerWrapper>
    <x-contentWrapper>
        <h2>Alle Leeftijdscategorieën</h2>
        <x-age-discount-table :age-discounts="$ageDiscounts"/>
    </x-contentWrapper>
    <x-contentWrapper>
        <h2>Nieuwe Leeftijdscategorie Aanmaken</h2>
        <x-age-discount-create-form/>
    </x-contentWrapper>
</x-layout>
