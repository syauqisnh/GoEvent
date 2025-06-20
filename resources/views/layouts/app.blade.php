<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoEvent Dashboard')</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

</head>

<body>

    @php
    $user = session('userData');
    @endphp

    <nav class="sidebar">
        <div>
            <h4>GoEvent</h4>

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>

            @if($user && $user->role === 'admin')
            <p>Data Master</p>
            <a href="{{ route('events.create') }}" class="{{ request()->routeIs('events.create') ? 'active' : '' }}">
                <i class="bi bi-calendar-plus"></i> Buat Event
            </a>
            <a href="{{ route('events.participants') }}" class="{{ request()->routeIs('events.participants') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Peserta
            </a>
            <p>Data Peserta</p>
            <a href="{{ route('events.mine') }}" class="{{ request()->routeIs('events.mine') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Event Saya
            </a>
            @endif

            @if($user && $user->role === 'participant')
            <p>Data Peserta</p>
            <a href="{{ route('events.mine') }}" class="{{ request()->routeIs('events.mine') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Event Saya
            </a>
            @endif
        </div>

        <form method="GET" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </nav>

    <main class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Yuk, temukan dan ikuti event seru pilihanmu!</h2>
            @if(session('userData'))
            <div class="user-info">
                <i class="bi bi-person-circle"></i> {{ session('userData')->name }}
            </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>


</html>