<style>
    /* .nav-link.active {
        color: var(--text);
        border-radius: 10px;
    }
    .sidebar-title {
        color: rgb(255, 255, 255)
    }
    .sidebar-collapsed .sidebar {
        width: 65px;
    }
    .sidebar-collapsed .app {
       margin-left: 0px;
    }
    .menu-dropdown {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    .menu-dropdown.show {
        max-height: 500px;
    }
    .has-submenu > .nav-link::after {
        content: '\F282';
        font-family: 'bootstrap-icons';
        margin-left: auto;
        transition: transform 0.3s ease;
    }
    .has-submenu.open > .nav-link::after {
        transform: rotate(180deg);
    }
    .submenu .nav-sublink {
        padding-left: 2.5rem !important;
        font-size: 0.9rem;
    }
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.05);
    }
    .nav-link.active { 
        background: rgba(255, 255, 255, 0.1);
    }

    .nav-sub-category-title{
            color: rgb(226, 222, 222) !important;
    } */





       /* Sidebar base styles */
    /* .sidebar {
        position: fixed;
        top: 110px;
        left: 0;
        width: 240px;
        height: calc(100vh - 110px);
        background: var(--surface, #1a1d21);
        transition: 0.3s ease;
        z-index: 1000;
        overflow-y: auto;
    } */

    .sidebar-menu {
        padding: 0.5rem;
    }

    /* Nav link styles */
    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }

    .sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    .sidebar .nav-ico {
        margin-right: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
    }

    .sidebar-title {
        color: rgb(255, 255, 255);
        font-weight: 500;
    }

    /* Level 1 Submenu styles */
    .has-submenu {
        position: relative;
    }

    .has-submenu > .nav-link::after {
        content: '\F282';
        font-family: 'bootstrap-icons';
        margin-left: auto;
        transition: transform 0.3s ease;
        font-size: 0.75rem;
    }

    .has-submenu.open > .nav-link::after {
        transform: rotate(180deg);
    }

    .menu-dropdown {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s ease-out;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 0 0 8px 8px;
        margin-top: -4px;
        margin-bottom: 4px;
    }

    .menu-dropdown.show {
        max-height: 1500px;
        transition: max-height 0.5s ease-in;
    }

    /* Level 1 Submenu link styles */
    .nav-sublink {
        padding: 0.6rem 1rem 0.6rem 2.5rem !important;
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .nav-sublink:hover {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.05) !important;
    }

    .nav-sublink.active {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.1) !important;
    }

    .nav-sublink i {
        font-size: 0.85rem;
    }

    /* Level 2 - Nested Submenu styles */
    .has-submenu-nested {
        position: relative;
    }

    .has-submenu-nested > .nav-sublink::after {
        content: '\F282';
        font-family: 'bootstrap-icons';
        margin-left: auto;
        transition: transform 0.3s ease;
        font-size: 0.7rem;
    }

    .has-submenu-nested.open > .nav-sublink::after {
        transform: rotate(180deg);
    }

    .menu-dropdown-nested {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
        background: rgba(0, 0, 0, 0.2);
        margin-top: -2px;
        margin-bottom: 2px;
    }

    .menu-dropdown-nested.show {
        max-height: 500px;
        transition: max-height 0.4s ease-in;
    }

    /* Level 2 Submenu link styles */
    .nav-sublink-2 {
        padding: 0.5rem 1rem 0.5rem 3.5rem !important;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.6) !important;
    }

    .nav-sublink-2:hover {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.05) !important;
    }

    .nav-sublink-2.active {
        color: #fff !important;
        background: rgba(255, 255, 255, 0.08) !important;
    }

    .nav-sublink-2 i {
        font-size: 0.8rem;
    }

    /* Collapsed sidebar */
    .sidebar-collapsed .sidebar {
        width: 65px;
    }

    .sidebar-collapsed .sidebar-title,
    .sidebar-collapsed .menu-dropdown,
    .sidebar-collapsed .menu-dropdown-nested,
    .sidebar-collapsed .has-submenu > .nav-link::after,
    .sidebar-collapsed .has-submenu-nested > .nav-sublink::after {
        display: none;
    }

    .sidebar-collapsed .nav-link {
        justify-content: center;
        padding: 0.75rem;
    }

    .sidebar-collapsed .nav-ico {
        margin-right: 0;
    }







</style>

