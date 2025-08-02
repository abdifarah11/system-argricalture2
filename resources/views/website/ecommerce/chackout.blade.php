         <!DOCTYPE html>
         <html lang="en">

         <head>
             <meta charset="utf-8">
             <title>Fruitables - Vegetable Website Template</title>
             <meta content="width=device-width, initial-scale=1.0" name="viewport">
             <meta content="" name="keywords">
             <meta content="" name="description">

             <!-- Google Web Fonts -->
             <link rel="preconnect" href="https://fonts.googleapis.com">
             <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
             <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

             <!-- Icon Font Stylesheet -->
             <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
             <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

             <!-- Libraries Stylesheet -->
             <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
             <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
             <!-- Customized Bootstrap Stylesheet -->
             {{-- <link href="css/bootstrap.min.css" rel="stylesheet"> --}}
             <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />

             <!-- Template Stylesheet -->
             {{-- <link href="css/style.css" rel="stylesheet"> --}}

             <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

         </head>

         <body>

             <!-- Spinner Start -->
             <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
                 <div class="spinner-grow text-primary" role="status"></div>
             </div>
             <!-- Spinner End -->


             <!-- Navbar start -->
             {{-- @include('website.ecommerce.nav-bar') --}}
             @include('website.ecommerce.nav-bar', ['menu' => '<div class="d-flex m-3 me-0">
                 <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                 <a href="#" class="position-relative me-4 my-auto">
                     <i class="fa fa-shopping-bag fa-2x"></i>
                     <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                 </a>
                 <a href="#" class="my-auto">
                     <i class="fas fa-user fa-2x"></i>
                 </a> '])

                 <div class="container-fluid py-5">
                     <div class="container py-5">
                      
                         <h1 class="mb-4">Billing details</h1>
                         <form action="{{ route('order.place') }}" method="POST">
                             @csrf
                             <div class="row g-5">
                                 <div class="col-md-12 col-lg-6 col-xl-7">
                                     <div class="row"></div>

                                    <input type="hidden" name="cart" value='@json(session('cart'))'>

                                    <div class="form-item">
                                        <label class="form-label my-3">Full Name<sup>*</sup></label>
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}">
                                        @error('full_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-item">
                                        <label class="form-label my-3">Region<sup>*</sup></label>
                                        <select class="form-select @error('region_id') is-invalid @enderror" name="region_id">
                                            <option value="" selected disabled>Select Region</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('region_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-item">
                                        <label class="form-label my-3">Address <sup>*</sup></label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="House Number Street Name" value="{{ old('address') }}">
                                        @error('address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-item">
                                        <label class="form-label my-3">Mobile<sup>*</sup></label>
                                        <input type="tel" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-item">
                                        <label class="form-label my-3">Email Address<sup>*</sup></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-check my-3">
                                        <input type="checkbox" class="form-check-input @error('create_account') is-invalid @enderror" id="Account-1" name="create_account" value="1" {{ old('create_account') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Account-1">Create an account?</label>
                                        @error('create_account')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                    <hr>

                                    <div class="form-item">
                                        <textarea name="order_notes" class="form-control @error('order_notes') is-invalid @enderror" cols="30" rows="11" placeholder="Order Notes (Optional)">{{ old('order_notes') }}</textarea>
                                        @error('order_notes')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>         </div>

                                 <div class="col-md-12 col-lg-6 col-xl-5">
                                     <div class="table-responsive">
                                         <table class="table">
                                             <thead>
                                                 <tr>
                                                     <th scope="col">Products</th>
                                                     <th scope="col">Name</th>
                                                     <th scope="col">Price</th>
                                                     <th scope="col">Quantity</th>
                                                     <th scope="col">Total</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 @if(is_array(session('cart')) && count(session('cart')) > 0)
                                                 @foreach(session('cart') as $id => $details)
                                                 <tr>
                                                     <th scope="row">
                                                         <div class="d-flex align-items-center mt-2">
                                                             <img src="{{ asset('storage/' . $details['image']) }}" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                                         </div>
                                                     </th>
                                                     <td class="py-5">{{ $details['name'] }}</td>
                                                     <td class="py-5">${{ $details['price'] }}</td>
                                                     <td class="py-5">{{ $details['quantity'] }}</td>
                                                     <td class="py-5">${{ $details['price'] * $details['quantity'] }}</td>
                                                 </tr>
                                                 @endforeach
                                                 @else
                                                 <tr>
                                                     <td colspan="5" class="text-center">Your cart is empty.</td>
                                                 </tr>
                                                 @endif
                                             </tbody>
                                         </table>
                                     </div>
                                   
<div class="form-check d-flex align-items-center gap-3 my-3">
    <input type="radio" class="form-check-input bg-primary border-0"
        id="payment-waafi" name="payment_method" value="waafi" required  
        style="width: 30px; height: 30px;">
        
    <label class="form-check-label fs-5 fw-semibold mb-0" for="payment-waafi" style="margin-left: 10px;">
        Waafi
    </label>
</div>



            <!-- Waafi -->
       

                {{-- <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                    <div class="col-12">
                        <div class="form-check text-start my-3">
                            <input type="radio" class="form-check-input bg-primary border-0"
                                id="payment-edahab" name="payment_method" value="edahab">
                            <label class="form-check-label" for="payment-edahab">E-Dahab</label>
                        </div>
                    </div>
                </div>

                <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                    <div class="col-12">
                        <div class="form-check text-start my-3">
                            <input type="radio" class="form-check-input bg-primary border-0"
                                id="payment-zaad" name="payment_method" value="zaad">
                            <label class="form-check-label" for="payment-zaad">Zaad</label>
                        </div>
                    </div>
                </div> --}}





                                     <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                         <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place Order</button>
                                     </div>
                                 </div>
                             </div>
                         </form>

                     </div>
                 </div>
                 
                              
                            <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
    <div class="container py-5">
        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
           
        </div>
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    {{-- <h4 class="text-light mb-3">Why People Like us!</h4>
                    <p class="mb-4">typesetting, remaining essentially unchanged. It was
                        popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                    <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a> --}}
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Shop Info</h4>
                    <a class="btn-link" href="">About Us</a>
                    <a class="btn-link" href="">Contact Us</a>
                    <a class="btn-link" href="">Privacy Policy</a>
                    <a class="btn-link" href="">Terms & Condition</a>
                    <a class="btn-link" href="">Return Policy</a>
                    <a class="btn-link" href="">FAQs & Help</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Account</h4>
                    <a class="btn-link" href="">My Account</a>
                    <a class="btn-link" href="">Shop details</a>
                    <a class="btn-link" href="">Shopping Cart</a>
                    <a class="btn-link" href="">Wishlist</a>
                    <a class="btn-link" href="">Order History</a>
                    <a class="btn-link" href="">International Orders</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Contact</h4>
                    <p>Address: Mogadishu, Somalia</p>
                    <p>
                        Email:
                        <a href="mailto:abdirahmanfarah1164@gmail.com" style="color: #fff;">
                            abdirahmanfarah1164@gmail.com
                        </a>
                    </p>
                    <p>Phone: +252 61 2345678</p>
                    <p>
                        WhatsApp:
                        <a href="https://wa.me/252612345678" target="_blank" style="color: #25D366;">
                            Chat on WhatsApp
                        </a>
                    </p>
                    <p>Payment Accepted</p>
                    {{-- <img src="img/payment.png" class="img-fluid" alt="Payment Methods"> --}}
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>YAgriculture Market
                        Price Trade
                    </a></span>
            </div>
            <div class="col-md-6 my-auto text-center text-md-end text-white">
                <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                {{-- Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a
                    class="border-bottom" href="https://themewagon.com">ThemeWagon</a> --}}
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->



<!-- Back to Top -->
<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
        class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>

<!-- Template Javascript -->

<script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
                   
                 <!-- Copyright End -->



                 <!-- Back to Top -->
                 <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


                 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                 <!-- JavaScript Libraries -->
                 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
                 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
                 <script src="lib/easing/easing.min.js"></script>
                 <script src="lib/waypoints/waypoints.min.js"></script>
                 <script src="lib/lightbox/js/lightbox.min.js"></script>
                 <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>

                 <!-- Template Javascript -->
                 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                 <script src="{{ asset('js/main.js') }}"></script>


         </body>

         </html>



         