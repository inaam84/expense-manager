<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('home') }}" class="logo logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('images/logos/company_logo.jpg') }}" alt="logo-sm" height="50">
                    </span>
                </a>

                <a href="{{ route('home') }}" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('images/logos/company_logo.jpg') }}" alt="logo-sm-light" height="50">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <!-- App Search-->
            {{ html()->form('GET', '')->attributes(['name' => 'frmGlobalSearch', 'id' => 'frmGlobalSearch', 'class' => 'app-search d-none d-lg-block'])->open() }}
            {{ html()->hidden('_reset', 2) }}
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="Ticket number..." name="ticket_number">
                <span class="ri-search-line"></span>
            </div>
            {{ html()->form()->close() }}


        </div>

        <div class="d-flex">




            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>


            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ !empty(auth()->user()->avatar_location) ? auth()->user()->getPicture() : url('images/no_image.jpg') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ auth()->user()->firstname }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="{{ route('users.2fa') }}"><i class="ri-key-line align-middle me-1"></i> Two Factor Auth</a>
                    {{-- <a class="dropdown-item" href=""><i class="ri-wallet-2-line align-middle me-1"></i> Change Password</a>
                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                    <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock screen</a> --}}
                    <div class="dropdown-divider"></div>
                    <a id="linkLogout" class="dropdown-item text-danger" href="#"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>


        </div>
    </div>
</header>
