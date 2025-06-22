<x-layout>
    <header>
        <div class="jumbotron mt-5">
            <div class="container">
                <h1 class="display-4">@if(auth()->user())Welkom, {{ auth()->user()->name }}@else Welkom @endif</h1>
                @if(auth()->user())
                    <p class="lead">Uw toegansniveau is: {{ auth()->user()->accessLevel->name }}</p>
                @else
                    <p class="lead">Login om te beginnen.</p>
                @endif
            </div>
        </div>
    </header>
</x-layout>
