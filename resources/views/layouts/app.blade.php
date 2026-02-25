<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eHustle</title>

    {{-- Tailwind user korechi design er jonno default ager jototuk chilo seigulo --}}
    
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --brand-primary: #2D6DF6;
            --brand-secondary: #3B33E5;
            --brand-surface: #0B1020;
            --brand-card: #0f152b;
            --brand-text: #e5e7eb;
            --brand-muted: #9aa4b2;
            --border-muted: #111827;
        }

        body {
            background: var(--brand-surface);
            color: var(--brand-text);
        }

        .card {
            background: var(--brand-card);
            border: none;
        }

        .card .card-header {
            border-bottom: 1px solid var(--border-muted);
        }

        .sidebar {
            width: 442px;
            min-height: 100vh;
            border-right: 1px solid var(--border-muted);
            background: linear-gradient(180deg, var(--brand-surface) 0%, #0b1229 100%);
        }

        .menu-item {
            color: var(--brand-text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem .9rem;
            border-radius: .75rem
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, .03);
        }

        .tag {
            font-size: .7rem;
            padding: .2rem .45rem;
            border-radius: .4rem;
            background: color-mix(in oklab, var(--brand-primary) 10%, transparent);
            color: var(--brand-primary);
        }

        .muted {
            color: var(--brand-muted);
        }

        .topbar {
            border-bottom: 1px solid var(--border-muted);
        }

        .eh-logo {
            width: 36px;
            height: 36px;
            display: inline-block;
            border-radius: 50%;
            background: radial-gradient(120% 120% at 0% 0%, var(--brand-primary), var(--brand-secondary));
            position: relative;
            overflow: hidden;
        }

        .eh-logo::after {
            content: "";
            position: absolute;
            inset: 8px 10px 8px 14px;
            background: #fff;
            border-radius: 20px 40px 40px 20px / 20px 28px 28px 20px;
            transform: rotate(-14deg);
        }

        .stat-chip {
            background: linear-gradient(135deg, color-mix(in oklab, var(--brand-primary) 12%, transparent), color-mix(in oklab, var(--brand-secondary) 12%, transparent));
            padding: .6rem;
            border-radius: .9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <aside class="sidebar p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    {{-- <span class="eh-logo"></span> --}}
                    <a href="{{ route('dashboard') }}">
                        <div class="fw-bold"><img src="{{ asset('image/logo/eHustle_Logo.png') }}" alt="eHustle"
                                width="100%"></div>
                       
                    </a>
                </div>
            </div>

            <nav class="d-grid gap-1">
                <a class="menu-item" href="{{ route('dashboard') }}"><i
                        class="bi bi-house-door muted"></i><span>Dashboard</span></a>
                {{-- <a class="menu-item" href="#"><i class="bi bi-book muted"></i><span>Products</span></a> --}}
                <a class="menu-item" href="#"><i class="bi bi-people muted"></i><span>Users (Admin)</span></a>
               
            </nav>

            {{-- <div class="mt-3">
                <button class="btn w-100 text-white"
                    style="background:linear-gradient(135deg, var(--brand-primary), var(--brand-secondary))">
                    <i class="bi bi-stars me-2"></i> New AI Project
                </button>
            </div> --}}
        </aside>

        {{-- Main --}}
        <main class="flex-grow-1">
            {{-- Topbar --}}
            <div class="topbar d-flex align-items-center justify-content-between px-4 py-3">
                <div class="input-group" style="max-width: 520px;">
                    <span class="input-group-text bg-transparent border-secondary-subtle text-white-50"><i
                            class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-transparent border-secondary-subtle text-white"
                        placeholder="Search hustles, tools, or messages…">
                </div>
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-bell fs-5 text-white-50"></i>
                    <i class="bi bi-person-circle fs-4 text-white-50"></i>
                </div>
            </div>

            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
