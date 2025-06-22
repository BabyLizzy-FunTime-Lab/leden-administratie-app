<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Leden Administratie</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
{{-- Show session messages--}}
<x-session-success/>
<x-session-warning/>
<x-session-error/>
{{--Show errors--}}
<x-errors-show/>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand mb-0 h1" href="{{ route('welcome') }}">Leden Administratie</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @guest
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('show.login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            @endguest
            @auth
                {{--This is for the admin--}}
                @if(auth()->user()->accessLevel?->name === 'admin')
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('family.index') }}">Hallo, admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('family.index') . "#allFamilies" }}">Alle Families</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('family.index') . "#nieuweFamilieToevoegen" }}">Nieuwe Familie</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contribution.index') }}">Contributies</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('family_member.show', auth()->user()->id) }}">Mijn info</a>
                            </li>
                        </ul>
                        <form action="{{ route('logout') }}" class="form-inline my-2 my-lg-0">
                            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Logout</button>
                        </form>
                    </div>
                @endif

                {{--This is for family users--}}
                @if(auth()->user()->accessLevel?->name !== 'admin')
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('family.index') }}">Hallo, {{ Auth::user()->name }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('family.index') }}">Mijn Family</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('family_member.show', auth()->user()->id) }}">Mijn info</a>
                            </li>
                        </ul>
                        <form action="{{ route('logout') }}" class="form-inline my-2 my-lg-0">
                            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Logout</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </nav>
</header>
<main class="container">
    {{ $slot }}
</main>
<footer class="bg-body-tertiary text-center">
    <div class="footer-content text-center p-3">
        <a class="text-body" href="#">Terug naar boven</a>
        <p> © 2025 Copyright</p>
    </div>
</footer>
</body>
</html>
