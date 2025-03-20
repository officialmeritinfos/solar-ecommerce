<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Stylesheets -->
    <link href="{{ asset('home/product_detail/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home/product_detail/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('home/product_detail/css/responsive.css') }}" rel="stylesheet">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset( $web->favicon) }}">
    <title>{{ $pageName }} - {{ $siteName }}</title>

    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js') }}"></script><![endif]-->
    <!--[if lt IE 9]><script src="{{ asset('home/product_detail/js/respond.js') }}"></script><![endif]-->
    @stack('css')
    @include('general_css')
</head>

<body>
<div class="page-wrapper">
    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Main Header-->
    <header class="main-header header-style-one">
        <!-- Header Top -->
        <div class="header-top">
            <div class="top-left">
                <!-- Info List -->
                <ul class="list-style-one">
                    <li><i class="fa fa-map-marker-alt"></i> {{ $web->address }}</li>
                    <li><i class="fa fa-envelope"></i> <a href="mailto:{{ $web->support_email }}">{{ $web->support_email }}</a></li>
                    <li><i class="fa fa-phone-volume"></i> <a href="tel:{{ $web->support_phone }}">{{ $web->support_phone }}</a></li>
                </ul>
            </div>

            <div class="top-right">
                <ul class="social-icon-one">
                    @foreach(companySocials() as $social)
                        <li><a href="{{ $social->links }}" target="_blank"><i class="{{ $social->icon }}"></i></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- Header Top -->

        <!-- Header Lower -->
        <div class="header-lower">
            <!-- Main box -->
            <div class="main-box">
                <div class="logo-box">
                    <div class="logo">
                        <a href="{{ route('home') }}"><img src="{{ asset($web->logo) }}" alt="" title="{{$siteName}}" style="width: 120px;" /></a>
                    </div>
                </div>

                <!--Nav Box-->
                <div class="nav-outer">
                    <nav class="nav main-menu">
                        <ul class="navigation">
                            <li class="current">
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('home.about') }}">About Us</a>
                            </li>
                            <li>
                                <a href="{{ route('shop') }}">Shop</a>
                            </li>
                            <li class="dropdown">
                                <a href="#">Products</a>
                                <ul>
                                    @foreach(getCategories() as $category)
                                        <li><a href="{{ route('shop.category.products',$category->slug) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ route('home.solutions') }}">Solutions</a></li>
                            <li><a href="{{ route('home.contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                    <!-- Main Menu End-->

                    <div class="outer-box">
                        <a href="{{ route('cart.index') }}" class="ui-btn"><i class="lnr-icon-shopping-cart"></i></a>

                        <a href="{{ route('home.contact') }}" class="theme-btn btn-style-one alternate"><span class="btn-title">Get A Quote</span></a>

                        <!-- Mobile Nav toggler -->
                        <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Lower -->

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>

            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            <nav class="menu-box">
                <div class="upper-box">
                    <div class="nav-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset($web->logo) }}" alt="" title="Fesho" /></a>
                    </div>
                    <div class="close-btn"><i class="icon fa fa-times"></i></div>
                </div>

                <ul class="navigation clearfix">
                    <!--Keep This Empty / Menu will come through Javascript-->
                </ul>
                <ul class="contact-list-one">
                    <li>
                        <!-- Contact Info Box -->
                        <div class="contact-info-box">
                            <i class="icon lnr-icon-phone-handset"></i>
                            <span class="title">Call Now</span>
                            <a href="tel:{{ $web->support_phone }}">{{ $web->support_phone }}</a>
                        </div>
                    </li>
                    <li>
                        <!-- Contact Info Box -->
                        <div class="contact-info-box">
                            <span class="icon lnr-icon-envelope1"></span>
                            <span class="title">Send Email</span>
                            <a href="mailto:{{ $web->support_email }}">
                                {{ $web->support_email }}
                            </a>
                        </div>
                    </li>
                    <li>
                        <!-- Contact Info Box -->
                        <div class="contact-info-box">
                            <span class="icon lnr-icon-clock"></span>
                            <span class="title">Visit</span>
                            {{ $web->address }}
                        </div>
                    </li>
                </ul>

                <ul class="social-links">
                    @foreach(companySocials() as $social)
                        <li><a href="{{ $social->links }}" target="_blank"><i class="{{ $social->icon }}"></i></a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
        <!-- End Mobile Menu -->


        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container">
                <div class="inner-container">
                    <!--Logo-->
                    <div class="logo">
                        <a href="{{ route('home') }}" title=""><img src="{{ asset($web->logo) }}" alt="" title="" /></a>
                    </div>

                    <!--Right Col-->
                    <div class="nav-outer">
                        <!-- Main Menu -->
                        <nav class="main-menu">
                            <div class="navbar-collapse show collapse clearfix">
                                <ul class="navigation clearfix">
                                    <!--Keep This Empty / Menu will come through Javascript-->
                                </ul>
                            </div>
                        </nav>
                        <!-- Main Menu End-->

                        <!--Mobile Navigation Toggler-->
                        <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Sticky Menu -->
    </header>
    <!--End Main Header -->

    <!-- Start main-content -->
    <section class="page-title" style="background-image: url({{ asset('home/product_detail/images/background/page-title-bg.png') }});">
        <div class="auto-container">
            <div class="title-outer text-center">
                <h1 class="title">{{$pageName}}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index">Home</a></li>
                    <li>{{ $pageName }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- end main-content -->

    @yield('content')

    <!-- Main Footer -->
    <footer class="main-footer style-one pt-0">
        <div class="bg-image" style="background-image: url({{ asset('home/product_detail/images/background/5.jpg') }})"></div>
        <!--Widgets Section-->
        <div class="widgets-section">
            <div class="auto-container">
                <div class="row">
                    <!--Footer Column-->
                    <div class="footer-column col-xl-4 col-sm-6">
                        <div class="footer-widget">
                            <h3 class="widget-title">Products</h3>
                            <ul class="user-links two-column">
                                @foreach(getCategories() as $category)
                                    <li><a href="{{ route('shop.category.products',$category->slug) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!--Footer Column-->
                    <div class="footer-column col-xl-4 col-sm-6">
                        <div class="footer-widget">
                            <h3 class="widget-title">Useful Links</h3>
                            <ul class="user-links two-column">
                                <li>
                                    <a href="{{ route('home.about') }}">
                                        <p>About Us</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home.faqs') }}">
                                        <p>Faqs</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home.contact') }}">
                                        <p>Contact Us</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('legal.terms-and-conditions') }}">
                                        <p>Terms of Service</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('legal.privacy-policy') }}">
                                        <p>Privacy Policy</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('legal.refund-policy') }}">
                                        <p>Refund Policy</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--Footer Column-->
                    <div class="footer-column col-xl-4 col-sm-6">
                        <div class="footer-widget gallery-widget">
                            <h3 class="widget-title">Other Links</h3>
                            <ul class="user-links two-column">
                                <li>
                                    <a href="#">
                                        <p>Engineer Registrations</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p>OEMs Registration</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <p>Affiliate Registration</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('legal.shipping-policy') }}">
                                        <p>Shipping Policy</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--Footer Bottom-->
        <div class="footer-bottom">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="copyright-text">
                        <p>&copy; Copyright reserved by <a href="{{ route('home') }}">{{ $siteName }}</a></p>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <!--End Main Footer -->
</div><!-- End Page Wrapper -->
<!-- Scroll To Top -->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
<script src="{{ asset('home/product_detail/js/jquery.js') }}"></script>
<script src="{{ asset('home/product_detail/js/popper.min.js') }}"></script>
<script src="{{ asset('home/product_detail/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('home/product_detail/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('home/product_detail/js/jquery-ui.js') }}"></script>
<script src="{{ asset('home/product_detail/js/jquery.countdown.js') }}"></script>
<script src="{{ asset('home/product_detail/js/bxslider.js') }}"></script>
<script src="{{ asset('home/product_detail/js/mixitup.js') }}"></script>
<script src="{{ asset('home/product_detail/js/wow.js') }}"></script>
<script src="{{ asset('home/product_detail/js/appear.js') }}"></script>
<script src="{{ asset('home/product_detail/js/select2.min.js') }}"></script>
<script src="{{ asset('home/product_detail/js/swiper.min.js') }}"></script>
<script src="{{ asset('home/product_detail/js/owl.js') }}"></script>
<script src="{{ asset('home/product_detail/js/script.js') }}"></script>
@include('general_js')
@stack('js')
</body>
</html>
