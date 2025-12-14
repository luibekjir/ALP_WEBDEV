@extends('section.layout')

@section('content')
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            background: #fff;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial;
        }

        .login-card {
            background: #FFD9DC;
            border-radius: 14px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 12px 40px rgba(16, 24, 40, 0.12);
            padding: 32px;
        }

        .login-card h1 {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #111827;
        }

        .login-card p {
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 22px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid rgba(17, 24, 39, 0.15);
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="password"]:focus {
            outline: none;
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.08);
        }

        .error-text {
            font-size: 0.8rem;
            color: #b91c1c;
            margin-top: 4px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background: #111827;
            color: #fff;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-primary:hover {
            background: #1f2937;
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 16px;
        }

        .helper-links {
            margin-top: 18px;
            text-align: center;
            font-size: 0.85rem;
        }

        .helper-links a {
            color: #111827;
            font-weight: 500;
            text-decoration: underline;
        }
    </style>

    <div class="login-wrapper">
        <main class="login-card">
            <h1>Ubah Password</h1>
            <p>Pastikan password baru berbeda dan mudah diingat.</p>

            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('message'))
                <div class="text-red-500">
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password-update', $user) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <input type="password" name="current_password" placeholder="Password lama" required>
                    @error('current_password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password baru" required>
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru" required>
                </div>

                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </form>

            <div class="helper-links">
                Kembali ke <a href="/profil">Profil</a> <br>
                <a href="/forgot-password">Lupa password?</a>
            </div>
        </main>
    </div>
@endsection
