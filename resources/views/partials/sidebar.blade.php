<style>
    .nav-link.active {
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
    }
</style>

@php
    // tiny helpers
    $is = fn($pattern) => request()->routeIs($pattern);
    $active = fn($pattern) => $is($pattern) ? 'active' : '';

    // Check if user has any permission for a module
    $hasModuleAccess = function($module) {
        $permissions = [
            "{$module}.view",
            "{$module}.create",
            "{$module}.edit",
            "{$module}.delete",
        ];
        foreach ($permissions as $perm) {
            if (auth()->user()->can($perm)) {
                return true;
            }
        }
        return false;
    };

    // Submenu open state 
    $registrationOpen = $is('patient-registration.*') || $is('emergency.*');
    $clinicalOpen = $is('opd.*') || $is('cpd.*') || $is('ipd.*') || $is('ipminor.*') || $is('daily-case.*');
    $specialtyOpen = $is('dental.*') || $is('physiotherapy.*');
    $supportOpen = $is('pharmacy.*') || $is('lab.*');
    $adminOpen = $is('mis-report.*') || $is('accounts.*');
    $inventoryOpen = $is('store.*') || $is('inventory.*') || $is('canteen.*');
    $settingsOpen = $is('settings.*');
    $otOpen = $is('ot-management.*');
@endphp


