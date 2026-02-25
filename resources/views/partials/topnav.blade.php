
<div class="dch-topnav">

    <!-- LEFT (collapse icon) -->
    <div class="top-left">
        <i class="bi bi-list" id="menu-toggle"></i>
    </div>

     <!-- Profile dropdown -->
        <div class="dropdown top-right  ">
            <button class=" user-btn  " id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false"
                aria-label="Account menu">
                <i class="bi bi-person-circle"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end usermenu" aria-labelledby="userMenuBtn">
                <li class="px-3 py-2 border-bottom usermenu-header">
                    <div class="fw-semibold">{{ Auth::user()->name ?? 'User' }}</div>
                </li>            
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Sign out
                        </button>
                    </form>
                </li>
            </ul>
        </div>

</div>
