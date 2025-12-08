{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <style>
        html, body { height:100%; margin:0; background:#ffffff; font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color:#111827; }
        .login-wrapper{ min-height:100%; display:flex; align-items:center; justify-content:center; padding:32px; }
        .login-card{ background:#FFD9DC; border-radius:12px; max-width:420px; width:100%; box-shadow:0 8px 30px rgba(16,24,40,0.08); padding:28px; }
        .login-card h1{ margin:0 0 12px 0; font-size:1.5rem; font-weight:600; }
        .login-card p.lead{ margin:0 0 18px 0; color:#374151; font-size:0.95rem; }
        label{ display:block; font-size:0.85rem; margin-bottom:6px; color:#111827; }
        input[type="text"], input[type="email"], input[type="password"]{ width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(17,24,39,0.12); background:#fff; box-sizing:border-box; margin-bottom:14px; font-size:0.95rem; }
        .btn-primary{ display:inline-block; width:100%; padding:10px 14px; border-radius:8px; background:#111827; color:#fff; text-align:center; font-weight:600; border:none; cursor:pointer; font-size:0.95rem; }
        .helper-links{ margin-top:12px; font-size:0.9rem; display:flex; justify-content:space-between; color:#374151; }
        @media (max-width:480px){ .login-card{ padding:20px; border-radius:10px; } }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <main class="login-card" role="main">
            <h1>Daftar</h1>
            <p class="lead">Buat akun baru untuk melanjutkan.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label for="name">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                </div>

                <div>
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <div>
                    <button type="submit" class="btn-primary">Daftar</button>
                </div>

                <div class="helper-links">
                    <div>
                        <a href="{{ route('login') }}" style="color:#111827; text-decoration:underline;">Sudah punya akun? Masuk</a>
                    </div>
                    <div>
                        <a href="{{ route('password.request') }}" style="color:#111827; text-decoration:underline;">Lupa password?</a>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
{{-- @endsection --}}
