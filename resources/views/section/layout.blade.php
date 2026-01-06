    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Batik Bulau Sayang')</title>
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
        @livewireStyles
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <style>
            [x-cloak] {
                display: none !important;
            }


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
        <div id="mobileMenu" class="hidden fixed inset-0 z-50 bg-white/95 text-black p-6 overflow-y-auto transition-all duration-300 lg:hidden">
            <div class="flex justify-between items-center mb-4">
                <span class="font-bold text-2xl">MENU</span>
                <button onclick="document.getElementById('mobileMenu').classList.add('hidden')" class="text-3xl">&times;</button>
            </div>
            <ul class="space-y-4 text-lg">
                <li><a href="/cart" class="flex items-center gap-2 font-medium hover:text-[#8E4954] transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293a1 1 0 00.117 1.497A6 6 0 0012 21c1.657 0 3.22-.663 4.33-1.97M17 13l2.707-2.707a1 1 0 00-.117-1.497A6 6 0 0012 3c-1.657 0-3.22.663-4.33 1.97M9 6h0M15 6h0" /></svg>Cart</a></li>
                <li><a href="/aboutus" class="font-medium hover:text-[#8E4954] transition">About Us</a></li>
                <li><a href="/gallery" class="font-medium hover:text-[#8E4954] transition">Gallery</a></li>
                <li><a href="/product" class="font-medium hover:text-[#8E4954] transition">Product</a></li>
                <li><a href="/event" class="font-medium hover:text-[#8E4954] transition">Event</a></li>
                @if (Auth::check() && Auth::user()->role === 'admin')
                <li><a href="/admin/orders" class="font-medium hover:text-[#8E4954] transition">Admin Dashboard</a></li>
                @endif
                @if (auth()->check())
                <li><a href="/profile" class="flex items-center gap-2 font-medium hover:text-[#8E4954] transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" /></svg>Profile</a></li>
                @else
                <li><a href="/login" class="flex items-center gap-2 font-medium hover:text-[#8E4954] transition"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>Login</a></li>
                @endif
            </ul>
        </div>


        <script>
            // Mobile toggle
            document.getElementById("menuBtn").addEventListener("click", () => {
                document.getElementById("mobileMenu").classList.toggle("hidden");
            });
        </script>

        <div class="mt-20 min-h-[60vh]">
            <h1>@yield('pagetitle')</h1>
            @yield('content')
        </div>
        <!-- FOOTER -->
        <footer class="bg-[#8E4954] text-white py-8 px-4 mt-10">
            <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left">
                    <div class="text-2xl font-bold tracking-wide mb-2">Batik Bulau Sayang</div>
                    <div class="text-sm mb-2">Jl. Batik Raya No. 123, Bulau, Indonesia</div>
                    <div class="text-xs">&copy; {{ date('Y') }} Batik Bulau Sayang. All rights reserved.</div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <a href="/aboutus" class="hover:underline">About Us</a>
                    <a href="/gallery" class="hover:underline">Gallery</a>
                    <a href="/product" class="hover:underline">Product</a>
                    <a href="/event" class="hover:underline">Event</a>
                </div>
                <div class="flex gap-4 items-center">
                    <a href="https://www.instagram.com/bulau_sayang/" aria-label="Instagram" class="hover:text-[#FFD9DC] transition"><svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6"><path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5zm4.25 2.25a6.25 6.25 0 1 1-6.25 6.25a6.25 6.25 0 0 1 6.25-6.25zm0 1.5a4.75 4.75 0 1 0 4.75 4.75a4.75 4.75 0 0 0-4.75-4.75zm6.25 1.25a1 1 0 1 1-2 0a1 1 0 0 1 2 0z"/></svg></a>
                    {{-- <a href="#" aria-label="Facebook" class="hover:text-[#FFD9DC] transition"><svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6"><path d="M22 12a10 10 0 1 0-11.5 9.95v-7.05h-2v-2.9h2v-2.2c0-2 1.2-3.1 3-3.1c.9 0 1.8.16 1.8.16v2h-1c-1 0-1.3.62-1.3 1.25v1.9h2.5l-.4 2.9h-2.1v7.05A10 10 0 0 0 22 12z"/></svg></a> --}}
                </div>
            </div>
        </footer>
        @livewireScripts

        @yield('scripts')
    </body>

    </html>
