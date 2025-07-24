<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
          <img src="{{ asset('img/C.RAHMAN-1.jpg') }}" class="user-image rounded-circle shadow" alt="User Image" style="width: 40px; height: 40px; object-fit: cover;" />
          <span class="d-none d-md-inline ms-2 fw-semibold">Eng Abdirahman</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-3" style="min-width: 220px;">
          <li class="user-header bg-primary rounded text-center p-3 mb-3">
            <img src="{{ asset('img/C.RAHMAN-1.jpg') }}" class="rounded-circle shadow mb-2" alt="User Image" style="width: 80px; height: 80px; object-fit: cover;" />
            <p class="mb-0 fw-semibold text-white">Eng Abdirahman project builder</p>
            <small class="text-white-50">in year 2025</small>
          </li>
          <li class="user-body d-flex justify-content-center">
            <a href="#" 
               onclick="event.preventDefault(); document.getElementById('signout-form').submit();" 
               style="
                 font-size: 1.25rem; 
                 font-weight: 600; 
                 color: #d6336c; 
                 text-decoration: underline; 
                 text-underline-offset: 3px;
                 padding: 8px 20px;
                 border-radius: 6px;
                 display: inline-block;
               "
            
            >
              Sign Out
            </a>
            <form id="signout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
