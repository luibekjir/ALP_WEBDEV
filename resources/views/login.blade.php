@extends('section.layout')

@section('content')
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <style>
            /* Page background */
            html,
            body {
                height: 100%;
                margin: 0;
                background: #ffffff;
                font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                color: #111827;
            }

            /* Centering wrapper */
            .login-wrapper {
                min-height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 32px;
            }

            /* Pink container */
            .login-card {
                background: #FFD9DC;
                border-radius: 12px;
                max-width: 420px;
                width: 100%;
                box-shadow: 0 8px 30px rgba(16, 24, 40, 0.08);
                padding: 28px;
            }

            .login-card h1 {
                margin: 0 0 12px 0;
                font-size: 1.5rem;
                font-weight: 600;
                color: #111827;
            }

            .login-card p.lead {
                margin: 0 0 18px 0;
                color: #374151;
                font-size: 0.95rem;
            }

            label {
                display: block;
                font-size: 0.85rem;
                margin-bottom: 6px;
                color: #111827;
            }

            input[type="email"],
            input[type="password"] {
                width: 100%;
                padding: 10px 12px;
                border-radius: 8px;
                border: 1px solid rgba(17, 24, 39, 0.12);
                background: #fff;
                box-sizing: border-box;
                margin-bottom: 14px;
                font-size: 0.95rem;
            }

            .btn-primary {
                display: inline-block;
                width: 100%;
                padding: 10px 14px;
                border-radius: 8px;
                background: #111827;
                color: #fff;
                text-align: center;
                text-decoration: none;
                font-weight: 600;
                border: none;
                cursor: pointer;
                font-size: 0.95rem;
            }

            .helper-links {
                margin-top: 20px;
                font-size: 0.9rem;
                color: #374151;
            }

            .helper-links-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .helper-links-row:last-child {
                margin-bottom: 0;
                text-align: center;
                justify-content: center;
            }

            .helper-links a {
                color: #111827;
                text-decoration: underline;
                transition: color 0.2s ease;
            }

            .helper-links a:hover {
                color: #374151;
            }

            .remember-me {
                display: inline-flex;
                align-items: center;
                font-weight: 400;
            }

            .remember-me input {
                margin-right: 6px;
                cursor: pointer;
            }

            @media (max-width: 480px) {
                .login-card {
                    padding: 20px;
                    border-radius: 10px;
                }

                .helper-links-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 8px;
                }

                .helper-links-row:last-child {
                    align-items: center;
                    margin-top: 12px;
                }
            }
        </style>
    </head>

    <body>
        <div class="login-wrapper">
            <main class="login-card" role="main">
                <h1>Masuk</h1>
                <p class="lead">Silakan masuk menggunakan akun Anda.</p>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @error('email')
                        <div class="text-red-500">
                            {{ $message }}
                        </div>
                    @enderror

                    <div>
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password">
                    </div>

                    <div>
                        <button type="submit" class="btn-primary">Masuk</button>
                    </div>

                    <div class="helper-links">
                        <div class="helper-links-row">
                            <label class="remember-me">
                                <input type="checkbox" name="remember">
                                Ingat saya
                            </label>
                            <a href="/forgot-password">Lupa password?</a>
                        </div>
                        <div class="helper-links-row">
                            Belum punya akun?<a href="/register">Daftar di sini</a>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </body>

    </html>
    {{-- @endsection --}}
