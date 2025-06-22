@props([
    'contributions' => null,
    'adminContribution' => null
    ] )

<table class="table table-hover text-center">
    <thead class="thead-light">
    <tr>
        <th scope="col">Naam</th>
        <th scope="col">min Leeftijd</th>
        <th scope="col">max Leeftijd</th>
        <th scope="col">Leeftijd Categorie</th>
        <th scope="col">Leeftijd Korting %</th>
        <th scope="col">Lidmaatschap</th>
        <th scope="col">Lidmaatschap Korting %</th>
        <th scope="col">Boekjaar</th>
        <th scope="col">Totaal Bedrag</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @if(count($contributions) == 0)
        <tr>
            <td colspan="9">Geen contributies gevonden</td>
        </tr>
    @else
        <tr>
            <td>{{ $adminContribution->name }}</td>
            <td>{{ $adminContribution->age_discount->min_age }}</td>
            <td>{{ $adminContribution->age_discount->max_age }}</td>
            <td>{{ $adminContribution->age_discount->name }}</td>
            <td>{{ $adminContribution->age_discount->discount_percentage }}</td>
            <td>{{ $adminContribution->membership->name }}</td>
            <td>{{ $adminContribution->membership->discount_percentage }}</td>
            <td>{{ $adminContribution->book_year->name }}</td>
            <td>€{{ $adminContribution->total_contribution_fee }}</td>
            <td>Geen aanpassingen</td>
        </tr>
        @foreach($contributions as $contribution)
            <tr>
                <td>{{ $contribution->name }}</td>
                <td>{{ $contribution->age_discount->min_age }}</td>
                <td>{{ $contribution->age_discount->max_age }}</td>
                <td>{{ $contribution->age_discount->name }}</td>
                <td>{{ $contribution->age_discount->discount_percentage }}</td>
                <td>{{ $contribution->membership->name }}</td>
                <td>{{ $contribution->membership->discount_percentage }}</td>
                <td>{{ $contribution->book_year->name }}</td>
                <td>€{{ $contribution->total_contribution_fee }}</td>
                <td>
                    <a
                        class="btn btn-primary"
                        href="{{ route('contribution.edit', $contribution->id) }}"
                        role="button">
                        Bewerken
                    </a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
<x-paginationWrapper>
    {{ $contributions->links() }}
</x-paginationWrapper>
