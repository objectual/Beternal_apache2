

<div class="row toggle-btn-mobile">
  <div class="col-12">
    <nav class="navbar nav-header navbar-expand-lg navbar-light bg-black">
      <div class="container">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item px-2 pl-0">
              <a class="nav-link menu-active pl-0" aria-current="page" href="{{ route('index') }}"
                >
                <!-- <span class="icon-home header-icons"></span> -->
                <span class="header-span">Home</span></a
              >
            </li>
            <li class="nav-item px-2">
              <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}"
                >
                <!-- <span class="icon-menu header-icons"></span> -->
                <span class="header-span">Dashboard</span></a
              >
            </li>
            <li class="nav-item px-2">
              <a class="nav-link active" aria-current="page" href="{{ route('user.media') }}"
                >
                <!-- <span class="icon-add-data header-icons"></span> -->
                <span class="header-span">Add Media</span></a>
            </li>
            <li class="nav-item px-2">
              <a class="nav-link active" aria-current="page" href="{{ route('user.profile') }}"
                >
                <!-- <span class="icon-user header-icons"></span> -->
                <span class="header-span">User Profile</span></a
              >
            </li>
            <li class="nav-item px-2">
              <a class="nav-link active" aria-current="page" href="{{ route('user.legacy') }}"
                >
                <!-- <span class="icon-legacy header-icons"></span> -->
                <span class="header-span">Legacy</span></a
              >
            </li>
            <li class="nav-item px-2">
              <a class="nav-link active" aria-current="page" href="{{ route('user.delivery') }}"
                >
                <!-- <span class="icon-event header-icons"></span> -->
                <span class="header-span">Scheduled Media</span></a
              >
            </li>
            <li class="nav-item px-2 pr-0">
              <a class="nav-link active pr-0" aria-current="page" href="{{ route('user.recipents') }}"
                >
                <!-- <span class="icon-Recipents header-icons"></span> -->
                <span class="header-span">Recipents</span></a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</div>
