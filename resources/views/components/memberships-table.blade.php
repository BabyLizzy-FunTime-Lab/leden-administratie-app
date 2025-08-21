@props([
    'memberships' => null
])

<div class="table-container">
    <table class="table table-hover text-center">
        <thead class="thead-light">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Naam</th>
            <th scope="col">Korting %</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @if(count($memberships) == 0)
            <tr>
                <td colspan="5">Geen lidmaatschappen gevonden</td>
            </tr>
        @else
            @foreach($memberships as $membership)
                <tr>
                    <td>{{ $membership->id }}</td>
                    <td>{{ $membership->name }}</td>
                    <td>{{ $membership->discount_percentage }}</td>
                    <td>
                        <a
                            class="btn btn-primary"
                            href="{{ route('memberships.edit', $membership->id) }}"
                            role="button">
                            Aanpassen
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('memberships.delete', $membership->id) }}" method="POST">
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
        </tbody>
    </table>
</div>
<x-paginationWrapper>
    {{ $memberships->links() }}
</x-paginationWrapper>
