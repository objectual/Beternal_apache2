@php
use Illuminate\Support\Facades\Route;
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <div class="d-flex">
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{ asset('/public/assets/images/logo-white.png')}}" alt="AdminLTE Logo" class="main-admin-logo  img-circle elevation-3" style="opacity: .8">
    </a>
    <button class="menu-close"><img src="{{ asset('/public/assets/images/cross.png') }}" /></button>
  </div>



  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset(Auth::user()->profile_image) }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="{{ route('user.profile') }}" class="d-block">{{ ucfirst(Auth::user()->name) }} {{ ucfirst(Auth::user()->last_name) }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <a href="{{ route('admin.dashboard') }}" class="nav-link @if(Route::currentRouteName() == 'admin.dashboard') active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="{{ route('admin.users') }}" class="nav-link @if(Route::currentRouteName() == 'admin.users') active @endif">
            <i class="nav-icon fas fa-user-alt"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.users') }}" class="nav-link @if(Route::currentRouteName() == 'admin.users') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>All Users</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item menu-open">
          <a href="{{ route('admin.roles') }}" class="nav-link @if(Route::currentRouteName() == 'admin.roles') active @endif">
            <i class="nav-icon fas fa-user-alt"></i>
            <p>
              Roles
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.roles') }}" class="nav-link @if(Route::currentRouteName() == 'admin.roles') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>All Roles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.roles.add-form') }}" class="nav-link @if(Route::currentRouteName() == 'admin.roles.add-form') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Role</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- <li class="nav-item menu-open">
          <a href="{{ route('admin.countries') }}" class="nav-link @if(Route::currentRouteName() == 'admin.countries') active @endif">
            <i class="nav-icon fas fa-user-alt"></i>
            <p>
              Countries
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.countries') }}" class="nav-link @if(Route::currentRouteName() == 'admin.countries') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>All Countries</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.countries.add-form') }}" class="nav-link @if(Route::currentRouteName() == 'admin.countries.add-form') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Country</p>
              </a>
            </li>
          </ul>
        </li> -->
        <!-- <li class="nav-item menu-open">
          <a href="{{ route('admin.provinces') }}" class="nav-link @if(Route::currentRouteName() == 'admin.provinces') active @endif">
            <i class="nav-icon fas fa-user-alt"></i>
            <p>
              State / Provinces
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.provinces') }}" class="nav-link @if(Route::currentRouteName() == 'admin.provinces') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>All Provinces</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.provinces.add-form') }}" class="nav-link @if(Route::currentRouteName() == 'admin.provinces.add-form') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Province</p>
              </a>
            </li>
          </ul>
        </li> -->
        <!-- <li class="nav-item menu-open">
          <a href="{{ route('admin.cities') }}" class="nav-link @if(Route::currentRouteName() == 'admin.cities') active @endif">
            <i class="nav-icon fas fa-user-alt"></i>
            <p>
              Cities
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.cities') }}" class="nav-link @if(Route::currentRouteName() == 'admin.cities') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>All Cities</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.cities.add-form') }}" class="nav-link @if(Route::currentRouteName() == 'admin.cities.add-form') active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Create City</p>
              </a>
            </li>
          </ul>
        </li> -->
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>