<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/sidebar.css'])
    @livewireStyles
</head>

<body>
    @if (session('success'))
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999;">
            <div id="success" class="toast show align-items-center text-bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body text-center w-100">{{ session('success') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    @auth
        <div class="d-flex" id="wrapper">
            <aside id="sidebar-wrapper" class="bg-light border-right">
                <div class="sidebar-heading p-4">
                    <span class="fw-bold fs-4">{{ config('app.name', 'Laravel') }}</span>
                </div>

                <div class="list-group list-group-flush flex-grow-1">
                    <div class="nav-section-title">Main</div>
                    <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-grid"></i>Dashboard</a>
                    {{-- <a href="{{ route('users') }}" class="nav-link"><i class="bi bi-people"></i> Users</a> --}}

                    <div class="nav-section-title">Masterfiles</div>
                    <a href="#" class="nav-link active"><i class="bi bi-check2-square"></i> Tasks</a>
                    <a href="{{ route('infosystems') }}" class="nav-link"><i class="bi bi-laptop"></i> Info Systems</a>
                </div>

                <div class="p-3 border-top mt-auto">
                    <div class="d-flex align-items-center gap-2">
                        <div class="flex-grow-1 min-w-0">
                            <small class="d-block fw-bold text-truncate">{{ Auth::user()->user_firstName }}</small>
                            <small class="text-muted">{{ Auth::user()->user_email }}</small>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-danger"><i
                                    class="bi bi-box-arrow-right"></i></button>
                        </form>
                    </div>
                </div>
            </aside>

            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-3">
                    <button class="btn btn-outline-secondary btn-sm" id="menu-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                </nav>

                <main class="p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @endauth

    @guest
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
            </div>
        </nav>

        <main class="py-5">
            {{ $slot }}
        </main>
    @endguest

    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.body.querySelector('#menu-toggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.querySelector('#wrapper').classList.toggle('toggled');
                });
            }
        });
    </script>

    @livewireScripts
</body>

</html>