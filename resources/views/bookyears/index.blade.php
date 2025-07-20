<x-layout>
    <x-headerWrapper>
        <h2>Boekjaren</h2>
        <p class="lead">Hier kunt U boekjaren maken en verwijderen</p>
    </x-headerWrapper>
    <x-contentWrapper>
        <h2>Alle Bookjaren</h2>
        <table class="table table-hover text-center">
            <thead class="thead-light">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Naam</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($bookYears) == 0)
                <tr>
                    <td colspan="3">Geen contributies gevonden</td>
                </tr>
            @else
                @foreach($bookYears as $bookYear)
                    <tr>
                        <td>{{ $bookYear->id }}</td>
                        <td>{{ $bookYear->name }}</td>
                        <td>
                            <form action="{{ route('book_years.delete', $bookYear->id) }}" method="POST">
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
        <x-paginationWrapper>
            {{ $bookYears->links() }}
        </x-paginationWrapper>
    </x-contentWrapper>
    <x-contentWrapper>
        <h2>Nieuwe Bookjaar aanmaken</h2>
        <form id="book-year-form" action="{{ route('book_years.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Jaar</label>
                <input
                    name="name"
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Jaar invoeren"
                    value="{{ old('name') }}"
                >
            </div>
            <div class="text-center">
                <button
                    type="submit"
                    class="btn btn-primary">
                    Opslaan
                </button>
            </div>
        </form>
    </x-contentWrapper>
</x-layout>
