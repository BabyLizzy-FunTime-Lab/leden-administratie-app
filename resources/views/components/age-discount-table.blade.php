@props([
    'ageDiscounts' => null
])

<table class="table table-hover text-center">
    <thead class="thead-light">
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Naam</th>
        <th scope="col">Min Leeftijd</th>
        <th scope="col">Max Leeftijd</th>
        <th scope="col">Korting %</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    @if(count($ageDiscounts) == 0)
        <tr>
            <td colspan="7">Geen contributies gevonden</td>
        </tr>
    @else
        @foreach($ageDiscounts as $ageDiscount)
            <tr>
                <td>{{ $ageDiscount->id }}</td>
                <td>{{ $ageDiscount->name }}</td>
                <td>{{ $ageDiscount->min_age }}</td>
                <td>{{ $ageDiscount->max_age }}</td>
                <td>{{ $ageDiscount->discount_percentage }}</td>
                <td>
                    <a
                        class="btn btn-primary"
                        href="{{ route('age_discounts.edit', $ageDiscount->id) }}"
                        role="button">
                        Aanpassen
                    </a>
                </td>
                <td>
                    <form action="{{ route('age_discounts.delete', $ageDiscount->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="btn btn-danger"
                            type="submit"
                            role="button">
                            Verwijder
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    @endif
</table>
<x-paginationWrapper>
    {{ $ageDiscounts->links() }}
</x-paginationWrapper>
