<!doctype html>
<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{asset('dashboard/')}}/"
    data-template="vertical-menu-template"
    data-style="light">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>{{ $pageName }} | {{ $siteName }}</title>


    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset($web->favicon) }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('dashboard/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('dashboard/vendor/fonts/tabler-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('dashboard/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{asset('dashboard/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('dashboard/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />

    <link rel="stylesheet" href="{{asset('dashboard/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/vendor/libs/node-waves/node-waves.css')}}" />

    <link rel="stylesheet" href="{{asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('dashboard/vendor/libs/typeahead-js/typeahead.css')}}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{asset('dashboard/vendor/libs/@form-validation/form-validation.css')}}" />

    @include('general_css')
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('dashboard/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('dashboard/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js')}} in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js')}}.  -->
    <script src="{{asset('dashboard/vendor/js/template-customizer.js')}}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('dashboard/js/config.js')}}"></script>
</head>

<body>
<!-- Content -->

<div class="authentication-wrapper authentication-basic px-6">
    <div class="authentication-inner py-6">
        <!--  Two Steps Verification -->
        <div class="card">
            <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center mb-6">
                    <a href="{{ route('home') }}" class="app-brand-link">
                        <img src="{{ asset($web->logo) }}" style="width: 100px;" />
                    </a>
                </div>
                <!-- /Logo -->
                <h4 class="mb-1 text-center">
                    Forgot Password? 🔒
                </h4>
                <p class="text-start mb-6">
                    Enter your email and we'll send you instructions to reset your password
                </p>
                <form id="twoStepsForm" action="{{ route('account-recovery.process') }}" method="POST">
                    <div class="mb-6">
                        <label for="email" class="form-label">Email/Phone</label>
                        <input
                            type="text"
                            class="form-control"
                            id="email"
                            name="email-phone"
                            placeholder="Enter your email or phone number"
                            autofocus />
                    </div>
                    <button class="btn btn-primary d-grid w-100 mb-6 submit">Send Reset Link</button>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="d-flex justify-content-center">
                            <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
                            Back to login
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <!-- / Two Steps Verification -->
    </div>
</div>

<!-- / Content -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js')}} -->

<script src="{{asset('dashboard/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('dashboard/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('dashboard/vendor/js/menu.js')}}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('dashboard/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/@form-validation/popular.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
<script src="{{asset('dashboard/vendor/libs/@form-validation/auto-focus.js')}}"></script>

<!-- Main JS -->
<script src="{{asset('dashboard/js/main.js')}}"></script>

<!-- Page JS -->
<script src="{{asset('dashboard/js/pages-auth.js')}}"></script>

@include('general_js')
<script src="{{ asset('dashboard/requests/auth/account_recovery.js') }}"></script>
</body>
</html>
