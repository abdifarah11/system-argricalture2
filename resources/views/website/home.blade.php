<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fruitables - Vegetable Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Library CSS -->
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap & Template Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Spinner -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed top-50 start-50 translate-middle d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <!-- Navbar -->
    @include('website.ecommerce.nav-bar')

    <!-- Flash Messages -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Auto-dismiss alerts -->
    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => alert.remove());
        }, 4000);
    </script>

    <!-- Modal Search -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto">
                        <input type="search" class="form-control p-3" placeholder="Enter keywords...">
                        <span class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    @include('website.ecommerce.hero')

    <!-- Features -->
    @include('website.ecommerce.Featurs-section')

    <!-- Shop -->
    @include('website.ecommerce.Shop')

    <!-- Vegetables Carousel -->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-4">Fresh Organic Vegetables</h1>
            <div class="owl-carousel vegetable-carousel">
                @foreach ($categories as $vegetable)
                    <div class="border border-primary rounded vesitable-item">
                        <div class="vesitable-img">
                            <img src="{{ asset('storage/' . $vegetable->image) }}" class="img-fluid w-100 rounded-top" alt="{{ $vegetable->name }}">
                        </div>
                        <div class="bg-primary text-white px-3 py-1 rounded position-absolute" style="top:10px; right:10px;">
                            {{ $vegetable->name }}
                        </div>
                        <div class="p-4">
                            <h4>{{ $vegetable->name }}</h4>
                            <p>{{ $vegetable->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="bg-light p-5 rounded">
                <div class="row g-4 text-center">
                    <div class="col-md-6 col-lg-3">
                        <div class="counter bg-white rounded p-4">
                            <i class="fa fa-users text-secondary fs-3"></i>
                            <h4>Satisfied Customers</h4>
                            <h1>1963</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="counter bg-white rounded p-4">
                            <i class="fa fa-star text-secondary fs-3"></i>
                            <h4>Quality of Service</h4>
                            <h1>99%</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="counter bg-white rounded p-4">
                            <i class="fa fa-certificate text-secondary fs-3"></i>
                            <h4>Certificates</h4>
                            <h1>33</h1>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="counter bg-white rounded p-4">
                            <i class="fa fa-leaf text-secondary fs-3"></i>
                            <h4>Available Products</h4>
                            <h1>789</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('website.ecommerce.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".vegetable-carousel").owlCarousel({
                autoplay: true,
                loop: true,
                margin: 20,
                nav: false,
                dots: true,
                responsive: {
                    0: { items: 1 },
                    600: { items: 2 },
                    1000: { items: 3 }
                }
            });
        });
    </script>

    @stack('scripts')

</body>
</html>
