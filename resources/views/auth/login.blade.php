<x-layout>
    <form action="{{ route('login') }}" method="POST" class="mt-5">
        @csrf

        <div class="form-group">
            <label for="name">Naam</label>
            <input
                name="name"
                type="text"
                class="form-control"
                id="name"
                placeholder="Enter uw naam."
                value="{{ old('name') }}"
                required
            >
        </div>
        <div class="form-group">
            <label for="password">Wachtwoord</label>
            <input
                name="password"
                type="password"
                class="form-control"
                id="password"
                placeholder="Enter Watchwoord"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</x-layout>
