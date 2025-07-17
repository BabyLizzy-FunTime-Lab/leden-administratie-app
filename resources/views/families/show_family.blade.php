<x-layout>
    <x-headerWrapper>
        @if(auth()->user()->accessLevel?->name !== 'admin')
            <h1>Mijn Familie: {{ $family->name }}</h1>
            <p class="lead"> Familie ID: {{ $family->id }}</p>
            <p class="lead"> Familie Address: {{ $family->address }}</p>
        @else
            <h1>Familie: {{ $family->name }}</h1>
            <p class="lead"> Familie ID: {{ $family->id }}</p>
            <p class="lead"> Familie Address: {{ $family->address }}</p>
            <a class="btn btn-primary" href="#addNewFamilyMember" role="button">Familie Lid Toevoegen</a>
            <a class="btn btn-primary" href="#editFamily" role="button">Familie info Aanpassen</a>
        @endif
    </x-headerWrapper>
    <x-contentWrapper>
        <h3>Alle Familie Leden</h3>
        @if(count($family->users) == 0)
            <p>Geen familie leden zijn gevonden.</p>
        @else
            <ul class="list-group">
                @foreach($family->users as $user)
                    <x-listItem>
                        <a class="list-link" href="{{ route('family_member.show', $user->id) }}">
                            <h5>{{ $user->name }}</h5>
                        </a>
                        <a href="{{ route('family_member.show', $user->id) }}">Bekijken</a>
                    </x-listItem>
                @endforeach
            </ul>
        @endif
    </x-contentWrapper>
    <x-contentWrapper>
        <h3>Gezamelijk Contributie Bedrag</h3>
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">Naam</th>
                <th scope="col">Leeftijd categorie</th>
                <th scope="col">Lidmaatschap</th>
                <th scope="col">Bedrag</th>
            </tr>
            </thead>
            <tbody>
            @if(count($family->users) == 0)
                <tr>
                    <td colspan="4">Geen familie leden zijn gevonden.</td>
                </tr>
            @else
                @foreach($family->users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->contribution->age_discount->name }}</td>
                        <td>{{ $user->membership->name }}</td>
                        <td>€{{ $user->contribution->total_contribution_fee }}</td>
                    </tr>
                @endforeach
            @endif
            @php
                $total = $family->users->sum(fn($user) => $user->contribution->total_contribution_fee);
            @endphp
            <tr>
                <td colspan="2"></td>
                <td class="bg-info"><strong>Totaal:</strong></td>
                <td class="bg-info">
                    <strong>
                        €{{ number_format($total, 2, ',', '.') }}
                    </strong>
                </td>
            </tr>
            </tbody>
        </table>
    </x-contentWrapper>
    @if(auth()->user()->accessLevel?->name == 'admin')
        <x-contentWrapper id="addNewFamilyMember">
            <h3>Familie Lid Toevoegen</h3>
            <x-family-member-form :family-id-prop="$family->id" />
        </x-contentWrapper>
        <x-contentWrapper id="editFamily">
            <h3>Familie info Aanpassen</h3>
            <x-family-form :family-info="$family"/>
        </x-contentWrapper>
    @endif
</x-layout>
