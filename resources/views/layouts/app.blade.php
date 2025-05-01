<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoEvent Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background-color: #fdfdfd;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background-color: #ffffff;
            padding: 2rem 1rem;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 2rem;
            padding-left: 0.5rem;
            color: #343a40;
        }

        .sidebar p {
            margin-top: 1rem;
            padding-left: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .sidebar a {
            padding: 0.65rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #495057;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: background-color 0.2s, font-weight 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #e9ecef;
            font-weight: 500;
        }

        .logout-form {
            padding: 0 1rem;
        }

        .logout-form button {
            margin-top: 1.5rem;
        }

        .main-content {
            margin-left: 240px;
            padding: 2.5rem;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .user-info {
            font-size: 0.95rem;
            color: #333;
            background-color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                flex-direction: row;
                flex-wrap: wrap;
                padding: 1rem;
                border-right: none;
                border-bottom: 1px solid #dee2e6;
            }

            .sidebar h4,
            .sidebar p {
                display: none;
            }

            .sidebar a {
                flex: 1 1 45%;
                justify-content: center;
                padding: 0.5rem;
            }

            .logout-form {
                width: 100%;
                padding-top: 1rem;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .topbar {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <nav class="sidebar">
        <div>
            <h4>GoEvent</h4>

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Dashboard
            </a>

            <p>Data Master</p>
            <a href="{{ route('events.create') }}" class="{{ request()->routeIs('events.create') ? 'active' : '' }}">
                <i class="bi bi-calendar-plus"></i> Buat Event
            </a>
            <a href="#">
                <i class="bi bi-people"></i> Peserta
            </a>

            <p>Data Peserta</p>
            <a href="#">
                <i class="bi bi-calendar-event"></i> Event Saya
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </nav>

    <main class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Yuk, temukan dan ikuti event seru pilihanmu!</h2>

            @auth
            <div class="user-info">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
            </div>
            @endauth
        </div>

        @yield('content')
    </main>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>