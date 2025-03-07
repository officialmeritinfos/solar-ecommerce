<!doctype html>
<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('dashboard') }}/"
    data-template="vertical-menu-template"
    data-style="light">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $pageName }} - {{ $siteName }}</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset($web->logo) }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/fonts/flag-icons.css') }}" />

    @livewireStyles

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{ asset('dashboard/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />

    <link rel="stylesheet" href="{{ asset('dashboard/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/node-waves/node-waves.css') }}" />

    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />

    @include('general_css')
    @stack('css')
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/css/pages/cards-advance.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/tagify/tagify.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('dashboard/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js') }} in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('dashboard/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('dashboard/js/config.js') }}"></script>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('admin.layout.side_menu')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('admin.layout.top_menu')
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>

                @include('admin.layout.footer')

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js') }} -->

<script src="{{ asset('dashboard/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('dashboard/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ asset('dashboard/vendor/js/menu.js') }}"></script>

<script src="{{ asset('dashboard/vendor/libs/quill/katex.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/quill/quill.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/tagify/tagify.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('dashboard/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('dashboard/js/main.js') }}"></script>
<script src="{{ asset('dashboard/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: ".editor",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor code",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste",
            "table"
        ],
        toolbar:
            "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | " +
            "bullist numlist outdent indent | link image | table",
        file_picker_types: 'image',
        image_title: true,
        automatic_uploads: false,
        images_upload_handler: function(blobInfo, success, failure) {
            failure("Image uploading is disabled. Use an image URL instead.");
        },
        file_picker_callback: function(callback, value, meta) {
            if (meta.filetype === 'image') {
                let url = prompt('Enter the image URL:'); // Prompt for URL input
                if (url) {
                    callback(url, { alt: 'Image' });
                }
            }
        },
        table_toolbar: "tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | " +
            "tableinsertcolbefore tableinsertcolafter tabledeletecol",
        setup: function (editor) {
            editor.on("change", function () {
                tinymce.triggerSave(); // Ensures the content is saved to the textarea
            });
        }
    });
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
@include('general_js')
@stack('js')
@livewireScripts
</body>
</html>
