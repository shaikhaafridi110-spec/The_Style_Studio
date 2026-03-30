<!DOCTYPE html>
<html lang="en">

<head>
    <title>The_Style_Studio</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Font Awesome (ONLY ONE VERSION) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">

    @yield('user-css')
</head>



<body>
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" href="{{url('admin/home')}}"><img src="{{asset('admin/assets/images/logo.svg')}}"
                            alt="logo" /></a>
                    <a class="navbar-brand brand-logo-white" href="{{url('admin/home')}}"><img src="{{asset('admin/assets/images/logo-white.svg')}}"
                            alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="{{url('admin/home')}}"><img src="{{asset('admin/assets/images/logo-mini.svg')}}"
                            alt="logo" /></a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="text-align: end;">
                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <img src="{{asset('admin/assets/images/faces/f3.png')}}" alt="profile" />
                            <span class="nav-profile-name text-uppercase">
                                @if(Auth::check())
                                {{ Auth::user()->name }}
                                @else
                                <script>
                                    window.location.href = "{{ url('login') }}";
                                </script>
                                @endif

                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="mdi mdi-cog text-primary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{url('logout')}}">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/home')}}">
                            <i class="mdi mdi-home menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/user')}}">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">User</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/category')}}">
                            <i class="mdi mdi-view-grid-outline menu-icon"></i>
                            <span class="menu-title">Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/product')}}">
                            <i class="mdi mdi-shopping menu-icon"></i>
                            <span class="menu-title">Product</span>
                        </a>
                    </li>


                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/wishlist')}}">
                            <i class="mdi mdi-cart-heart menu-icon"></i>
                            <span class="menu-title">Wishlist</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#OrderMenu" aria-expanded="false" aria-controls="OrderMenu">
                            <i class="mdi mdi-package-variant-closed menu-icon"></i>
                            <span class="menu-title">Order</span>
                            <i class="menu-arrow"></i>
                        </a>

                        <div class="collapse" id="OrderMenu">
                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('admin/Order') }}">
                                        Order List
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('admin/Order-items') }}">
                                        Order Items List
                                    </a>
                                </li>
                               
                            </ul>
                        </div>
                    </li>

                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                @yield('main-content')
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <!-- partial -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 <a
                                href="https://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
                        <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i
                                class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="{{asset('admin/assets/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('admin/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('admin/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{asset('admin/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/assets/js/template.js')}}"></script>
    <script src="{{asset('admin/assets/js/settings.js')}}"></script>
    <script src="{{asset('admin/assets/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{asset('admin/assets/js/dashboard.js')}}"></script>
    <script src="{{asset('admin/assets/js/proBanner.js')}}"></script>

    <!-- End custom js for this page-->
    <script src="{{asset('admin/assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script>
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>

    @yield('js')
</body>

</html>