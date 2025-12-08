<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tambang Pasir Jambi')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        /* ===== Top Bar ===== */
        .topbar {
            background: transparent;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 5%;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* Language Switcher */
        .lang-switch a {
            color: #ccc;
            text-decoration: none;
            margin: 0 4px;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .lang-switch a:hover {
            color: #fff;
        }

        .lang-switch span {
            color: #666;
        }

        /* Search Box */
        .search-box {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 25px;
            padding: 5px 35px 5px 15px;
            color: white;
            font-size: 0.9rem;
            width: 180px;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            width: 220px;
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .search-btn {
            background: none;
            border: none;
            position: absolute;
            right: 10px;
            cursor: pointer;
        }

        .search-container {
            position: relative;
        }

        /* Contact Button */
        .contact-btn {
            background: linear-gradient(90deg, #b30000, #ff3333);
            border: none;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            padding: 6px 18px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .contact-btn:hover {
            background: linear-gradient(90deg, #ff4444, #ff6666);
            box-shadow: 0 0 8px #ff4444;
        }

        /* ===== Navbar ===== */
        .navbar {
            background: transparent !important;
            border: none;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .navbar-nav {
            margin: 0 auto;
            gap: 3rem;
        }

        .nav-item {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
        }

        /* Garis dasar */
        .nav-item::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 2px;
            width: 0%;
            background: linear-gradient(to right, #fff, #b30000);
            transition: width 0.5s ease-in-out;
        }

        /* Efek hover animasi garis */
        .nav-item:hover::before {
            width: 100%;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 600;
            text-transform: capitalize;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #f8f8f8 !important;
        }

        .dropdown-menu {
            background-color: rgba(15, 15, 15, 0.95);
            border: none;
            margin-top: 0.5rem;
            border-radius: 0;
        }

        .dropdown-item {
            color: #fff;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .navbar-toggler {
            border-color: #fff;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='white' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        @media (max-width: 992px) {
            .navbar-nav {
                gap: 1.5rem;
            }

            .topbar {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- ===== TOPBAR ===== -->
    <div class="topbar">
        <div class="lang-switch">
            <a href="#">EN</a>
            <span>|</span>
            <a href="#">ID</a>
        </div>

        <div class="search-container">
            <input type="text" class="search-box" placeholder="Search...">
            <button class="search-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 
                        1.415-1.415l-3.85-3.85zm-5.242.656a5 5 0 1 1 
                        0-10 5 5 0 0 1 0 10z" />
                </svg>
            </button>
        </div>

        <button class="contact-btn">CONTACT US</button>
    </div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg fixed-top" style="margin-top: 50px;">
        <div class="container-fluid justify-content-center">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="mainNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            About Us
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="aboutDropdown">
                            <li><a class="dropdown-item" href="#">Company Overview</a></li>
                            <li><a class="dropdown-item" href="#">Our History</a></li>
                            <li><a class="dropdown-item" href="#">Leadership</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="corpDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Corporate Governance
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="corpDropdown">
                            <li><a class="dropdown-item" href="#">Policies</a></li>
                            <li><a class="dropdown-item" href="#">Ethics & Compliance</a></li>
                            <li><a class="dropdown-item" href="#">Transparency Report</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="miningDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Mining Assets
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="miningDropdown">
                            <li><a class="dropdown-item" href="#">Active Sites</a></li>
                            <li><a class="dropdown-item" href="#">Production Data</a></li>
                            <li><a class="dropdown-item" href="#">Logistics</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="projectDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Project Data
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="projectDropdown">
                            <li><a class="dropdown-item" href="#">Ongoing Projects</a></li>
                            <li><a class="dropdown-item" href="#">Completed Projects</a></li>
                            <li><a class="dropdown-item" href="#">Future Plans</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="investorDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Investor Relation
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="investorDropdown">
                            <li><a class="dropdown-item" href="#">Financial Reports</a></li>
                            <li><a class="dropdown-item" href="#">Annual Statements</a></li>
                            <li><a class="dropdown-item" href="#">Contact Investor Team</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top:150px;">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
