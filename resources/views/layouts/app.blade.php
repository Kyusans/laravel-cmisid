<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

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
            <div id="sidebar-overlay"></div>
            <aside id="sidebar-wrapper" class="border-right">
                <div class="sidebar-heading p-4">
                    <span class="fw-bold fs-4">{{ config('app.name', 'Laravel') }}</span>
                </div>

                <div class="list-group list-group-flush flex-grow-1">
                    <div class="nav-section-title">Main</div>
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> Dashboard
                    </a>

                    <a href="{{ route('infosystems') }}"
                        class="nav-link {{ request()->routeIs('infosystems') ? 'active' : '' }}">
                        <i class="bi bi-laptop"></i> Info Systems
                    </a>

                    <div class="nav-section-title">Masterfiles</div>

                    <a href="{{ route('users') }}" class="nav-link {{ request()->routeIs('users') ? 'active' : '' }}">
                        <i class="bi-people"></i> Users
                    </a>
                    <a href="{{ route(name: 'roles') }}" class="nav-link {{ request()->routeIs('roles') ? 'active' : '' }}">
                        <i class="bi-person-badge"></i> Roles
                    </a>
                    <a href="{{ route(name: 'offices') }}"
                        class="nav-link {{ request()->routeIs('offices') ? 'active' : '' }}">
                        <i class="bi-buildings"></i> Offices
                    </a>
                    <a href="{{ route(name: 'systemTypes') }}"
                        class="nav-link {{ request()->routeIs('systemTypes') ? 'active' : '' }}">
                        <i class="bi-hdd-network"></i> System Types
                    </a>
                    <a href="{{ route(name: 'workingEnvironment') }}"
                        class="nav-link {{ request()->routeIs('workingEnvironment') ? 'active' : '' }}">
                        <i class="bi-laptop"></i> Working Environment
                    </a>
                    <a href="{{ route(name: 'systemStatus') }}"
                        class="nav-link {{ request()->routeIs('systemStatus') ? 'active' : '' }}">
                        <i class="bi-diagram-3"></i> System Status
                    </a>
                    <a href="{{ route(name: 'fundingSource') }}"
                        class="nav-link {{ request()->routeIs('fundingSource') ? 'active' : '' }}">
                        <i class="bi-cash-stack"></i> Funding Source
                    </a>
                    <a href="{{ route(name: 'developmentStrategy') }}"
                        class="nav-link {{ request()->routeIs('developmentStrategy') ? 'active' : '' }}">
                        <i class="bi-card-checklist"></i> Development Strategy
                    </a>
                    <a href="{{ route(name: 'riseAgendaType') }}"
                        class="nav-link {{ request()->routeIs('riseAgendaType') ? 'active' : '' }}">
                        <i class="bi-list-check"></i> Rise agenda type
                    </a>
                    <a href="{{ route(name: 'riseAgenda') }}"
                        class="nav-link {{ request()->routeIs('riseAgenda') ? 'active' : '' }}">
                        <i class="bi-card-list"></i> Rise agenda
                    </a>
                    <a href="{{ route(name: 'developer') }}"
                        class="nav-link {{ request()->routeIs('developer') ? 'active' : '' }}">
                        <i class="bi-person-workspace"></i> Developer
                    </a>

                    <a href="{{ route(name: 'mfo') }}" class="nav-link {{ request()->routeIs('mfo') ? 'active' : '' }}">
                        <i class="bi-check2-square"></i> MFO
                    </a>

                </div>
                <div class="p-3 border-top mt-auto">
                    <div class="d-flex align-items-center gap-2">
                        <div class="flex-grow-1 min-w-0">
                            <small
                                class="d-block fw-bold text-truncate">{{ Auth::user()->user_firstName . ' ' . Auth::user()->user_lastName }}</small>
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

            <div id="page-content-wrapper" class="flex-grow-1">
                <nav class="navbar navbar-expand-lg px-3">
                    <button class="btn btn-outline-secondary btn-sm" id="menu-toggle">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="ms-auto">
                        <button id="themeToggle">
                            <i class="bi bi-sun-fill" id="theme-icon"></i>
                        </button>
                    </div>
                </nav>

                <main class="p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @endauth

    @guest
        <main>
            {{ $slot }}
        </main>
    @endguest

    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.querySelector('#menu-toggle');
            const overlay = document.querySelector('#sidebar-overlay');
            const wrapper = document.querySelector('#wrapper');
            const isMobile = () => window.innerWidth < 768;

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    wrapper.classList.toggle('toggled');
                });
            }

            // Close sidebar when clicking overlay on mobile
            if (overlay) {
                overlay.addEventListener('click', () => {
                    wrapper.classList.remove('toggled');
                });
            }

            // On resize, clean up toggled state to avoid stuck states
            window.addEventListener('resize', () => {
                if (!isMobile()) {
                    // Desktop: remove toggled so sidebar is visible by default
                }
            });
        });
        window.addEventListener('toast', event => {
            const type = event.detail.type || 'info';
            const message = event.detail.message || '';

            const toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 start-50 translate-middle-x p-3';
            toastContainer.style.zIndex = 9999;

            toastContainer.innerHTML = `
            <div class="toast show align-items-center text-bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body text-center w-100">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
            document.body.appendChild(toastContainer);

            const bsToastEl = toastContainer.querySelector('.toast');
            const bsToast = new bootstrap.Toast(bsToastEl);
            bsToast.show();

            // Remove the toast from DOM after hidden
            bsToastEl.addEventListener('hidden.bs.toast', () => {
                toastContainer.remove();
            });
        });

        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        function applyTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            themeIcon.className = theme === 'dark' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
            themeToggle.className = theme === 'dark' ?
                'btn btn-sm btn-outline-light' :
                'btn btn-sm btn-outline-dark';
            localStorage.setItem('theme', theme);
        }
        // Load saved preference
        applyTheme(localStorage.getItem('theme') || 'light');

        themeToggle.addEventListener('click', () => {
            const current = html.getAttribute('data-bs-theme');
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    </script>

    @livewireScripts
</body>

</html>