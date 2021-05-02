<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
html {
    height: 100%;
}
body {
    height: 100%;
    margin: 0;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
        .dropbtn {
            background-color: transparent;
            color: #5e72e4;
            padding: 3px;
            font-size: 16px;
            border: none;
        }
        
        .dropdownas {
            position: relative;
            display: inline-block;
        }
        
        .dropdownas-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 20px;

        }
        
        .dropdownas-content a {
            color: #5e72e4;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-radius: 20px;

        }
        
        .dropdownas-content a:hover {color: #4a5ecf;}
        
        .dropdownas:hover .dropdownas-content {display: block;}
        
        .dropdownas:hover .dropbtn {background-color: transparent;}

    </style>
    <title>{{ __('Klientų valdymo sistema') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.12.1/jquery-ui.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="{{ asset('js/jquery.circle-progress.min.js') }}"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Font awesome icons -->
    <link href="{{ URL::asset('css//all.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body >
    <div id="app" style="background: linear-gradient(to bottom, #ffffff 0%, #4a5ecf 100%); min-height:100%;">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    {{ __('Klientų valdymo sistema') }}
                </a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest

                        @else

                            <a class="navbar-item" href="{{ route('dashboard.index') }}">
                                <i class="fas fa-clipboard-list"></i> {{ __('Darbastalis') }}
                            </a>

                            &nbsp;&nbsp;

                            <a class="navbar-item" href="{{ route('clients.index') }}">
                                <i class="far fa-address-book"></i> {{ __('Klientų sąrašas') }}
                            </a>

                            &nbsp;&nbsp;

                            <a class="navbar-item" href="{{ route('sales.index') }}">
                                <i class="fas fa-euro-sign"></i> {{ __('Pardavimai') }}
                            </a>

                            &nbsp;&nbsp;

                            <a class="navbar-item" href="{{ route('motivation.index') }}" >
                                <i class="fas fa-award"></i> {{ __('Vartotojų rezultatai') }}
                            </a>

                            &nbsp; &nbsp;

                        @endguest

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Prisijungti') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registruotis') }}</a>
                                </li>
                            @endif
                        @else
                        @if (Auth::user()->is_admin || isset(DB::table('organizations')->select('admin')->where('admin', Auth::user()->id)->first()->admin))
                            <div class="dropdownas">
                                <a class="dropbtn" href="#" >
                                    {{ __("Admin valdymas") }} <i class="fas fa-user-cog"></i>
                                </a>
                                <div class="dropdownas-content">
                                    <a class="dropdown-item" href="{{ route('users.index') }}" >
                                        <i class="fas fa-users"></i> {{ __('Vartotojai') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('organizations.index') }}" >
                                        <i class="fas fa-sitemap"></i> {{ __('Organizacijos') }}
                                    </a>
                                </div>
                            </div>&nbsp; &nbsp; 
                        @endif
                        <img src="{{ URL::asset('avatars/'.Auth::user()->avatar) }}" alt="Avatar" style="width: 40px; height:40px; border-radius:50%; {{ App\Models\User::getLevel(Auth::user()->user_xp)->border }} " >&nbsp; &nbsp; 
                        <div class="dropdownas">
                            <a class="dropbtn" href="#" >
                                {{ Auth::user()->name }} <i class="fas fa-chevron-circle-down"></i>
                            </a>
                            <div class="dropdownas-content">
                                <a class="dropdown-item" href="{{ route('user.show', Auth::user()->id) }}" >
                                    <i class="fas fa-user"></i> {{ __('Mano profilis') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Atsijungti') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>&nbsp; &nbsp; 
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>