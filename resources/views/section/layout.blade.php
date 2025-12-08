<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Batik Bulau Sayang')</title>

    <script src="https://cdn.tailwindcss.com"></script>

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
        <ul id="menuList" class="hidden lg:flex gap-10 text-lg font-semibold">
            
            <!-- Dropdown Item -->
            <li class="relative group">
                <button class="relative nav-hover pb-1 text-black">About Us</button>
            </li>

            <li class="relative group">
                <button class="relative nav-hover pb-1 text-black">Gallery</button>
            </li>

            <li class="relative group">
                <button class="relative nav-hover pb-1 text-black">Product</button>
            </li>

            <li class="relative group">
                <button class="relative nav-hover pb-1 text-black">Event</button>
            </li>
        </ul>
    </div>
</nav>

<!-- MOBILE DROPDOWN MENU -->
<div id="mobileMenu" class="hidden lg:hidden bg-white/95 text-black p-6 space-y-4">
    <p class="font-bold text-xl">MENU</p>
    <hr class="border-gray-300">

    <details class="group">
        <summary class="cursor-pointer text-lg py-2">About Us</summary>
        <div class="pl-4 text-sm space-y-1">
            <a href="#" class="block">Company Overview</a>
            <a href="#" class="block">Our History</a>
            <a href="#" class="block">Leadership</a>
        </div>
    </details>

    <details class="group">
        <summary class="cursor-pointer text-lg py-2">Corporate Governance</summary>
        <div class="pl-4 text-sm space-y-1">
            <a href="#">Policies</a>
            <a href="#">Ethics & Compliance</a>
            <a href="#">Transparency Report</a>
        </div>
    </details>

    <details class="group">
        <summary class="cursor-pointer text-lg py-2">Mining Assets</summary>
        <div class="pl-4 text-sm space-y-1">
            <a href="#">Active Sites</a>
            <a href="#">Production Data</a>
            <a href="#">Logistics</a>
        </div>
    </details>

    <details class="group">
        <summary class="cursor-pointer text-lg py-2">Project Data</summary>
        <div class="pl-4 text-sm space-y-1">
            <a href="#">Ongoing Projects</a>
            <a href="#">Completed Projects</a>
            <a href="#">Future Plans</a>
        </div>
    </details>

    <details class="group">
        <summary class="cursor-pointer text-lg py-2">Investor Relation</summary>
        <div class="pl-4 text-sm space-y-1">
            <a href="#">Financial Reports</a>
            <a href="#">Annual Statements</a>
            <a href="#">Contact Investor Team</a>
        </div>
    </details>
</div>


<script>
    // Mobile toggle
    document.getElementById("menuBtn").addEventListener("click", () => {
        document.getElementById("mobileMenu").classList.toggle("hidden");
    });
</script>

<div class="mt-40">
    @yield('content')
</div>

</body>
</html>