@php
  // tiny helpers
    $is = fn($pattern) => request()->routeIs($pattern);
    $active = fn($pattern) => $is($pattern) ? 'active' : '';

    // Submenu open state based on current route
    $registrationOpen = $is('patient-registration.*') || $is('emergency.*');
    $clinicalOpen = $is('opd.*') || $is('cpd.*') || $is('ipd.*') || $is('ipminor.*') || $is('daily-case.*');
    $specialtyOpen = $is('dental.*') || $is('physiotherapy.*');
    $supportOpen = $is('pharmacy.*') || $is('lab.*');
    $adminOpen = $is('mis-report.*') || $is('accounts.*');
    $inventoryOpen = $is('store.*') || $is('inventory.*') || $is('canteen.*');
    $otOpen = $is('ot-management.*');
    
    // Settings submenu - check if security pages are open
    $securityOpen = $is('settings.security.*') || $is('settings.security_settings.*');
    $settingsOpen = $is('settings.*');
@endphp


<aside class="sidebar d-none d-lg-flex flex-column" id="sidebar">

     <nav class="nav flex-column gap-1 sidebar-menu">

        {{-- Dashboard --}}
        <a class="nav-link {{ $active('dashboard') }}" href="{{ route('dashboard') }}">
            <span class="nav-ico"><i class="bi bi-speedometer2"></i></span>
            <span class="sidebar-title">Dashboard</span>
        </a>

        {{-- Registration Section --}}
        @canany(['patient-registration.view', 'patient-registration.create', 'emergency.view', 'emergency.create'])
        <div class="has-submenu {{ $registrationOpen ? 'open' : '' }}">
            <a class="nav-link {{ $registrationOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this)">
                <span class="nav-ico"><i class="bi bi-person-badge"></i></span>
                <span class="sidebar-title">Registration</span>
            </a>
            <div class="menu-dropdown {{ $registrationOpen ? 'show' : '' }}">
                @canany(['patient-registration.view', 'patient-registration.create'])
                <a class="nav-link nav-sublink {{ $active('patient-registration.*') }}" href="{{ route('patient-registration.index') ?? '#' }}">
                    <i class="bi bi-person-plus me-2"></i>Patient Registration
                </a>
                @endcanany
                @canany(['emergency.view', 'emergency.create'])
                <a class="nav-link nav-sublink {{ $active('emergency.*') }}" href="{{ route('emergency.index') ?? '#' }}">
                    <i class="bi bi-heart-pulse me-2"></i>Emergency
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Clinical Services Section --}}
        @canany(['opd.view', 'opd.create', 'cpd.view', 'ipd.view', 'ipminor.view', 'daily-case.view'])
        <div class="has-submenu {{ $clinicalOpen ? 'open' : '' }}">
            <a class="nav-link {{ $clinicalOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this)">
                <span class="nav-ico"><i class="bi bi-hospital"></i></span>
                <span class="sidebar-title">Clinical Services</span>
            </a>
            <div class="menu-dropdown {{ $clinicalOpen ? 'show' : '' }}">
                @canany(['opd.view', 'opd.create'])
                <a class="nav-link nav-sublink {{ $active('opd.*') }}" href="{{ route('opd.index') ?? '#' }}">
                    <i class="bi bi-calendar-check me-2"></i>OPD
                </a>
                @endcanany
                @canany(['cpd.view', 'cpd.create'])
                <a class="nav-link nav-sublink {{ $active('cpd.*') }}" href="{{ route('cpd.index') ?? '#' }}">
                    <i class="bi bi-calendar-week me-2"></i>CPD
                </a>
                @endcanany
                @canany(['ipd.view', 'ipd.create'])
                <a class="nav-link nav-sublink {{ $active('ipd.*') }}" href="{{ route('ipd.index') ?? '#' }}">
                    <i class="bi bi-door-open me-2"></i>IPD
                </a>
                @endcanany
                @canany(['ipminor.view', 'ipminor.create'])
                <a class="nav-link nav-sublink {{ $active('ipminor.*') }}" href="{{ route('ipminor.index') ?? '#' }}">
                    <i class="bi bi-bandaid me-2"></i>IP Minor
                </a>
                @endcanany
                @canany(['daily-case.view', 'daily-case.create'])
                <a class="nav-link nav-sublink {{ $active('daily-case.*') }}" href="{{ route('daily-case.index') ?? '#' }}">
                    <i class="bi bi-journal-text me-2"></i>Daily Case
                </a>
                @endcanany 
            </div>
        </div>
        @endcanany

        {{-- OT Management --}}
        @canany(['ot-management.view', 'ot-management.create'])
        <div class="has-submenu {{ $otOpen ? 'open' : '' }}">
            <a class="nav-link {{ $otOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this)">
                <span class="nav-ico"><i class="bi bi-tools"></i></span>
                <span class="sidebar-title">OT Management</span>
            </a>
            <div class="menu-dropdown {{ $otOpen ? 'show' : '' }}">
                @canany(['ot-management.view', 'ot-management.create'])
                <a class="nav-link nav-sublink {{ $active('ot-management.*') }}" href="{{ route('ot-management.index') ?? '#' }}">
                    <i class="bi bi-calendar2-event me-2"></i>OT Schedule
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Specialty Services --}}
        @canany(['dental.view', 'dental.create', 'physiotherapy.view', 'physiotherapy.create'])
        <div class="has-submenu {{ $specialtyOpen ? 'open' : '' }}">
            <a class="nav-link {{ $specialtyOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this)">
                <span class="nav-ico"><i class="bi bi-stars"></i></span>
                <span class="sidebar-title">Specialty Services</span>
            </a>
            <div class="menu-dropdown {{ $specialtyOpen ? 'show' : '' }}">
                @canany(['dental.view', 'dental.create'])
                <a class="nav-link nav-sublink {{ $active('dental.*') }}" href="{{ route('dental.index') ?? '#' }}">
                    <i class="bi bi-emoji-smile me-2"></i>Dental
                </a>
                @endcanany
                @canany(['physiotherapy.view', 'physiotherapy.create'])
                <a class="nav-link nav-sublink {{ $active('physiotherapy.*') }}" href="{{ route('physiotherapy.index') ?? '#' }}">
                    <i class="bi bi-person-walking me-2"></i>Physiotherapy
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Support Services --}}
        @canany(['pharmacy.view', 'pharmacy.create', 'lab.view', 'lab.create'])
        <div class="has-submenu {{ $supportOpen ? 'open' : '' }}">
            <a class="nav-link {{ $supportOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this)">
                <span class="nav-ico"><i class="bi bi-capsule"></i></span>
                <span class="sidebar-title">Support Services</span>
            </a>
            <div class="menu-dropdown {{ $supportOpen ? 'show' : '' }}">
                @canany(['pharmacy.view', 'pharmacy.create'])
                <a class="nav-link nav-sublink {{ $active('pharmacy.*') }}" href="{{ route('pharmacy.index') ?? '#' }}">
                    <i class="bi bi-prescription2 me-2"></i>Pharmacy
                </a>
                @endcanany
                @canany(['lab.view', 'lab.create'])
                <a class="nav-link nav-sublink {{ $active('lab.*') }}" href="{{ route('lab.index') ?? '#' }}">
                    <i class="bi bi-clipboard2-pulse me-2"></i>Lab
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Inventory & Store --}}
        @canany(['store.view', 'store.create', 'inventory.view', 'inventory.create', 'canteen.view', 'canteen.create'])
        <div class="has-submenu {{ $inventoryOpen ? 'open' : '' }}">
            <a class="nav-link {{ $inventoryOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this)">
                <span class="nav-ico"><i class="bi bi-box-seam"></i></span>
                <span class="sidebar-title">Inventory & Store</span>
            </a>
            <div class="menu-dropdown {{ $inventoryOpen ? 'show' : '' }}">
                @canany(['store.view', 'store.create'])
                <a class="nav-link nav-sublink {{ $active('store.*') }}" href="{{ route('store.index') ?? '#' }}">
                    <i class="bi bi-shop me-2"></i>Store
                </a>
                @endcanany
                @canany(['inventory.view', 'inventory.create'])
                <a class="nav-link nav-sublink {{ $active('inventory.*') }}" href="{{ route('inventory.index') ?? '#' }}">
                    <i class="bi bi-boxes me-2"></i>Inventory
                </a>
                @endcanany
                @canany(['canteen.view', 'canteen.create'])
                <a class="nav-link nav-sublink {{ $active('canteen.*') }}" href="{{ route('canteen.index') ?? '#' }}">
                    <i class="bi bi-cup-hot me-2"></i>Canteen
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Admin & Reports --}}
        @canany(['mis-report.view', 'mis-report.export', 'accounts.view', 'accounts.create'])
        <div class="has-submenu {{ $adminOpen ? 'open' : '' }}">
            <a class="nav-link {{ $adminOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this)">
                <span class="nav-ico"><i class="bi bi-graph-up-arrow"></i></span>
                <span class="sidebar-title">Admin & Reports</span>
            </a>
            <div class="menu-dropdown {{ $adminOpen ? 'show' : '' }}">
                @canany(['mis-report.view', 'mis-report.export'])
                <a class="nav-link nav-sublink {{ $active('mis-report.*') }}" href="{{ route('mis-report.index') ?? '#' }}">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>MIS Report
                </a>
                @endcanany
                @canany(['accounts.view', 'accounts.create'])
                <a class="nav-link nav-sublink {{ $active('accounts.*') }}" href="{{ route('accounts.index') ?? '#' }}">
                    <i class="bi bi-cash-stack me-2"></i>Accounts
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Settings with Nested Submenus --}}
        @canany(['settings.view', 'settings.users.manage', 'settings.roles.manage', 'settings.permissions.manage', 'settings.system.configure'])
        <div class="has-submenu {{ $settingsOpen ? 'open' : '' }}">
            <a class="nav-link {{ $settingsOpen ? 'active' : '' }}" href="{{ route('settings.index') }}" onclick="toggleSubmenu(this)">
                <span class="nav-ico"><i class="bi bi-gear"></i></span>
                <span class="sidebar-title">Settings</span>
            </a>
            <div class="menu-dropdown {{ $settingsOpen ? 'show' : '' }}">
                
                {{-- General Settings --}}
                <a class="nav-link nav-sublink {{ $active('settings.index') }}" href="">
                    <i class="bi bi-sliders me-2"></i>General Settings
                </a>
                
                {{-- Security Settings - Nested Submenu --}}
                @canany(['settings.users.manage', 'settings.roles.manage', 'settings.permissions.manage'])
                <div class="has-submenu-nested {{ $securityOpen ? 'open' : '' }}">
                    <a class="nav-link nav-sublink {{ $securityOpen ? 'active' : '' }}" href="{{ route('settings.security_settings.index') }}" onclick="toggleSubmenu(this)">
                        <i class="bi bi-shield-lock me-2"></i>Security Settings
                    </a>
                    <div class="menu-dropdown-nested {{ $securityOpen ? 'show' : '' }}">
                        @can('settings.users.manage')
                        <a class="nav-link nav-sublink-2 {{ $active('settings.security_settings.users.*') }}" href="{{ route('settings.security_settings.users.index') }}">
                            <i class="bi bi-people me-2"></i>User Management
                        </a>
                        @endcan
                        @can('settings.roles.manage')
                        <a class="nav-link nav-sublink-2 {{ $active('settings.security_settings.roles.*') }}" href="{{ route('settings.security_settings.roles.index') }}">
                            <i class="bi bi-person-badge me-2"></i>Role Management
                        </a>
                        @endcan
                        @can('settings.permissions.manage')
                        <a class="nav-link nav-sublink-2 {{ $active('settings.security_settings.permissions.*') }}" href="{{ route('settings.security_settings.permissions.index') }}">
                            <i class="bi bi-key me-2"></i>Permission Management
                        </a>
                        @endcan
                    </div>
                </div>
                @endcanany
                
            </div>
        </div>
        @endcanany

    </nav>

</aside>

@push('scripts')
<script>
   function toggleSubmenu(element) {
        const parent = element.parentElement;
        const dropdown = parent.querySelector('.menu-dropdown') || parent.querySelector('.menu-dropdown-nested');

        // Toggle current submenu
        parent.classList.toggle('open');
        if (dropdown) {
            dropdown.classList.toggle('show');
        }
    }

    // Open submenu if any child is active (on page load)
    document.addEventListener('DOMContentLoaded', function() {
        // Open level 1 submenus
        document.querySelectorAll('.menu-dropdown .nav-sublink.active, .menu-dropdown .nav-sublink-2.active').forEach(link => {
            const parent = link.closest('.has-submenu');
            if (parent) {
                parent.classList.add('open');
                const dropdown = parent.querySelector('.menu-dropdown');
                if (dropdown) { 
                    dropdown.classList.add('show');
                }
            }
            
            // Also open nested parent if exists
            const nestedParent = link.closest('.has-submenu-nested');
            if (nestedParent) {
                nestedParent.classList.add('open');
                const nestedDropdown = nestedParent.querySelector('.menu-dropdown-nested');
                if (nestedDropdown) {
                    nestedDropdown.classList.add('show');
                }
            }
        });
    });
</script>
@endpush




