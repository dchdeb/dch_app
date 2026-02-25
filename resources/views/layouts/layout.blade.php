<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>
        @section('title', 'eHustle · Dashboard')
    </title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo/eHustle icon.png') }}">

    <!-- Early theme boot: default = dark (no flash) -->
    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            const theme = (saved === 'light' || saved === 'dark') ? saved : 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Intro.js (for walkthrough) -->
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">



    <!-- pricing cdn -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Odometer CSS + JS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.8/themes/odometer-theme-default.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.8/odometer.min.js"></script>

    <!-- Toggle button js -->
    {{-- <script>
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.body.classList.toggle("sidebar-collapsed");
        });
    </script> --}}




    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const toggleBtn = document.getElementById("menu-toggle");

            toggleBtn.addEventListener("click", function() {
                document.body.classList.toggle("sidebar-collapsed");
            });

        });
    </script>



</head>

<body>

    <div class="app ">

        <!-- TOP HEADER -->
        @include('partials.print_header')

        <!-- TOP HEADER -->
        @include('partials.topnav')

        <!-- GREEN TOPBAR (NEW) -->
        {{-- @include('partials.topnav') --}}


        <!-- SIDEBAR -->
        @include('partials.sidebar')

        <!-- MAIN -->
        <main class="d-flex flex-column">
            <!-- TOPBAR -->
            @include('partials.navbar')

            <!-- CONTENT -->
            <div class="container-fluid py-3">
                <!-- KPI -->
                @yield('content')
            </div><!-- /container -->
        </main>
    </div>

    <!-- Mobile offcanvas sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mSidebar">
        <div class="offcanvas-header">
            <div class="brand w-100">
                <div class="brand-badge">e</div><strong class="ms-2">eHustle</strong>
            </div>
            <button class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-2">
            <nav class="nav flex-column gap-1">
                <a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <!-- <a class="nav-link" href="#"><i class="bi bi-rocket-takeoff"></i> Explore Side Hustles</a>
                <a class="nav-link" href="#"><i class="bi bi-briefcase"></i> My Hustles</a>
                <a class="nav-link" href="#"><i class="bi bi-cash-coin"></i> Earnings</a>
                <a class="nav-link" href="#"><i class="bi bi-chat-left-text"></i> Messages</a>
                <a class="nav-link" href="#"><i class="bi bi-stars"></i> AI Copilot</a> -->
                {{-- <a class="nav-link" href="#"><i class="bi bi-bookshelf"></i> Product</a> --}}
                <a class="nav-link" href="#"><i class="bi bi-people"></i> Users (Admin)</a>

            </nav>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme toggle script -->
    <script>
        (function() {
            const root = document.documentElement;
            const btn = document.getElementById('themeToggle');

            function render() {
                const t = root.getAttribute('data-theme') || 'dark';
                btn.innerHTML = t === 'dark' ?
                    '<i class="bi bi-brightness-high"></i>' // sun = go light
                    :
                    '<i class="bi bi-moon-stars"></i>'; // moon = go dark
                btn.title = t === 'dark' ? 'Switch to light' : 'Switch to dark';
            }

            function setTheme(t) {
                root.setAttribute('data-theme', t);
                localStorage.setItem('theme', t);
                render();
            }
            render();
            btn.addEventListener('click', () => {
                setTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
            });
        })();
    </script>

    <!-- Start Walkthrough (Intro.js) -->
    <script>
        function startTour() {
            const steps = [{
                    element: document.querySelector('#sidebar'),
                    intro: "👋 Welcome! This is your sidebar. Navigate to all features from here."
                },
                {
                    element: document.querySelector('#searchInput'),
                    intro: "Search hustles, tools, or messages from here."
                },
                {
                    element: document.querySelector('#aiLaunchBtn'),
                    intro: "Launch the AI Copilot to generate plans and flows."
                },
                {
                    element: document.querySelector('#userMenuBtn'),
                    intro: "Open your account menu for Profile, Settings, and Sign out."
                },
                {
                    element: document.querySelector('#cardsGrid'),
                    intro: "Your top hustles and earnings overview live here."
                }
            ].filter(s => !!s.element); // ignore missing nodes safely

            introJs().setOptions({
                steps,
                showProgress: true,
                nextLabel: 'Next',
                prevLabel: 'Back',
                skipLabel: 'Skip',
                doneLabel: 'Done',
                exitOnOverlayClick: true,
                scrollToElement: true
            }).start();
        }
        document.getElementById('startTourBtn')?.addEventListener('click', startTour);
    </script>




</body>

</html>
