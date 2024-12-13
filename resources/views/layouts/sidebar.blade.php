<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- User details -->
        <div class="user-profile text-center mt-3">
            <div class="text-center">
                <img src="{{ !empty(auth()->user()->avatar_location) ? auth()->user()->getPicture() : url('images/no_image.jpg') }}"
                    alt="Profile Image" class="avatar-md rounded-circle">
            </div>
            <div class="mt-3">
                <h4 class="font-size-16 mb-1">{{ auth()->user()?->full_name }}</h4>
                <code>{{ auth()->user()?->username }}</code>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="{{ request()->route('home') ? 'mm-active' : '' }}">
                    <a href="{{ route('home') }}" class="waves-effect {{ request()->route('home') ? 'mm-active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class="{{ request()->is('system_admin/*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect {{ request()->is('system_admin/*') ? 'mm-active' : '' }}">
                        <i class="fas fa-cogs"></i>
                        <span>System Admin</span>
                    </a>
                    <ul class="sub-menu mm-collapse {{ request()->is('system_admin/*') ? 'mm-show' : '' }}" aria-expanded="false">
                        <li class="{{ request()->is('system_admin/users/*') ? 'mm-active' : '' }}">
                            <a href="{{ route('users.index') }}" class="waves-effect {{ request()->route('users.index') ? 'mm-active' : '' }}">
                                <i class="fas fa-users"></i>
                                <span>Users</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
