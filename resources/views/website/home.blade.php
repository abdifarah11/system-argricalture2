<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title>Fruitables - Organic Marketplace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Premium organic fruits and vegetables delivered fresh to your doorstep">
    <meta name="keywords" content="organic, fruits, vegetables, healthy food, farm fresh">
    <meta name="theme-color" content="#5C8D4E">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Google Fonts with fallback -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome with auto-awesome-fallback -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        if (typeof FontAwesome === 'undefined') {
            document.write('<link rel="stylesheet" href="{{ asset('css/fontawesome-fallback.css') }}">');
        }
    </script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Library CSS with integrity checks -->
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet" integrity="sha384-">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" integrity="sha384-">
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- Dark/Light mode toggle script -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        }
    </script>
    
    <style>
        :root {
            --primary-color: #214612ff;
            --secondary-color: #F7C35F;
            --accent-color: #E74C3C;
            --light-bg: #F9F9F7;
            --dark-text: #2C3E50;
            --light-text: #ECF0F1;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }
        
        .hero-header {
            /* background: linear-gradient(135deg, rgba(92, 141, 78, 0.9) 0%, rgba(140, 194, 75, 0.8) 100%), 
                        url('img/hero-bg-pattern.png') center/cover no-repeat;
            color: white;
            position: relative;
            overflow: hidden; */
        }
        
        .hero-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('img/organic-pattern.png') repeat;
            opacity: 0.1;
            pointer-events: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all var(--transition-speed) ease;
        }
        
        .btn-primary:hover {
            background-color: #4A7A3D;
            border-color: #4A7A3D;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(92, 141, 78, 0.3);
        }
        
        .fruite-item, .vesitable-item {
            transition: all 0.3s ease;
            border-radius: 12px !important;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: none !important;
        }
        
        .fruite-item:hover, .vesitable-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            border-radius: 50px;
            padding: 8px 20px;
        }
        
        .nav-pills .nav-link {
            color: var(--dark-text);
            transition: all var(--transition-speed) ease;
            margin: 0 5px;
        }
        
        .nav-pills .nav-link:hover:not(.active) {
            background-color: rgba(92, 141, 78, 0.1);
        }
        
        #crop-search {
            border-radius: 50px !important;
            padding: 15px 25px;
            border: 2px solid rgba(92, 141, 78, 0.3);
            transition: all var(--transition-speed) ease;
        }
        
        #crop-search:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(92, 141, 78, 0.25);
        }
        
        #search-btn {
            border-radius: 50px;
            padding: 15px 30px;
            right: 0;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        .counter {
            transition: all var(--transition-speed) ease;
            border-left: 4px solid var(--primary-color);
        }
        
        .counter:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .carousel-control-prev, .carousel-control-next {
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
            transition: all var(--transition-speed) ease;
        }
        
        .carousel-control-prev:hover, .carousel-control-next:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }
        
        .theme-toggle {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .theme-toggle:hover {
            transform: scale(1.1) rotate(30deg);
        }
        
        /* Dark mode styles */
        [data-bs-theme="dark"] {
            --light-bg: #1A1A1A;
            --dark-text: #ECF0F1;
        }
        
        [data-bs-theme="dark"] .fruite-item, 
        [data-bs-theme="dark"] .vesitable-item,
        [data-bs-theme="dark"] .counter {
            background-color: #2D2D2D;
            color: #ECF0F1;
        }
        
        [data-bs-theme="dark"] .bg-light {
            background-color: #2D2D2D !important;
        }
        
        /* Animation classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-header .display-3 {
                font-size: 2.5rem;
            }
            
            #search-btn {
                position: relative !important;
                margin-top: 15px;
                width: 100%;
            }
            
            #crop-search {
                width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <!-- Spinner with better animation -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed top-0 start-0 d-flex align-items-center justify-content-center" style="z-index: 9999;">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <img src="img/logo-icon.png" alt="Loading" class="position-absolute" style="width: 50px; height: 50px;">
    </div>

    <!-- Navbar -->
    @include('website.ecommerce.nav-bar')

    <!-- Flash Messages with better animations -->
    <div class="container mt-3 flash-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Modal Search with enhanced UI -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fs-4">Discover Fresh Produce</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="input-group mb-3">
                        <input type="search" class="form-control p-3 rounded-start-4" placeholder="Search for fruits, vegetables, or farms...">
                        <button class="btn btn-primary px-4 rounded-end-4" type="button">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </div>
                    <div class="search-suggestions">
                        <h6 class="text-muted mb-2">Popular Searches:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="badge bg-light text-dark rounded-pill px-3 py-2">Organic Apples</a>
                            <a href="#" class="badge bg-light text-dark rounded-pill px-3 py-2">Fresh Kale</a>
                            <a href="#" class="badge bg-light text-dark rounded-pill px-3 py-2">Local Berries</a>
                            <a href="#" class="badge bg-light text-dark rounded-pill px-3 py-2">Avocados</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section with Parallax Effect -->
    <section class="container-fluid hero-header position-relative overflow-hidden">
        <div class="container h-100">
            <div class="row g-5 align-items-center h-100">
                <div class="col-lg-6">
                    {{-- <h4 class="mb-3 text-white-50">100% Organic & Locally Sourced</h4> --}}
                    <h1 class="mb-4 display-3 fw-bold text-black ">     Welcome to Pure Vegetables & Fresh Fruits
</h1>
                    <p class="mb-5 lead text-white-75">Discover the freshest organic produce from local farmers near you. Healthy eating made simple.</p>
                    
                    <div class="position-relative w-100 mb-4">
                        <input id="crop-search" class="form-control border-0 w-75 py-3 px-4 rounded-pill shadow-sm" 
                            type="text" placeholder="What are you craving today?">
                        <button id="search-btn" class="btn btn-primary py-3 px-4 position-absolute rounded-pill text-white h-100 shadow"
                                style="top: 0; right: 25%;">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                    </div>
                    
                   
        
        {{-- <div class="wave-shape">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div> --}}
    </section>

    <!-- Features Section with Icons -->

    <!-- Shop Section with Enhanced UI -->
    <section class="container-fluid fruite py-5 bg-light position-relative">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Fresh From The Farm</h2>
                    <p class="lead text-muted">Browse our selection of seasonal produce</p>
                    <div class="d-flex justify-content-center">
                        <div class="border-bottom border-primary border-3" style="width: 80px;"></div>
                    </div>
                </div>
            </div>
            
            <div class="tab-class">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <ul class="nav nav-pills d-flex flex-nowrap overflow-auto pb-3" id="category-tabs" style="scrollbar-width: none;">
                            <!-- Tabs will be added here dynamically -->
                        </ul>
                    </div>
                </div>
                
                <div class="tab-content position-relative" id="crop-list">
                    <!-- Loading skeleton -->
                    <div class="row g-4 crop-loading">
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="rounded fruite-item bg-white p-3 placeholder-glow">
                                <div class="fruite-img mb-3 placeholder" style="height: 200px;"></div>
                                <h5 class="placeholder col-8"></h5>
                                <p class="placeholder col-6"></p>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark fs-5 fw-bold mb-0 placeholder col-4"></p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary placeholder col-6"></a>
                                </div>
                            </div>
                        </div>
                        <!-- Repeat 7 more times -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="line-height: 0;">
            <svg class="w-100" style="height: 50px;" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="currentColor"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="currentColor"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="currentColor"></path>
            </svg>
        </div>
    </section>

        @include('website.ecommerce.Featurs-section')


    <!-- Vegetables Carousel with Cards -->
        <!-- Vegetables Carousel with Cards -->
    <section class="container-fluid vesitable py-5">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Seasonal Specials</h2>
                    <p class="lead text-muted">Fresh picks for this season</p>
                </div>
            </div>
            
            <div class="owl-carousel vegetable-carousel">
                @foreach ($categories as $vegetable)
                    <div class="vesitable-item rounded-4 overflow-hidden shadow-sm border-0">
                        <div class="vesitable-img position-relative">
                            <img src="{{ asset('storage/' . $vegetable->image) }}" class="img-fluid w-100" alt="{{ $vegetable->name }}" style="height: 220px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 p-3">
                                <button class="btn btn-sm btn-light rounded-circle shadow-sm">
                                    <i class="far fa-heart text-danger"></i>
                                </button>
                            </div>
                            <div class="bg-primary text-white px-3 py-1 rounded-pill position-absolute" style="top:10px; left:10px;">
                                {{ $vegetable->name }}
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">{{ $vegetable->name }}</h5>
                                <div class="d-flex align-items-center">
                                    <small class="text-warning me-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </small>
                                    <small>(24)</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">{{ Str::limit($vegetable->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="text-primary mb-0">$3.99/lb</h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="fw-bold">1</span>
                                    <button class="btn btn-sm btn-outline-primary rounded-circle">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Stats Section with Animation -->
    <section class="container-fluid py-5 bg-primary position-relative overflow-hidden">
        <div class="container py-5">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <div class="counter bg-white rounded p-4 text-center h-100">
                        <div class="counter-icon mb-3">
                            <i class="fas fa-users fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-2">Happy Customers</h4>
                        <h1 class="display-5 fw-bold mb-0" data-count="1963">0</h1>
                        <p class="text-muted mb-0">and counting</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="counter bg-white rounded p-4 text-center h-100">
                        <div class="counter-icon mb-3">
                            <i class="fas fa-truck fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-2">Deliveries</h4>
                        <h1 class="display-5 fw-bold mb-0" data-count="5241">0</h1>
                        <p class="text-muted mb-0">this month</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="counter bg-white rounded p-4 text-center h-100">
                        <div class="counter-icon mb-3">
                            <i class="fas fa-leaf fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-2">Organic Farms</h4>
                        <h1 class="display-5 fw-bold mb-0" data-count="127">0</h1>
                        <p class="text-muted mb-0">partnered with us</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="counter bg-white rounded p-4 text-center h-100">
                        <div class="counter-icon mb-3">
                            <i class="fas fa-seedling fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-2">Products</h4>
                        <h1 class="display-5 fw-bold mb-0" data-count="789">0</h1>
                        <p class="text-muted mb-0">available now</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
            <div class="pattern-dots-md" style="color: white;">
                <svg width="100%" height="100%">
                    <pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="20" cy="20" r="1" fill="currentColor"></circle>
                    </pattern>
                    <rect x="0" y="0" width="100%" height="100%" fill="url(#pattern)"></rect>
                </svg>
            </div>
        </div>
    </section>



    <!-- Footer -->
    @include('website.ecommerce.footer')

    <!-- Theme Toggle Button -->
    <div class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon"></i>
    </div>

    <!-- Back to Top Button -->
    <a href="#" class="btn btn-primary btn-lg rounded-circle shadow back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- <script>
       
    </script>

    @stack('scripts') --}}
   <script>
        // Wait for everything to load
        $(window).on('load', function() {
            // Hide spinner with fade out effect
            $('#spinner').fadeOut(500, function() {
                $(this).remove();
            });
            
            // Initialize animations
            new WOW().init();
            
            // Count up animation for stats
            $('[data-count]').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).data('count')
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        });




        //#



        //

        // Dark/Light mode toggle
        $('#themeToggle').click(function() {
            const currentTheme = $('html').attr('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            $('html').attr('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update icon
            $(this).html(newTheme === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>');
            
            // Add animation
            $(this).addClass('pulse');
            setTimeout(() => $(this).removeClass('pulse'), 1000);
        });

        // Back to top button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('#backToTop').fadeIn();
            } else {
                $('#backToTop').fadeOut();
            }
        });
        
        $('#backToTop').click(function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, '300');
        });

        // Auto-dismiss alerts
        setTimeout(() => {
            $('.alert').fadeOut(500, function() {
                $(this).remove();
            });
        }, 4000);

        // Initialize vegetable carousel
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
        // Main AJAX functionality
        $(document).ready(function () {
            const imageBase = "http://127.0.0.1:8000/storage/";

            // Setup CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Load categories (crop types) + add "All" tab first
            $.ajax({
                url: "http://127.0.0.1:8000/api/ecommerce/categories",
                method: "GET",
                beforeSend: function() {
                    $('.crop-loading').show();
                },
                success: function (response) {
                    $('.crop-loading').hide();
                    
                    if (response.success && Array.isArray(response.regions)) {
                        const categories = response.regions;

                        // Add "All" tab manually
                        $('#category-tabs').append(`
                            <li class="nav-item">
                                <button class="nav-link active" data-id="all" type="button">
                                    <i class="fas fa-seedling me-2"></i>All
                                </button>
                            </li>
                        `);

                        categories.forEach(cat => {
                            
                            
                            $('#category-tabs').append(`
                                <li class="nav-item">
                                    <button class="nav-link" data-id="${cat.id}" type="button">
                                        <i class="fas fa-${cat.icon || 'leaf'} me-2"></i>${cat.name}
                                    </button>
                                </li>
                            `);
                        });

                        // Load all crops by default
                        loadCrops('all');
                    } else {
                        $('#crop-list').html('<div class="col-12 text-center py-5"><i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i><h4>Failed to load categories</h4><p class="text-muted">Please try refreshing the page</p></div>');
                    }

                    
                },
                error: function () {
                    $('.crop-loading').hide();
                    $('#crop-list').html('<div class="col-12 text-center py-5"><i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i><h4>Network Error</h4><p class="text-muted">Unable to connect to server</p></div>');
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
                
                $('#crop-list').html('<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-3">Loading fresh produce...</p></div>');

                // Build URL: if "all", no crop_type query param
                const apiUrl = (cropTypeId && cropTypeId !== 'all') ?
                    `http://127.0.0.1:8000/api/ecommerce/categories?region_id=${cropTypeId}` :
                    `http://127.0.0.1:8000/api/ecommerce/categories?region_id=${cropTypeId}`;

                $.ajax({
                    url: apiUrl,
                    method: "GET",
                    success: function (response) {
                        $('#crop-list').empty();

                        if (response.success && Array.isArray(response.categories)) {
                            let cropsHtml = '<div class="row g-4">';
                            let foundCrops = false;

                            response.categories.forEach(category => {
                                // Skip empty categories
                                

                                if (category.crops.length > 0) {
                                    category.crops.forEach(crop => {
                                        foundCrops = true;

                                        let imageUrl = crop.image ? imageBase + crop.image : 'https://via.placeholder.com/300x200?text=No+Image';
                                        let priceInfo = crop.prices.length > 0 ?
                                            `$${crop.prices[0].price}/per ${crop.prices[0].unit}` :
                                            'Price not available';

                                        cropsHtml += `
                                            <div class="col-md-6 col-lg-4 col-xl-3 fade-in">
                                                <div class="rounded position-relative fruite-item bg-white p-3 h-100" data-id="${crop.id}">
                                                    <div class="fruite-img mb-3 overflow-hidden rounded-top" style="height: 200px;">
                                                        <img src="${imageUrl}" alt="${crop.name}" class="img-fluid w-100 h-100 object-fit-cover">
                                                        <div class="bg-primary text-white px-3 py-1 rounded-pill position-absolute" style="top:10px; left:10px;">
                                                            ${category.name}
                                                        </div>
                                                        <div class="position-absolute top-0 end-0 p-3">
                                                            <button class="btn btn-sm btn-light rounded-circle shadow-sm wishlist-btn" data-id="${crop.id}">
                                                                <i class="far fa-heart"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <h5 class="mb-2">${crop.name}</h5>
                                                    <p class="text-muted small mb-3">${crop.description?.substring(0, 80) || 'Fresh organic produce'}</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap align-items-center mt-auto">
                                                        <p class="text-dark fs-5 fw-bold mb-0">${priceInfo}</p>
                                                        <button class="btn border border-secondary rounded-pill px-3 text-primary add_cart">
                                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    });
                                }
                            });

                            cropsHtml += '</div>';
                            $('#crop-list').html(foundCrops ? cropsHtml : `
                                <div class="col-12 text-center py-5">
                                    <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                                    <h4>No crops available</h4>
                                    <p class="text-muted">Check back later for fresh arrivals</p>
                                </div>
                            `);

                        } else {
                            $('#crop-list').html(`
                                <div class="col-12 text-center py-5">
                                    <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                                    <h4>No categories found</h4>
                                </div>
                            `);
                        }
                    },
                    error: function () {
                        $('#crop-list').html(`
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                <h4>Error loading crops</h4>
                                <p class="text-muted">Please try again later</p>
                            </div>
                        `);
                    }
                });
            }

            // Handle Search Button Click
            $('#search-btn').on('click', function () {
                const keyword = $('#crop-search').val().trim();

                if (keyword === '') {
                    $('#crop-list').html('<div class="col-12"><div class="alert alert-warning">Please enter a search keyword.</div></div>');
                    return;
                }

                // Show loading state
                $('#crop-list').html('<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-3">Searching our fresh produce...</p></div>');

                $.ajax({
                    url: 'http://127.0.0.1:8000/api/search-crops',
                    type: 'GET',
                    data: { q: keyword },
                    success: function (response) {
                        if (response.success && response.data.length > 0) {
                            let cropsHtml = '<div class="row g-4">';

                            response.data.forEach(crop => {
                                let imageUrl = crop.image ? imageBase + crop.image : 'https://via.placeholder.com/300x200?text=No+Image';
                                let priceInfo = crop.prices.length > 0 ?
                                    `$${crop.prices[0].price}/per ${crop.prices[0].unit}` :
                                    'Price not available';

                                cropsHtml += `
                                    <div class="col-md-6 col-lg-4 col-xl-3 fade-in">
                                        <div class="rounded position-relative fruite-item bg-white p-3 h-100" data-id="${crop.id}">
                                            <div class="fruite-img mb-3 overflow-hidden rounded-top" style="height: 200px;">
                                                <img src="${imageUrl}" alt="${crop.name}" class="img-fluid w-100 h-100 object-fit-cover">
                                            </div>
                                            <h5 class="mb-2">${crop.name}</h5>
                                            <p class="text-muted small mb-3">${crop.description?.substring(0, 80) || 'Fresh organic produce'}</p>
                                            <div class="d-flex justify-content-between flex-lg-wrap align-items-center mt-auto">
                                                <p class="text-dark fs-5 fw-bold mb-0">${priceInfo}</p>
                                                <button class="btn border border-secondary rounded-pill px-3 text-primary add_cart">
                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            cropsHtml += '</div>';
                            $('#crop-list').html(cropsHtml);
                        } else {
                            $('#crop-list').html(`
                                <div class="col-12 text-center py-5">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h4>No results found</h4>
                                    <p class="text-muted">Try different keywords</p>
                                </div>
                            `);
                        }
                    },
                    error: function () {
                        $('#crop-list').html(`
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                <h4>Search failed</h4>
                                <p class="text-muted">Please check your connection</p>
                            </div>
                        `);
                    }
                });
            });

            // Enter key triggers the search
            $('#crop-search').on('keypress', function (e) {
                if (e.which === 13) {
                    $('#search-btn').click();
                }
            });

            // Handle add to cart click with CSRF
            $(document).on('click', '.add_cart', function (e) {
                e.preventDefault();
                const $btn = $(this);
                const cropId = $btn.closest('.fruite-item').data('id');

                // Add loading state
                $btn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Adding...');
                $btn.prop('disabled', true);

                $.ajax({
                    url: '/add-to-cart',
                    type: 'POST',
                    data: { id: cropId },
                    success: function (response) {
                        // Show success notification
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                        
                        Toast.fire({
                            icon: 'success',
                            title: 'Added to cart successfully'
                        });
                        
                        // Update cart count in navbar
                        if (response.cart_count) {
                            $('.cart-count').text(response.cart_count);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to add to cart',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                    complete: function() {
                        // Reset button state
                        $btn.html('<i class="fa fa-shopping-bag me-2 text-primary"></i> Add');
                        $btn.prop('disabled', false);
                    }
                });
            });

            // Handle wishlist button click
            $(document).on('click', '.wishlist-btn', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const cropId = $btn.data('id');
                
                // Toggle heart icon
                if ($btn.find('i').hasClass('far')) {
                    $btn.html('<i class="fas fa-heart text-danger"></i>');
                    
                    // Show notification
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                    
                    Toast.fire({
                        icon: 'success',
                        title: 'Added to wishlist'
                    });
                    
                    // In a real app, you would make an AJAX call here to save to wishlist
                } else {
                    $btn.html('<i class="far fa-heart"></i>');
                }
            });
        });
    </script>
    
    @stack('scripts')


</body>
</html>
