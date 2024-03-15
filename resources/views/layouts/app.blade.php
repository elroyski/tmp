<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
     <style>
        .side-menu {
            margin-top: 20px; 
        }
        .active-link {
		background-color: #5cbcd7; 
		color: white;
		}
    
		.list-group-item.active-link:hover {
		background-color: #5cbcd7; 
		color: white; 
		}
        
    </style>
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    System raportowania Empik
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto" style="float:right">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item me-2">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
@auth    
   <div class="container-fluid">
         <div class="row">
                <!-- Boczne Menu -->
                <div class="col-md-3 side-menu">
                    <div class="list-group">
            
<a href="{{ url('/home') }}" class="list-group-item list-group-item-action {{ request()->is('home') ? 'active-link' : '' }}">Home</a>
<a href="{{ url('/import') }}" class="list-group-item list-group-item-action {{ request()->is('import') ? 'active-link' : '' }}">Import manualny CSV</a>
<a href="{{ url('/raporty-handlowe') }}" class="list-group-item list-group-item-action {{ request()->is('raporty-handlowe') ? 'active-link' : '' }}">Raporty handlowe</a>

<li class="list-group-item list-group-item-action" data-bs-toggle="collapse" aria-expanded="false" id="toggle-stats-submenu">Statystyki</li>

<a href="{{ url('/daily-stats') }}" class="list-group-item list-group-item-action {{ request()->is('daily-stats', 'daily-stats/*') ? 'active-link' : '' }}"><span class="ms-3">Książki dzienne</span></a>
<a href="{{ url('/monthly-stats') }}" class="list-group-item list-group-item-action {{ request()->is('monthly-stats', 'monthly-stats/*') ? 'active-link' : '' }}"><span class="ms-3">Książki miesięczne</span></a>
<a href="{{ url('/annual-stats') }}" class="list-group-item list-group-item-action {{ request()->is('annual-stats', 'annual-stats/*') ? 'active-link' : '' }}"><span class="ms-3">Ilości miesięczne</span></a>

<a href="{{ url('/top-authors-daily') }}" class="list-group-item list-group-item-action {{ request()->is('top-authors-daily', 'top-authors-daily/*') ? 'active-link' : '' }}"><span class="ms-3">Autorzy dziennie</span></a>

<a href="{{ url('/top-authors') }}" class="list-group-item list-group-item-action {{ request()->is('top-authors', 'top-authors/*') ? 'active-link' : '' }}"><span class="ms-3">Autorzy miesięcznie</span></a>

<a href="{{ url('/top-stores') }}" class="list-group-item list-group-item-action {{ request()->is('top-stores', 'top-stores/*') ? 'active-link' : '' }}"><span class="ms-3">Punkty sprzedaży</span></a>
<a href="{{ url('/inventory') }}" class="list-group-item list-group-item-action {{ request()->is('inventory', 'inventory/*') ? 'active-link' : '' }}"><span class="ms-3">Zapas książek</span></a>

<a href="{{ url('/elibri') }}" class="list-group-item list-group-item-action {{ request()->is('elibri') ? 'active-link' : '' }}">Baza książek i autorów Elibri</a>
<a href="{{ url('/users') }}" class="list-group-item list-group-item-action {{ request()->is('users') ? 'active-link' : '' }}">Użytkownicy SQN</a>
<a href="{{ url('/authors') }}" class="list-group-item list-group-item-action {{ request()->is('authors') ? 'active-link' : '' }}">Autorzy SQN</a>
<a href="{{ url('/config') }}" class="list-group-item list-group-item-action {{ request()->is('config') ? 'active-link' : '' }}">Konfiguracja</a>
	



                        <!-- tutaj inne linki -->
                
				</div>
                </div>
@endauth

       <!-- Główna treść -->
                @auth
                    <div class="col-md-9">
                        <main class="py-4">
                            @yield('content')
                        </main>
                    </div>
                @else
                    <div class="col-md-12">
                        <main class="py-4">
                            @yield('content')
                        </main>
                    </div>
                @endauth

                
                
       </div>
    
            
        </div>
    </div>


</body>
</html>