<aside class="sidebar d-none d-lg-flex flex-column" id="sidebar">

    <nav class="nav flex-column gap-1 mt-2 sidebar-menu" style="">

        {{-- Dashboard - Visible to all authenticated users --}}
        <a class="nav-link {{ $active('dashboard') }}" href="{{ route('dashboard') }}">
            <span class="nav-ico"><i class="bi bi-speedometer2"></i></span>
            <span class="fw-semibold sidebar-title">Dashboard</span>
        </a>

        {{-- Registration Section --}}
        @canany(['patient-registration.view', 'patient-registration.create', 'emergency.view', 'emergency.create'])
        <div class="has-submenu {{ $registrationOpen ? 'open' : '' }}">
            <a class="nav-link {{ $registrationOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this); return false;">
                <span class="nav-ico"><i class="bi bi-person-badge"></i></span>
                <span class="fw-semibold sidebar-title">Registration</span>
            </a>
            <div class="menu-dropdown submenu {{ $registrationOpen ? 'show' : '' }}">
                @canany(['patient-registration.view', 'patient-registration.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('patient-registration.*') }}" href="{{ route('patient-registration.index') ?? '#' }}">
                    <i class="bi bi-person-plus me-2"></i>Patient Registration
                </a>
                @endcanany
                @canany(['emergency.view', 'emergency.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('emergency.*') }}" href="{{ route('emergency.index') ?? '#' }}">
                    <i class="bi bi-heart-pulse me-2"></i>Emergency
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Clinical Services Section --}}
        @canany(['opd.view', 'opd.create', 'cpd.view', 'ipd.view', 'ipminor.view', 'daily-case.view'])
        <div class="has-submenu {{ $clinicalOpen ? 'open' : '' }}">
            <a class="nav-link {{ $clinicalOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this); return false;">
                <span class="nav-ico"><i class="bi bi-hospital"></i></span>
                <span class="fw-semibold sidebar-title">Clinical Services</span>
            </a>
            <div class="menu-dropdown submenu {{ $clinicalOpen ? 'show' : '' }}">
                @canany(['opd.view', 'opd.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('opd.*') }}" href="{{ route('opd.index') ?? '#' }}">
                    <i class="bi bi-calendar-check me-2"></i>OPD
                </a>
                @endcanany
                @canany(['cpd.view', 'cpd.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('cpd.*') }}" href="{{ route('cpd.index') ?? '#' }}">
                    <i class="bi bi-calendar-week me-2"></i>CPD
                </a>
                @endcanany
                @canany(['ipd.view', 'ipd.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('ipd.*') }}" href="{{ route('ipd.index') ?? '#' }}">
                    <i class="bi bi-door-open me-2"></i>IPD
                </a>
                @endcanany
                @canany(['ipminor.view', 'ipminor.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('ipminor.*') }}" href="{{ route('ipminor.index') ?? '#' }}">
                    <i class="bi bi-bandaid me-2"></i>IP Minor
                </a>
                @endcanany
                @canany(['daily-case.view', 'daily-case.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('daily-case.*') }}" href="{{ route('daily-case.index') ?? '#' }}">
                    <i class="bi bi-journal-text me-2"></i>Daily Case
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- OT Management --}}
        @canany(['ot-management.view', 'ot-management.create'])
        <div class="has-submenu {{ $otOpen ? 'open' : '' }}">
            <a class="nav-link {{ $otOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this); return false;">
                <span class="nav-ico"><i class="bi bi-tools"></i></span>
                <span class="fw-semibold sidebar-title">OT Management</span>
            </a>
            <div class="menu-dropdown submenu {{ $otOpen ? 'show' : '' }}">
                @canany(['ot-management.view', 'ot-management.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('ot-management.*') }}" href="{{ route('ot-management.index') ?? '#' }}">
                    <i class="bi bi-calendar2-event me-2"></i>OT Schedule
                </a>
                @endcanany
                {{-- <a class="nav-link nav-sublink {{ $active('ot-theatre.*') }}" href="{{ route('ot-theatre.index') ?? '#' }}">
                    <i class="bi bi-building me-2"></i>OT Theatre
                </a> --}}
            </div>
        </div>
        @endcanany

        {{-- Specialty Services --}} 
        @canany(['dental.view', 'dental.create', 'physiotherapy.view', 'physiotherapy.create'])
        <div class="has-submenu {{ $specialtyOpen ? 'open' : '' }}">
            <a class="nav-link {{ $specialtyOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this); return false;">
                <span class="nav-ico"><i class="bi bi-stars"></i></span>
                <span class="fw-semibold sidebar-title">Specialty Services</span>
            </a>
            <div class="menu-dropdown submenu {{ $specialtyOpen ? 'show' : '' }}">
                @canany(['dental.view', 'dental.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('dental.*') }}" href="{{ route('dental.index') ?? '#' }}">
                    <i class="bi bi-emoji-smile me-2"></i>Dental
                </a>
                @endcanany
                @canany(['physiotherapy.view', 'physiotherapy.create'])
                <a class="nav-link nav-sublink nav-sub-category-title{{ $active('physiotherapy.*') }}" href="{{ route('physiotherapy.index') ?? '#' }}">
                    <i class="bi bi-person-walking me-2"></i>Physiotherapy
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Support Services --}}
        @canany(['pharmacy.view', 'pharmacy.create', 'lab.view', 'lab.create'])
        <div class="has-submenu {{ $supportOpen ? 'open' : '' }}">
            <a class="nav-link {{ $supportOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this); return false;">
                <span class="nav-ico"><i class="bi bi-capsule"></i></span>
                <span class="fw-semibold sidebar-title">Support Services</span>
            </a>
            <div class="menu-dropdown submenu {{ $supportOpen ? 'show' : '' }}">
                @canany(['pharmacy.view', 'pharmacy.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('pharmacy.*') }}" href="{{ route('pharmacy.index') ?? '#' }}">
                    <i class="bi bi-prescription2 me-2"></i>Pharmacy
                </a>
                @endcanany
                @canany(['lab.view', 'lab.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('lab.*') }}" href="{{ route('lab.index') ?? '#' }}">
                    <i class="bi bi-clipboard2-pulse me-2"></i>Lab
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Inventory & Store --}}
        @canany(['store.view', 'store.create', 'inventory.view', 'inventory.create', 'canteen.view', 'canteen.create'])
        <div class="has-submenu {{ $inventoryOpen ? 'open' : '' }}">
            <a class="nav-link {{ $inventoryOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this); return false;">
                <span class="nav-ico"><i class="bi bi-box-seam"></i></span>
                <span class="fw-semibold sidebar-title">Inventory & Store</span>
            </a>
            <div class="menu-dropdown submenu {{ $inventoryOpen ? 'show' : '' }}">
                @canany(['store.view', 'store.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('store.*') }}" href="{{ route('store.index') ?? '#' }}">
                    <i class="bi bi-shop me-2"></i>Store
                </a>
                @endcanany
                @canany(['inventory.view', 'inventory.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('inventory.*') }}" href="{{ route('inventory.index') ?? '#' }}">
                    <i class="bi bi-boxes me-2"></i>Inventory
                </a>
                @endcanany
                @canany(['canteen.view', 'canteen.create'])
                <a class="nav-link nav-sublink nav-sub-category-title{{ $active('canteen.*') }}" href="{{ route('canteen.index') ?? '#' }}">
                    <i class="bi bi-cup-hot me-2"></i>Canteen
                </a>
                @endcanany
            </div>
        </div>
        @endcanany

        {{-- Admin & Reports --}}
        @canany(['mis-report.view', 'mis-report.export', 'accounts.view', 'accounts.create'])
        <div class="has-submenu {{ $adminOpen ? 'open' : '' }}">
            <a class="nav-link {{ $adminOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this); return false;">
                <span class="nav-ico"><i class="bi bi-graph-up-arrow"></i></span>
                <span class="fw-semibold sidebar-title">Admin & Reports</span>
            </a>
            <div class="menu-dropdown submenu {{ $adminOpen ? 'show' : '' }}">
                @canany(['mis-report.view', 'mis-report.export'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('mis-report.*') }}" href="{{ route('mis-report.index') ?? '#' }}">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>MIS Report
                </a>
                @endcanany
                @canany(['accounts.view', 'accounts.create'])
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('accounts.*') }}" href="{{ route('accounts.index') ?? '#' }}">
                    <i class="bi bi-cash-stack me-2"></i>Accounts
                </a>
                @endcanany 
            </div>
        </div>
        @endcanany

        {{-- Settings --}}
        @canany(['settings.view', 'settings.users.manage', 'settings.roles.manage', 'settings.permissions.manage', 'settings.system.configure'])
        <div class="has-submenu {{ $settingsOpen ? 'open' : '' }}">
            <a class="nav-link {{ $settingsOpen ? 'active' : '' }}" href="javascript:void(0)" onclick="toggleSubmenu(this); return false;">
                <span class="nav-ico"><i class="bi bi-gear"></i></span>
                <span class="fw-semibold sidebar-title">Settings</span>
            </a>
            <div class="menu-dropdown submenu {{ $settingsOpen ? 'show' : '' }}">
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('settings.index') }}" href="{{ route('settings.index') }}">
                    <i class="bi bi-sliders me-2"></i>General Settings
                </a>
                @can('settings.users.manage')
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('settings.security_settings.users.*') }}" href="{{ route('settings.security_settings.users.index') }}">
                    <i class="bi bi-people me-2"></i>User Management
                </a>
                @endcan 
                @can('settings.roles.manage')
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('settings.security_settings.roles.*') }}" href="{{ route('settings.security_settings.roles.index') }}">
                    <i class="bi bi-person-badge me-2"></i>Role Management
                </a>
                @endcan
                @can('settings.permissions.manage')
                <a class="nav-link nav-sublink nav-sub-category-title {{ $active('settings.security_settings.permissions.*') }}" href="{{ route('settings.security_settings.permissions.index') }}">
                    <i class="bi bi-key me-2"></i>Permission Management
                </a>
                @endcan
                {{-- @can('settings.system.configure')
                <a class="nav-link nav-sublink {{ $active('settings.system.*') }}" href="{{ route('settings.system.index') ?? '#' }}">
                    <i class="bi bi-wrench-adjustable me-2"></i>System Configuration
                </a>
                @endcan --}}
                {{-- @can('settings.backup.manage')
                <a class="nav-link nav-sublink {{ $active('settings.backup.*') }}" href="{{ route('settings.backup.index') ?? '#' }}">
                    <i class="bi bi-cloud-arrow-up me-2"></i>Backup & Restore
                </a>
                @endcan --}}
                {{-- @can('settings.audit.view')
                <a class="nav-link nav-sublink {{ $active('settings.audit.*') }}" href="{{ route('settings.audit.index') ?? '#' }}">
                    <i class="bi bi-journal-text me-2"></i>Audit Logs
                </a>
                @endcan --}}
            </div>
        </div>
        @endcanany

    </nav>

</aside>

@push('scripts')
<script>
    function toggleSubmenu(element) {
        const parent = element.parentElement;
        const dropdown = parent.querySelector('.menu-dropdown');

        // Close other open submenus at the same level
        // parent.parentElement.querySelectorAll('.has-submenu.open').forEach(item => {
        //     if (item !== parent) {
        //         item.classList.remove('open');
        //         item.querySelector('.menu-dropdown').classList.remove('show');
        //     }
        // });

        // Toggle current submenu
        parent.classList.toggle('open');
        dropdown.classList.toggle('show');
    }

    // Open submenu if any child is active
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.menu-dropdown .nav-sublink.active').forEach(link => {
            const parent = link.closest('.has-submenu');
            if (parent) {
                parent.classList.add('open');
                parent.querySelector('.menu-dropdown').classList.add('show');
            } 
        });
    });
</script>
@endpush




