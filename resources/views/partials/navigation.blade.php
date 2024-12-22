<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm " style="min-height: 60px; position: fixed; top: 0; left: 0; right: 0; z-index: 2;">
    <div class="d-flex justify-content-between w-100" style="padding:0px 20px; overflow: visible;">
        @auth
            <!-- Authenticated Content -->
            <!-- Hamburger menu - Visible only on small screens -->
            <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <i class="bi bi-list"></i>
            </button>

            <!-- Profile picture dropdown - Small screens -->
            <ul class="navbar-nav ms-2 d-md-none align-items-center" style="position: relative;">
                <li class="nav-item dropdown" style="position: relative;">
                    <a class="nav-link p-0" href="#" role="button" id="profileDropdownSmall" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default_profile_picture.png') }}" 
                        style="width:40px; height:40px;" 
                        alt="profile">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="position: absolute; top: 100%; left: auto; right: 0;" aria-labelledby="profileDropdownSmall">
                        <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                        <li><a class="dropdown-item" href="/profile">Profile</a></li>
                        <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Profile picture dropdown - Medium/Large screens -->
            <ul class="navbar-nav ms-auto d-none d-md-flex align-items-center" style="position: relative;">
                <li class="nav-item dropdown" style="position: relative;">
                    <a class="nav-link p-0" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default_profile_picture.png') }}" 
                        style="width:40px; height:40px;" 
                        alt="profile">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="position: absolute; top: 100%; left: auto; right: 0;" aria-labelledby="profileDropdown">
                        <li><h6 class="dropdown-header">{{ Auth::user()->name }}</h6></li>
                        <li><a class="dropdown-item" href="/profile">Profile</a></li>
                        <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        @else
            <div></div>
            <div class="d-none d-md-block"></div>
        @endauth
    </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-start pe-3">
            <li class="nav-item">
                <a class="nav-link" href="/home">
                    <i class="bi bi-house me-2"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/grant">
                    <i class="bi bi-folder me-2"></i> Grant
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/academician">
                    <i class="bi bi-person me-2"></i>Academician
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/milestone">
                    <i class="bi bi-signpost me-2"></i> Milestone
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
            </li> -->
        </ul>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
