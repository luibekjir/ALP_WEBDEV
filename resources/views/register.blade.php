@extends('section.layout')

@section('content')
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register</title>
        <style>
            html,
            body {
                height: 100%;
                margin: 0;
                background: #ffffff;
                font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
                color: #111827;
            }

            .login-wrapper {
                min-height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 32px;
            }

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
            }

            .login-card p.lead {
                margin: 0 0 18px 0;
                color: #374151;
                font-size: 0.95rem;
            }

            /* Alerts */
            .alert {
                padding: 12px 14px;
                border-radius: 8px;
                margin-bottom: 16px;
                font-size: 0.95rem;
            }

            .alert-success {
                background: #ecfdf5;
                color: #065f46;
                border: 1px solid #bbf7d0;
            }

            .alert-error {
                background: #fff1f2;
                color: #881337;
                border: 1px solid #fecdd3;
            }

            label {
                display: block;
                font-size: 0.85rem;
                margin-bottom: 6px;
                color: #111827;
            }

            input[type="text"],
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
                font-weight: 600;
                border: none;
                cursor: pointer;
                font-size: 0.95rem;
            }

            .helper-links {
                margin-top: 12px;
                font-size: 0.9rem;
                display: flex;
                justify-content: space-between;
                color: #374151;
            }

            @media (max-width:480px) {
                .login-card {
                    padding: 20px;
                    border-radius: 10px;
                }
            }
        </style>
    </head>

    <body>
        <div class="login-wrapper">
            <main class="login-card" role="main">
                <h1>Daftar</h1>
                <p class="lead">Buat akun baru untuk melanjutkan.</p>

                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('regist.user') }}">
                    @csrf

                    {{-- NAME --}}
                    <div>
                        <label for="name">Nama</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

                        @error('name')
                            <div style="color:red; font-size:14px;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                        @error('email')
                            <div style="color:red; font-size:14px;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PHONE --}}
                    <div>
                        <label for="phone">Telepon</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}">

                        @error('phone')
                            <div style="color:red; font-size:14px;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ADDRESS --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold mb-2">
                            Alamat Pengiriman
                        </label>

                        <div class="space-y-3">

                            {{-- Alamat Lengkap --}}
                            <input type="text" name="address" placeholder="Alamat lengkap (jalan, nomor rumah, RT/RW)"
                                value="{{ old('address') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 text-sm">

                            {{-- Grid Kelurahan & Kecamatan --}}
                            <div class="grid grid-cols-2 gap-3">
                                <input type="text" name="subdistrict" placeholder="Kelurahan"
                                    value="{{ old('subdistrict') }}" required
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 text-sm">

                                <input type="text" name="district" placeholder="Kecamatan" value="{{ old('district') }}"
                                    required
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 text-sm">
                            </div>

                            {{-- Grid Kota & Kode Pos --}}
                            <div class="grid grid-cols-2 gap-3">
                                <input type="text" name="city" placeholder="Kota / Kabupaten"
                                    value="{{ old('city') }}" required
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 text-sm">

                                <input type="text" name="zip_code" placeholder="Kode Pos" value="{{ old('zip_code') }}"
                                    required
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 text-sm">
                            </div>

                        </div>

                        {{-- ERROR --}}
                        @if ($errors->hasAny(['address', 'subdistrict', 'district', 'city', 'zip_code']))
                            <p class="text-red-600 text-sm mt-2">
                                Lengkapi alamat dengan benar.
                            </p>
                        @endif
                    </div>


                    {{-- PASSWORD --}}
                    <div>
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password">

                        @error('password')
                            <div style="color:red; font-size:14px;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD CONFIRM --}}
                    <div>
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>

                        @error('password_confirmation')
                            <div style="color:red; font-size:14px;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SUBMIT --}}
                    <div>
                        <button type="submit" class="btn-primary">Daftar</button>
                    </div>

                    {{-- LINKS --}}
                    <div class="helper-links">
                        <div>
                            <a href="/login" style="color:#111827; text-decoration:underline;">Sudah punya akun? Masuk</a>
                        </div>
                        <div>
                            <a href="/forgot-password" style="color:#111827; text-decoration:underline;">Lupa password?</a>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </body>

    </html>
@endsection
