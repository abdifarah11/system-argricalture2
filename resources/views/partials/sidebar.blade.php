<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="brand-image opacity-75 shadow" />
      <span class="brand-text fw-light">Agriculture Market</span>
    </a>
  </div>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" role="navigation" id="navigation">
        <li class="nav-item menu-open">
          <a href="{{ route('dashboard') }}" class="nav-link active">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        {{-- Admin Only --}}
        @if(auth()->user()->role === 'admin')
        <li class="nav-item">
          <a href="{{ route('users.index') }}" class="nav-link">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>Users Management</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('payment_methods.index') }}" class="nav-link">
            <i class="nav-icon bi bi-credit-card-2-front-fill"></i>
            <p>Payments Management</p>
          </a>
        </li>
        @endif

        {{-- Admin + Market Officer --}}
        @if(in_array(auth()->user()->role, ['admin', 'market_officer']))
        <li class="nav-item">
          <a href="{{ route('orders.index') }}" class="nav-link">
            <i class="nav-icon bi bi-bag-check-fill"></i>
            <p>Orders Management</p>
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
            <p>report Management</p>
          </a>
        </li>

  <li class="nav-item">
          <a href="{{ route('settings.index') }}" class="nav-link">
            <i class="nav-icon bi bi-graph-up-arrow"></i>
            <p>settings Management</p>
          </a>
        </li>


        @endif

        {{-- All roles: admin, market_officer, general --}}
        @if(in_array(auth()->user()->role, ['admin', 'market_officer', 'general']))
        <li class="nav-item">
          <a href="{{ route('crop_types.index') }}" class="nav-link">
            <i class="nav-icon bi bi-tags-fill"></i>
            <p>Crop Types</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('crops.index') }}" class="nav-link">
            <i class="nav-icon bi bi-flower1"></i>
            <p>Crops</p>
          </a>
        </li>
        @endif
      </ul>



      
    </nav>
  </div>
</aside>
