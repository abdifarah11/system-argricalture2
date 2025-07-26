@include('website.ecommerce.nav-bar')

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

<!-- ✅ jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
                                let priceInfo = crop.prices.length > 0
                                    ? `$${crop.prices[0].price}/per ${crop.prices[0].unit}`
                                    : 'No price info';

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
                data: { id: cropId },
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
</script>