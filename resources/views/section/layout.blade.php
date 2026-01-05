    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Batik Bulau Sayang')</title>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        @livewireStyles

        <style>
            /* Hover underline animation */
            .nav-hover::after {
                content: "";
                position: absolute;
                left: 0;
                bottom: -2px;
                width: 100%;
                height: 2px;
                background: white;
                transition: 0.4s ease;
            }

            .nav-hover:hover::after {
                background: #8E4954;
            }
        </style>
    </head>

    <body class="bg-[#FFF8F6] text-black">

        <!-- NAVBAR -->
        <nav class="fixed top-0 w-full z-50 bg-transparent backdrop-blur-sm px-4">
            <div class="max-w-screen-xl mx-auto flex items-center justify-center py-4">

                <!-- MOBILE BUTTON -->
                <button id="menuBtn" class="lg:hidden text-black text-3xl absolute left-4">
                    ☰
                </button>

                <!-- MAIN MENU -->
                <ul id="menuList" class="hidden lg:flex gap-10 text-lg font-semibold items-center">

                    <!-- Cart Item -->
                    <li class="relative group">
                        <a href="/cart" class="flex items-center gap-2 relative nav-hover pb-1 text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293a1 1 0 00.117 1.497A6 6 0 0012 21c1.657 0 3.22-.663 4.33-1.97M17 13l2.707-2.707a1 1 0 00-.117-1.497A6 6 0 0012 3c-1.657 0-3.22.663-4.33 1.97M9 6h0M15 6h0" />
                            </svg>
                            Cart
                        </a>
                    </li>

                    <!-- Dropdown Item -->
                    <li class="relative group">
                        <a href="/aboutus" class="relative nav-hover pb-1 text-black">About Us</a>
                    </li>

                    <li class="relative group">
                        <a href="/gallery" class="relative nav-hover pb-1 text-black">Gallery</a>
                    </li>

                    <li class="relative group">
                        <a href="/product" class="relative nav-hover pb-1 text-black">Product</a>
                    </li>

                    <li class="relative group">
                        <a href="/event" class="relative nav-hover pb-1 text-black">Event</a>
                    </li>

                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <li class="relative group">
                            <a href="/admin/orders" class="relative nav-hover pb-1 text-black">Admin Dashboard</a>
                        </li>
                    @endif

                    <!-- Profile / Auth Section -->
                    @if (auth()->check())
                        <li class="relative group">
                            <a href="/profile" class="flex items-center gap-2 relative nav-hover pb-1 text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                                Profile
                            </a>
                            <!-- Dropdown Menu -->
                            {{-- <div class="absolute left-0 mt-0 w-48 bg-white text-black rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none group-hover:pointer-events-auto z-50">
                        <a href="{{ route('profile.show', auth()->user()->id) }}" class="block px-4 py-3 hover:bg-[#FFD9DC] rounded-t-lg">
                            👤 Lihat Profil
                        </a>
                        <a href="{{ route('profile.edit', auth()->user()->id) }}" class="block px-4 py-3 hover:bg-[#FFD9DC]">
                            ✏️ Edit Profil
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 hover:bg-[#FFD9DC] rounded-b-lg text-red-600 font-semibold">
                                🚪 Logout
                            </button>
                        </form>
                    </div> --}}
                        </li>
                    @else
                        <li class="relative group">
                            <a href="/login" class="flex items-center gap-2 relative nav-hover pb-1 text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Login
                            </a>
                        </li>
                    @endif


                </ul>
            </div>
        </nav>

        <!-- MOBILE DROPDOWN MENU -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white/95 text-black p-6 space-y-4">
            <p class="font-bold text-xl">MENU</p>
            <hr class="border-gray-300">

            <a href="/cart" class="block py-2 text-lg font-semibold hover:text-[#8E4954]">🛒 Cart</a>

            <details class="group">
                <summary class="cursor-pointer text-lg py-2">About Us</summary>
            </details>

            <details class="group">
                <summary class="cursor-pointer text-lg py-2">Gallery</summary>
            </details>

            <details class="group">
                <summary class="cursor-pointer text-lg py-2">Product</summary>
            </details>

            <details class="group">
                <summary class="cursor-pointer text-lg py-2">Event</summary>
            </details>

            <details class="group">
                <summary class="cursor-pointer text-lg py-2">Profile</summary>
            </details>


        </div>


        <script>
            // Mobile toggle
            document.getElementById("menuBtn").addEventListener("click", () => {
                document.getElementById("mobileMenu").classList.toggle("hidden");
            });
        </script>

        <div class="mt-20">
            <h1>@yield('pagetitle')</h1>
            @yield('content')
        </div>
        @livewireScripts

        @yield('scripts')
    </body>

    </html>
