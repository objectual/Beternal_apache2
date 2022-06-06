@if (Auth::check())
<nav class="top-nav navbar navbar-expand-sm bg-light">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item margin-auto d-flex">
                <a href="{{ route('splash') }}"><img src="{{ asset('/public/assets/images/logo-white.png') }}" class="img-logo" /></a>
                @yield("page_title")
                <a class="nav-link heading text-white arial-bold nav-heading acc-head mt-2 mx-5" href="">{{ $title }}</a>
                @show
            </li>
        </ul>
        <div class="dropdown">
            <a href="#" class=" d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset(Auth::user()->profile_image) }}" alt="hugenerd" width="30" height="30" class="profile-img rounded-circle" />
                <div class="d-grid drop-pr">
                    <span class="d-sm-inline mx-1 profile-name arial-bold">{{ Auth::user()->name }}</span>
                    <span class="d-sm-inline mx-1 profile-desig dash-admin">
                        @if(Auth::user()->role_id == 1)Admin @else User @endif
                    </span>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li>
                    <a class="dropdown-item" href="{{ route('user.notifications') }}">Notifications</a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.profile') }}">My Account</a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <form method="POST" class="padding-li" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Sign Out') }}
                        </x-responsive-nav-link>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@else
<nav class="top-nav navbar navbar-expand-sm bg-light">
    <div class="container index-btn-adjust">
        <ul class="navbar-nav index-home">
            <li class="nav-item margin-auto d-flex">
                <a href="{{ route('splash') }}"><img src="{{ asset('/public/assets/images/logo-white.png')}}" class="img-logo" /></a>
                @yield("page_title")
                <a class="nav-link heading text-white arial-bold nav-heading acc-head mt-2 mx-5" href="">{{ $title }}</a>
                @show
            </li>
        </ul>
        <div class="d-grid-mobile">
            <a href="{{ route('login') }}" class="login-btn">Login</a>
            <a href="{{ route('register') }}" class="signup-btn">Sign Up</a>
        </div>
    </div>
</nav>
@endif
