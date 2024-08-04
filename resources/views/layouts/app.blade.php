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
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    @guest

    @else
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    @endguest

    @if(Helper::setting())
    {!! Helper::setting()['header_script']; !!}
    {!! Helper::setting()['header_style']; !!}
    @endif
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @if(Helper::setting())
                <a class="navbar-brand" href="{{ url('/') }}">
                    <?php echo "<img src='" . asset('uploads/site') . '/' . Helper::setting()['site_logo'] . "' style='width:120px; height:auto;' />"; ?>
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
                        @guest
                        @if(Helper::setting() &&
                        Helper::setting()['site_type'] == 'single_site' &&
                        Helper::setting()['default_site_id']!= '' &&
                        Helper::get_categories(Helper::setting()['default_site_id']) != null)
                        @foreach(Helper::get_categories(Helper::setting()['default_site_id']) as $key => $cat_item)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category.show', ['site_id' => Helper::setting()['default_site_id'], 'id' => $cat_item->id, 'slug' => $cat_item->slug]) }}">
                                {{ $cat_item->name; }}
                            </a>
                        </li>
                        @endforeach
                        @endif
                        @else

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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <footer class="bg-dark text-white text-center py-3">
            <div class="container">
                <p class="mb-0">&copy; <?php echo date('Y') . ' ';
                                        echo env('APP_NAME'); ?>. All rights reserved.</p>
            </div>
        </footer>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @guest

    @else
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    @endguest
    @if(Helper::setting())
    {!! Helper::setting()['footer_script']; !!}
    @endif
    @yield('page_scripts')
</body>

</html>