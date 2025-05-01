<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GoEvent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card shadow p-4" style="min-width: 300px; max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">GoEvent</h3>
        <h3 class="text-center mb-4">Login</h3>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="mt-3 text-center">
            <small>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></small>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>