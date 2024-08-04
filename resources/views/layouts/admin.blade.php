@php
use App\Helpers\Helper;
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favi.png') }}" type="image/x-icon">
    @yield('title')
    @yield('description')
    @yield('schema')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('asset/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    @guest

    @else
    <link href="{{ asset('asset/css/jquery.dataTables.css') }}" rel="stylesheet">
    @endguest


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @if(Helper::setting())
                <a class="navbar-brand" href="{{ url('/') }}">
                    <?php echo "<img src='" . asset('uploads/site') . '/' . Helper::setting()['site_logo'] . "' style='height:auto;' />"; ?>
                </a>
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                Home
                            </a>
                        </li>
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('sites.index') }}">
                                Sites
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('setting.index') }}">
                                Setting
                            </a>
                        </li>
                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
        <footer class="bg-dark text-white text-center py-3">
            <div class="container">
                <p class="mb-0">&copy; <?php echo date('Y') . ' '; ?>
                    {{ Helper::setting()['site_name'] }}. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
    <script src="{{ asset('asset/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>
    @guest

    @else
    <script src="{{ asset('asset/js/jquery.dataTables.js') }}"></script>
    @endguest

    @yield('page_scripts')
</body>

</html>