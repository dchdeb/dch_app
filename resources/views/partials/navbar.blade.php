<div class="topbar">


    <div class="">


       
            {{-- <button class="icon-btn" id="userMenuBtn" data-bs-toggle="dropdown" aria-expanded="false"
                aria-label="Account menu">
                <i class="bi bi-person-circle"></i>
            </button>       d-none d-md-flex gap-2 ms-auto --}}


            <div class="page-navbar d-flex align-items-center px-3 py-2">

                <!-- LEFT : Breadcrumb -->
                <div class="breadcrumb-area">
                    @yield('breadcrumb')
                </div>

                <!-- RIGHT : optional future buttons -->
                <div class="ms-auto">
                    @yield('page-actions')
                </div>

            </div>


        
    </div>
</div>
