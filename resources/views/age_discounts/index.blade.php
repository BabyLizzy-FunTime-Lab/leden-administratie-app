<x-layout>
    <x-headerWrapper>
        <h2>Leeftijd Categorieën</h2>
        <p class="lead">Hier kunt U leeftijd Categorieën aanmaken en aanpassen.</p>
        <p class="lead">Leeftijd Categorieën die gekoppeld zijn aan een
            contributie kunnen niet verwijderd nog aangepast worden</p>
    </x-headerWrapper>
    <x-contentWrapper>
        <h2>Alle Leeftijd Categorieën</h2>
        <x-age-discount-table :age-discounts="$ageDiscounts"/>
    </x-contentWrapper>
    <x-contentWrapper>
        <h2>Nieuwe Leeftijd Categorie Aanmaken</h2>
        <x-age-discount-create-form/>
    </x-contentWrapper>
</x-layout>
