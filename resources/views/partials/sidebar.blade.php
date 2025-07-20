      <!--begin::Sidebar-->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="{{ asset('img/login-bg.jpg') }}"
          
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Argricalture Market</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>



         <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
               <ul class="nav nav-treeview">

    {{-- User Management --}}
    <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link active">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>User Management</p>
        </a>
    </li>

    {{-- Crop Types Management --}}
    <li class="nav-item">
        <a href="{{ route('crop_types.index') }}" class="nav-link active">
            <i class="nav-icon bi bi-tags-fill"></i>
            <p>Crop Types Management</p>
        </a>
    </li>

    {{-- Crops Management --}}
    <li class="nav-item">
        <a href="{{ route('crops.index') }}" class="nav-link active">
            <i class="nav-icon bi bi-flower1"></i>
            <p>Crops Management</p>
        </a>
    </li>

    {{-- Orders Management --}}
    <li class="nav-item">
        <a href="{{ route('orders.index') }}" class="nav-link active">
            <i class="nav-icon bi bi-bag-check-fill"></i>
            <p>Orders Management</p>
        </a>
    </li>

    {{-- Payments Management --}}
    <li class="nav-item">
        <a href="{{ route('payment_methods.index') }}" class="nav-link active">
            <i class="nav-icon bi bi-credit-card-2-front-fill"></i>
            <p>Payments Management</p>
        </a>
    </li>

    {{-- Transaction Management --}}
    <li class="nav-item">
        <a href="{{ route('transactions.index') }}" class="nav-link active">
            <i class="nav-icon bi bi-currency-exchange"></i>
            <p>Transaction Management</p>
        </a>
    </li>

    {{-- Price History Management --}}
    <li class="nav-item">
        <a href="{{ route('PriceHistory.index') }}" class="nav-link active">
            <i class="nav-icon bi bi-graph-up-arrow"></i>
            <p>Price History Management</p>
        </a>
    </li>

    {{-- Reports Management --}}
    {{-- <li class="nav-item">
        <a href="{{ route('reports.index') }}" class="nav-link active">
            <i class="nav-icon bi bi-file-earmark-bar-graph-fill"></i>
            <p>Reports Management</p>
        </a> --}}
    </li>

</ul>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
         

        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->