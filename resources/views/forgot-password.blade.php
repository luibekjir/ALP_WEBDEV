@extends('section.layout')

@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password</title>
    <style>
        html, body { height:100%; margin:0; background:#ffffff; font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color:#111827; }
        .login-wrapper{ min-height:100%; display:flex; align-items:center; justify-content:center; padding:32px; }
        .login-card{ background:#FFD9DC; border-radius:12px; max-width:420px; width:100%; box-shadow:0 8px 30px rgba(16,24,40,0.08); padding:28px; }
        .login-card h1{ margin:0 0 12px 0; font-size:1.5rem; font-weight:600; }
        .login-card p.lead{ margin:0 0 18px 0; color:#374151; font-size:0.95rem; }
        label{ display:block; font-size:0.85rem; margin-bottom:6px; color:#111827; }
        input[type="email"]{ width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(17,24,39,0.12); background:#fff; box-sizing:border-box; margin-bottom:14px; font-size:0.95rem; }
        .btn-primary{ display:inline-block; width:100%; padding:10px 14px; border-radius:8px; background:#111827; color:#fff; text-align:center; font-weight:600; border:none; cursor:pointer; font-size:0.95rem; }
        .helper-links{ margin-top:12px; font-size:0.9rem; display:flex; justify-content:space-between; color:#374151; }
        @media (max-width:480px){ .login-card{ padding:20px; border-radius:10px; } }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <main class="login-card" role="main">
            <h1>Lupa Password</h1>
            <p class="lead">Masukkan email Anda. Kami akan mengirimkan link untuk mereset password.</p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div>
                    <button type="submit" class="btn-primary">Kirim Link Reset</button>
                </div>

                <div class="helper-links">
                    <div>
                        <a href="/login" style="color:#111827; text-decoration:underline;">Kembali ke Masuk</a>
                    </div>
                    <div>
                        <a href="/register" style="color:#111827; text-decoration:underline;">Buat akun baru</a>
                    </div>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
@endsection
