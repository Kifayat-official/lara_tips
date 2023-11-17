<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Registration & Authentication</title>
    @vite('resources/css/app.css')
    @yield('header-libs')
</head>

<body>

    {{-- <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            @if (Auth::check())
                @php
                    $regionName = Auth::user()->region_name;
                    $regionCode = Auth::user()->region_code;
                @endphp

                @if ($regionCode && $regionName)
                    <a class="navbar-brand" href="#">
                        {{ $regionName }} @if ($regionCode)
                            ({{ $regionCode }})
                        @endif
                    </a>
                @endif
            @else
                <a class="navbar-brand" href="#">Login & Register</a>
            @endif

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login') ? 'active' : '' }}"
                                href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('register') ? 'active' : '' }}"
                                href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ Auth::user()->username }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav> --}}

    <nav class="bg-gray-100 shadow">
        <div class="container mx-auto px-4">
            @if (Auth::check())
                @php
                    $regionName = Auth::user()->region_name;
                    $regionCode = Auth::user()->region_code;
                @endphp

                @if ($regionCode && $regionName)
                    <a class="text-xl font-semibold" href="#">
                        {{ $regionName }} @if ($regionCode)
                            ({{ $regionCode }})
                        @endif
                    </a>
                @endif
            @else
                <a class="text-xl font-semibold" href="#">Login & Register</a>
            @endif

            <button class="text-gray-500 focus:outline-none lg:hidden" type="button">
                <span class="material-icons">menu</span>
            </button>
            <div class="hidden lg:flex flex-grow items-center" id="navbarNavDropdown">
                <ul class="flex flex-col lg:flex-row list-none ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-gray-800 hover:opacity-75 {{ request()->is('login') ? 'text-gray-700' : '' }}"
                                href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-gray-800 hover:opacity-75 {{ request()->is('register') ? 'text-gray-700' : '' }}"
                                href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown relative">
                            <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-gray-800 hover:opacity-75 cursor-pointer"
                                onclick="toggleDropdown(event)">
                                {{ Auth::user()->username }}
                            </a>
                            <ul class="dropdown-menu absolute hidden text-gray-700 pt-1">
                                <li>
                                    <a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        @yield('content')
    </div>

    <div class="container">
        @yield('footer-libs')
    </div>

</body>

</html>
