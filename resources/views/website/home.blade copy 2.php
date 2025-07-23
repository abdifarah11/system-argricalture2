<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agricultural E-Commerce Home</title>

  <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
   
     <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />

    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
   <link
      rel="stylesheet"
      href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css"

    />



</head>
<body>
    <div class="container py-4">

        <header class="mb-4">
            <h1 class="text-center">🌾 Agricultural Market</h1>
        </header>

        {{-- Region Filter Form --}}
        <form method="GET" action="{{ url()->current() }}" class="mb-4 d-flex justify-content-center">
            <select name="region_id" onchange="this.form.submit()" class="form-select w-auto">
                <option value="">🌍 All Regions</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Categories and Crops --}}
        @foreach ($categories as $category)
            <section class="mb-5">
                <h2 class="mb-2">{{ $category['name'] }}</h2>
                <p>{{ $category['description'] }}</p>

                @if(count($category['crops']) > 0)
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach ($category['crops'] as $crop)
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    @if($crop['image'])
                                        <img src="{{ asset('storage/' . $crop['image']) }}" class="card-img-top" alt="{{ $crop['name'] }}" style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 180px;">
                                            No Image
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $crop['name'] }}</h5>
                                        <p class="card-text flex-grow-1">{{ $crop['description'] ?? 'No description available.' }}</p>

                                        @if(count($crop['prices']) > 0)
                                            @php $price = $crop['prices'][0]; @endphp
                                            <p class="mb-1"><strong>Price:</strong> ${{ $price['price'] }} per {{ $price['unit'] }}</p>
                                        @else
                                            <p class="text-muted mb-1">No price available for selected region.</p>
                                        @endif

                                        <a href="#" class="btn btn-primary mt-auto">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No crops available in this category.</p>
                @endif
            </section>
        @endforeach

        <footer class="mt-5 text-center text-muted">
            &copy; {{ date('Y') }} Agricultural Market. All rights reserved.
        </footer>
    </div>

   <!--begin::Third Party Plugin(OverlayScrollbars)-->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
  crossorigin="anonymous"></script>
<!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  crossorigin="anonymous"></script>
<!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
<script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>
