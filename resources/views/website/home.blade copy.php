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
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

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
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed top-50 start-50 translate-middle d-flex align-items-center justify-content-center">
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

    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">100% Organic Foods</h4>
                    <h1 class="mb-5 display-3 text-primary">Organic Veggies & Fruits Foods</h1>
                    <div class="position-relative mx-auto">
                  <input id="crop-search" class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                type="text" placeholder="Search crops...">
            <button id="search-btn" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                    style="top: 0; right: 25%;">Search Now</button>

                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="img/hero-img-1.png" class="img-fluid w-100 h-100 bg-secondary rounded"
                                    alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Fruites</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Vesitables</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    @include('website.ecommerce.Featurs-section')

    <!-- Shop -->
    {{-- @include('website.ecommerce.Shop') --}}
    <!-- ✅ Include CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Our Organic Products</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5" id="category-tabs">
                            <!-- Tabs will be added here dynamically -->
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="crop-list">
                    <!-- Crop items will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
    <div class="col-md-4 offset-md-15 text-end">
        <select id="region-filter" class="form-select">
            <option value="">All Regions</option>
        </select>
    </div>
</div>



    <!-- Vegetables Carousel -->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-4">Fresh Organic Vegetables</h1>
            <div class="owl-carousel vegetable-carousel">
                @foreach ($categories as $vegetable)
                    <div class="border border-primary rounded vesitable-item">
                        <div class="vesitable-img">
                            <img src="{{ asset('storage/' . $vegetable->image) }}" class="img-fluid w-100 rounded-top"
                                alt="{{ $vegetable->name }}">
                        </div>
                        <div class="bg-primary text-white px-3 py-1 rounded position-absolute"
                            style="top:10px; right:10px;">
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
    <!-- ✅ jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
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


    <script>
        $(document).ready(function () {

            const imageBase = "http://127.0.0.1:8000/storage/";

            // ✅ Setup CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Load categories (crop types)
            $.ajax({
                url: "http://127.0.0.1:8000/api/ecommerce/categories",
                method: "GET",
                success: function (response) {
                    if (response.success && Array.isArray(response.categories)) {
                        const categories = response.categories;
                        console.log(categories)

                        categories.forEach((cat, index) => {
                            $('#category-tabs').append(`
                        <li class="nav-item">
                            <button class="nav-link ${index === 0 ? 'active' : ''}" data-id="${cat.id}" type="button">
                                ${cat.name}
                            </button>
                        </li>
                    `);
                        });

                        if (categories.length > 0) {
                            loadCrops(categories[0].id);
                        }
                    }
                },
                error: function () {
                    $('#crop-list').html('<p class="text-danger">Failed to load categories.</p>');
                }
            });

            // Handle tab click
            $(document).on('click', '.nav-link', function () {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');

                const cropTypeId = $(this).data('id');
                loadCrops(cropTypeId);
            });

            function loadCrops(cropTypeId) {
                $('#crop-list').html('<p>Loading crops...</p>');

                $.ajax({
                    url: `http://127.0.0.1:8000/api/ecommerce/categories?crop_type=${cropTypeId}`,
                    method: "GET",
                    success: function (response) {
                        $('#crop-list').empty();

                        if (response.success && Array.isArray(response.categories)) {
                            const category = response.categories[0];
                            if (category && category.crops.length > 0) {
                                let cropsHtml = '<div class="row g-4">';

                                category.crops.forEach(crop => {
                                    let imageUrl = crop.image ? imageBase + crop.image : 'https://via.placeholder.com/300x200';
                                    let priceInfo = crop.prices.length > 0 ?
                                        `$${crop.prices[0].price}/per ${crop.prices[0].unit}` :
                                        'No price info';

                                    cropsHtml += `
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item bg-light p-3" data-id="${crop.id}">
                                        <div class="fruite-img mb-3">
                                            <img src="${imageUrl}" alt="${crop.name}" class="img-fluid w-100 rounded-top" style="height: 200px; object-fit: cover;">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                            ${category.name}
                                        </div>
                                        <h5>${crop.name}</h5>
                                        <p>${crop.description ?? ''}</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap align-items-center">
                                            <p class="text-dark fs-5 fw-bold mb-0"> ${priceInfo}</p>
                                            <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary add_cart">
                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            `;
                                });

                                cropsHtml += '</div>';
                                $('#crop-list').html(cropsHtml);
                            } else {
                                $('#crop-list').html('<p>No crops found for this category.</p>');
                            }
                        } else {
                            $('#crop-list').html('<p>No categories found.</p>');
                        }
                    },
                    error: function () {
                        $('#crop-list').html('<p class="text-danger">Error loading crops.</p>');
                    }
                });
            }

            // ✅ Handle add to cart click with CSRF
            $(document).on('click', '.add_cart', function (e) {
                e.preventDefault();

                const cropId = $(this).closest('.fruite-item').data('id');

                $.ajax({
                    url: '/add-to-cart',
                    type: 'POST',
                    data: {
                        id: cropId
                    },
                    success: function (response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Crop added to cart",
                            showConfirmButton: false,
                            timer: 3000
                        });
                        window.location.reload(); // Reload to update cart count
                    },
                    error: function (xhr) {
                        alert('Failed to add to cart');
                    }
                });
            });


        });

        @if(session('success'))

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '{{ session('
            success ') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
        // Handle Search Button Click
$('#search-btn').on('click', function () {
    let keyword = $('#crop-search').val().trim();
  
    if (!keyword) return;

    $('#crop-list').html('<p>Searching crops...</p>');

    $.ajax({
        url: `http://127.0.0.1:8000/api/search-crops?q=${encodeURIComponent(keyword)}`,
        method: 'GET',
        success: function (response) {
            if (response.success && response.data.length > 0) {
                let cropsHtml = '<div class="row g-4">';
                    console.log(cropsHtml)

                response.data.forEach(crop => {
                    let imageUrl = crop.image ? imageBase + crop.image : 'https://via.placeholder.com/300x200';
                    let priceInfo = crop.prices && crop.prices.length > 0 ?
                        `$${crop.prices[0].price}/per ${crop.prices[0].unit}` : 'No price info';

                    cropsHtml += `
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="rounded position-relative fruite-item bg-light p-3" data-id="${crop.id}">
                                <div class="fruite-img mb-3">
                                    <img src="${imageUrl}" alt="${crop.name}" class="img-fluid w-100 rounded-top" style="height: 200px; object-fit: cover;">
                                </div>
                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                    ${crop.crop_type?.name ?? ''}
                                </div>
                                <h5>${crop.name}</h5>
                                <p>${crop.description ?? ''}</p>
                                <div class="d-flex justify-content-between flex-lg-wrap align-items-center">
                                    <p class="text-dark fs-5 fw-bold mb-0">${priceInfo}</p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary add_cart">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });

                cropsHtml += '</div>';
                $('#crop-list').html(cropsHtml);
            } else {
                $('#crop-list').html('<p class="text-warning">No crops found for your search.</p>');
            }
        },
        error: function () {
            $('#crop-list').html('<p class="text-danger">Error searching crops.</p>');
        }
    });
});



    </script>