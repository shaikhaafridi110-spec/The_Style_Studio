<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>The_Style_Studio</title>
    <!-- <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes"> -->
    <!-- Favicon -->
    <!-- <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    
    <link rel="manifest" href="assets/images/icons/site.html">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff"> -->
    <!-- Plugins CSS File -->
     <link rel="icon" type="image/png" sizes="64x64" href="{{asset('user/assets/images/logo11.png')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{asset('user/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/plugins/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/plugins/magnific-popup/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/plugins/jquery.countdown.css')}}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('user/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/skins/skin-demo-5.css')}}">
    <link rel="stylesheet" href="{{asset('user/assets/css/demos/demo-5.css')}}">
    <style>
        .main-nav .menu>li>a {
            padding: 0px 20px;
            /* remove extra bottom padding */
            line-height: 2;
            /* reduce height */
            display: inline-block;
            /* important */
        }

        .settings-dropdown .dropdown-menu {
            min-width: 180px;
            padding: 10px 0;
        }

        .settings-dropdown .dropdown-menu a {
            padding: 8px 20px;
            display: block;
            color: #333;
        }

        .settings-dropdown .dropdown-menu a:hover {
            background: #f5f5f5;
        }

        .settings-dropdown {
            position: relative;
            margin-left: 20px;
        }

        .settings-dropdown i {
            font-size: 22px;
        }

        .settings-dropdown>a {
            color: #fff !important;
            display: flex;
            align-items: center;
            font-size: 22px;
        }

        .settings-dropdown>a:hover {
            color: #cc9966 !important;
            /* optional hover color */
        }

        .settings-dropdown .dropdown-toggle::after {
            display: none !important;
        }
    </style>
</head>


<body>
    <div class="page-wrapper">


        <header class="header header-5">
            <div class="header-middle sticky-header">
                <div class="container-fluid">
                    <div class="header-left">

                        <a href="{{url('/')}}" class="logo">
                            <img src="{{asset('user/assets/images/logo03.png')}}" alt="Molla Logo" width="105" height="25">
                        </a>
                       
                        


                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container" style="width: fit-content;">
                                    <a href="{{url('/')}}">Home</a>

                                </li>
                                <li>
                                    <a href="{{url('user/shop')}}">Shop</a>
                                </li>

                                <li>
                                    <a href="{{url('user/about')}}">About</a>
                                </li>
                                <li>
                                    <a href="{{url('user/contact')}}">Contact</a>
                                </li>
                                <li>
                                    <a href="{{url('/login')}}">Login</a>
                                </li>
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <div class="header-search header-search-extended header-search-visible">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search product ..." required>
                                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->

                        <a href="{{url('user/wishlist')}}" class="wishlist-link">
                            <i class="icon-heart-o"></i>
                        </a>
                        <a href="{{url('user/cart')}}" class="wishlist-link">
                            <i class="icon-shopping-cart"></i>
                        </a>

                        <!-- End .cart-dropdown -->
                        <div class="dropdown settings-dropdown">
                            <a href="#" class="dropdown-toggle"
                                data-toggle="dropdown">

                                <i class="icon-cog"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">My Profile</a>
                                <a class="dropdown-item" href="#">Logout</a>
                            </div>
                        </div>
                    </div><!-- End .header-right -->
                </div><!-- End .container-fluid -->
            </div><!-- End .header-middle -->
        </header>

        <!-- Contain-main -->

        @yield('content')

        <!-- end Contain-main -->






        <footer class="footer footer-2">
            <div class="footer-middle border-0">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="widget widget-about">
                                <img src="{{asset('user/assets/images/logo10.png')}}" class="footer-logo" alt="Footer Logo" width="200" height="25">
                                <p style="font-size:16px; line-height:1.8;">
                                    At <strong>Style Studio</strong>, we bring you timeless fashion with a modern touch, crafted to express your unique personality and confidence.
                                </p>
                                <p style="font-size:16px; line-height:1.8;"><strong>--</strong>Fashion that speaks your style only at Style Studio.</p>
                                <div class="widget-about-info">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4">
                                            <span class="widget-about-title">Got Question? Call us 24/7</span>
                                            <a href="tel:123456789">+0123 456 789</a>
                                        </div><!-- End .col-sm-6 -->
                                        <div class="col-sm-6 col-md-8">
                                            <!-- End .footer-payments -->
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->
                                </div><!-- End .widget-about-info -->
                            </div><!-- End .widget about-widget -->
                        </div><!-- End .col-sm-12 col-lg-3 -->

                        <div class="col-sm-4 col-lg-2">

                        </div><!-- End .col-sm-4 col-lg-3 -->

                        <div class="col-sm-4 col-lg-2">
                            <div class="widget">
                                <h4 class="widget-title">Pages</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="{{url('user/shop')}}">Shop</a></li>
                                    <li><a href="{{url('user/about')}}">About Us</a></li>
                                    <li><a href="{{url('user/cart')}}">Add To Cart</a></li>
                                    <li><a href="{{url('user/contact')}}">Contact us</a></li>
                                    <li><a href="{{url('/login')}}">Log in</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->

                        </div><!-- End .col-sm-4 col-lg-3 -->

                        <div class="col-sm-4 col-lg-2">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="#">Sign In</a></li>
                                    <li><a href="cart.html">View Cart</a></li>
                                    <li><a href="#">My Wishlist</a></li>
                                    <li><a href="#">Track My Order</a></li>
                                    <li><a href="#">Help</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-64 col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="footer-bottom">
                <div class="container">
                    <p class="footer-copyright">Copyright © 2026 The_Style_Studio. All Rights Reserved.</p><!-- End .footer-copyright -->
                    <ul class="footer-menu">
                        <li><a href="#">Terms Of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul><!-- End .footer-menu -->
                    <div class="social-icons social-icons-color">
                        <span class="social-label">Social Media</span>
                        <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                        <a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                    </div><!-- End .soial-icons -->
                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Plugins JS File -->
    <script src="{{asset('user/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('user/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.hoverIntent.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('user/assets/js/superfish.min.js')}}"></script>
    <script src="{{asset('user/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.plugin.min.js')}}"></script>
    <script src="{{asset('user/assets/js/jquery.countdown.min.js')}}"></script>

    <!-- Main JS File -->
    <script src="{{asset('user/assets/js/main.js')}}"></script>
    <script src="{{asset('user/assets/js/demos/demo-5.js')}}"></script>
</body>


<!-- molla/index-5.html  22 Nov 2019 09:56:18 GMT -->

</html>