<!--begin::Sidebar-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <a href="./index.html" class="brand-link">
      <img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
      <span class="brand-text fw-light">Agriculture Market</span>
    </a>
  </div>
  <!--end::Sidebar Brand-->

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">

        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>
              Dashboard
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">

            {{-- <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link">
                <i class="nav-icon bi bi-people-fill"></i>
                <p>User Management</p>
              </a>
            </li> --}}

            <li class="nav-item">
              <a href="{{ route('crop_types.index') }}" class="nav-link">
                <i class="nav-icon bi bi-tags-fill"></i>
                <p>Crop Types Management</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('crops.index') }}" class="nav-link">
                <i class="nav-icon bi bi-flower1"></i>
                <p>Crops Management</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('orders.index') }}" class="nav-link">
                <i class="nav-icon bi bi-bag-check-fill"></i>
                <p>Orders Management</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('payment_methods.index') }}" class="nav-link">
                <i class="nav-icon bi bi-credit-card-2-front-fill"></i>
                <p>Payments Management</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('transactions.index') }}" class="nav-link">
                <i class="nav-icon bi bi-currency-exchange"></i>
                <p>Transaction Management</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('PriceHistory.index') }}" class="nav-link">
                <i class="nav-icon bi bi-graph-up-arrow"></i>
                <p>Price History Management</p>
              </a>
            </li>

            {{-- <li class="nav-item">
              <a href="{{ route('reports.index') }}" class="nav-link">
                <i class="nav-icon bi bi-file-earmark-bar-graph-fill"></i>
                <p>Reports Management</p>
              </a>
            </li> --}}

            <li class="nav-item">
              <a href="./index2.html" class="nav-link">
                <i class="nav-icon bi bi-ui-checks"></i>
                <p>Dashboard v2</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="./index3.html" class="nav-link">
                <i class="nav-icon bi bi-ui-checks-grid"></i>
                <p>Dashboard v3</p>
              </a>
            </li>

          </ul>
        </li>

      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
