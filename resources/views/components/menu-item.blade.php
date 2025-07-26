<div class="d-flex m-3 me-0">
    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4"
        data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
    <a href="{{ route('cart.view') }}" class="position-relative me-4 my-auto">
        <i class="fa fa-shopping-bag fa-2x"></i>
        <span
            class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
            style="top: -5px; left: 15px; height: 20px; min-width: 20px;">


            {{ count(session('cart', [])) }}

        </span>
    </a>
    <div class="dropdown my-auto">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ Auth::user()->avatar ?? asset('https://placehold.co/100x100') }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
            <span>{{ Auth::user()->fullname ?? 'Guest' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href=""><i class="fas fa-user me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href=""><i class="fas fa-box me-2"></i>My Orders</a></li>
            <li><a class="dropdown-item" href=""><i class="fas fa-cog me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                </form>
            </li>
        </ul>
    </div>
</div>