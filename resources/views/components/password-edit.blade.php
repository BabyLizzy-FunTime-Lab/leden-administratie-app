@props(['userId' => null] )

<form action="{{ route( 'password.update') }}" method="POST">
    @csrf
    @method('PUT')

    <input hidden name="user_id" type="text" value="{{ $userId }}">
    <div class="form-group">
        <label for="password">Wachtwoord</label>
        <input
            name="password"
            type="password"
            class="form-control"
            id="password"
            placeholder="Wachtwoord Invoeren"
        >
    </div>
    <div class="form-group">
        <label for="new_password">Nieuwe Wachtwoord</label>
        <input
            name="new_password"
            type="password"
            class="form-control"
            id="new_password"
            placeholder="Nieuwe Wachtwoord Invoeren"
        >
    </div>
    <div class="form-group">
        <label for="new_password_confirmation">Nieuwe Wachtwoord Confirmatie</label>
        <input
            name="new_password_confirmation"
            type="password"
            class="form-control"
            id="new_password_confirmation"
            placeholder="Nieuwe Password Confirmatie"
        >
    </div>
    <button type="submit" class="btn btn-primary">
        Opslaan
    </button>
</form>
