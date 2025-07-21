<x-layout>
    <x-headerWrapper>
        <h2>Contributies</h2>
        <p class="lead">Dit zijn alle contributies en kortingen die geldig zijn voor familie leden.</p>
        <p class="lead">Alleen de admin mag de "personeel" contributie hebben. De Admin contributie kan
            niet aangepast worden</p>
        <div class="page-nav d-flex flex-wrap">
            <a class="btn btn-primary" href="#contribution-form" role="button">Nieuwe Contributie</a>
            <a class="btn btn-primary" href="{{ route('book_years.index') }}" role="button">Boekjaren</a>
            <a class="btn btn-primary" href="{{ route('memberships.index') }}" role="button">Lidmaatschappen</a>
            <a class="btn btn-primary" href="{{ route('age_discounts.index') }}" role="button">Leeftijdscategorieën</a>
        </div>
    </x-headerWrapper>
    <x-contentWrapper>
        <h2>Alle Contributies</h2>
        <x-contributions-table :contributions="$contributions" :admin-contribution="$adminContribution"/>
    </x-contentWrapper>
    <x-contentWrapper>
        <h2>Nieuwe Contributie maken</h2>
        <x-contribution-form/>
    </x-contentWrapper>
</x-layout>
