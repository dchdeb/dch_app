<style>
    .nav-link.active {
        /* background: color-mix(in oklab, var(--brand) 16%, transparent);
        border: 1px solid var(--brand); */
        color: var(--text);
        border-radius: 10px;
    }

    /* .subnav .nav-sublink.active {
        color: rgb(255, 255, 255);
        font-weight: 600px;
    } */
    .sidebar-title {
        color: rgb(255, 255, 255)
    }

    /* normal */
    .app {
        /* margin-left: 240px;
        padding-top: 110px;
        transition: 0.3s ease; */
    }

    /* collapse */
    /* .sidebar-collapsed .app {
        margin-left: 70px;
    } */


    /* normal sidebar */
    /* .sidebar{
    position: fixed;
    top:110px;
    left:0;
    width:240px;
    height:calc(100vh - 110px);
    background:#2f3542;
    transition:0.3s ease;
    overflow-y:auto;
} */

    /* content area */
    /* .app{
    padding-top:110px;
    padding-left:240px;
    transition:0.3s ease;
} */

    /* ===== COLLAPSE MODE ===== */
    .sidebar-collapsed .sidebar {
        width: 65px;
    }

    /* content shift */
    .sidebar-collapsed .app {
       margin-left: 0px;
    }
</style>

@php
    // tiny helpers
    $is = fn($pattern) => request()->routeIs($pattern);
    $active = fn($pattern) => $is($pattern) ? 'active' : '';

    // submenu open state (extend these patterns as you add routes)
    $userMenuOpen = $is('profile.*') || $is('users.*');
@endphp


<aside class="sidebar d-none d-lg-flex flex-column" id="sidebar">

    {{-- <button class="btn " data-bs-toggle="offcanvas" data-bs-target="#mSidebar" aria-label="Open menu">
        <i class="bi bi-list fs-4"></i>
    </button> --}}

    <nav class="nav flex-column gap-1 mt-2 sidebar-menu">
        <a class="nav-link {{ $active('dashboard') }}" href="{{ route('dashboard') }}">
            <span class="nav-ico "><i class="bi bi-speedometer2"></i></span>
            <span class=" fw-semibold sidebar-title ">Home</span>
        </a>

        {{-- <a class="nav-link {{ $active('earnings.*') }}" href="{{ route('orders.index') }}">
            <span class="nav-ico"><i class="bi bi-cash-coin"></i></span>
            <span>Orders</span>
        </a> --}}

        <a class="nav-link {{ $active('messages.*') }}" href="#">
            <span class="nav-ico"><i class="bi bi-chat-left-text"></i></span>
            <span class=" fw-semibold sidebar-title">Registrations</span>
        </a>

         <a class="nav-link {{ $active('settings.*') }}" href="{{ route('settings.index') }}">
            <span class="nav-ico"><i class="bi bi-chat-left-text"></i></span>
            <span class=" fw-semibold sidebar-title">Settings</span>
        </a>

        {{-- <a class="nav-link {{ $active('copilot.*') }}" href="{{ route('products.index') }}">
            <span class="nav-ico"><i class="bi bi-stars"></i></span>
            <span>Products</span>
        </a> --}}

    </nav>


</aside>
