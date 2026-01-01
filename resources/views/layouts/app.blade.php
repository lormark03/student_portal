<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Student Portal') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button id="sidebarToggle" class="btn btn-sm btn-outline-secondary d-md-none me-2">☰</button>
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Student Portal') }}</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function (e) {
        e.preventDefault();
        document.body.classList.toggle('sidebar-open');
    });
</script>

<style>
    :root { --primary: #0d6efd; }
    .app-layout { min-height: calc(100vh - 56px); }

    /* Ensure the main layout uses flexbox stretching so sidebar matches main content height */
    .d-flex { align-items: stretch; }

    .sidebar {
        width: 250px;
        min-width: 250px;
        max-width: 250px;
        /* Let the sidebar height be determined by the main content (flex stretch) */
        position: relative;
        align-self: stretch;
        overflow: auto;
        background: #fff;
    }

    @media (min-width: 768px) {
        /* Desktop: keep the sidebar visually aligned; allow internal scroll if content exceeds main */
        .sidebar { top: 0; }
    }

    @media (max-width: 767px) {
        /* Mobile: sidebar becomes an overlay when toggled */
        .sidebar {
            display: none;
            position: fixed;
            left: 0;
            top: 56px;
            bottom: 0;
            height: auto;
            z-index: 1050;
            box-shadow: 0 6px 24px rgba(0,0,0,0.08);
        }

        body.sidebar-open .sidebar {
            display: block;
        }
    }
</style>

<div class="container-fluid py-4 app-layout">
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="d-flex">
        @hasSection('no_sidebar')
        @else
            <aside class="sidebar">
                @include('partials.sidebar')
            </aside>
        @endif

        <main class="flex-fill ms-3">
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>