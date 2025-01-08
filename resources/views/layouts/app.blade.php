<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php

    use App\Models\Header;
    use App\Models\About;

    $sitename = Header::find(2);

    use App\Models\Route;

    $routesss = Route::orderBy('order')->get();

    $about = About::find(2);
    $header = Header::find(2);

    $siteSetting = getSiteSettingById(8);


    use App\Models\SiteSetting;

    $siteseeting = SiteSetting::find(8);

    ?>

    <!-- <title>{{ Str::title(str_replace('-', ' ', getBreadcrumb()['title'])) }}</title> -->
    <!-- <title>
        @if (request()->is('/') || request()->is('panel'))
        Home
        @else
        {{ Str::title(str_replace('-', ' ', getBreadcrumb()['title'] ?? 'Default Title')) }}
        @endif
    </title> -->

    <title>
        @if (request()->is('/') || request()->is('panel'))
        Home
        @elseif (request()->is('contact'))
        Contact Us
        @else
        {{ Str::title(str_replace(['-', '_'], ' ', getBreadcrumb()['title'] ?? 'Default Title')) }}
        @endif
    </title>
    @php
    $breadcrumbData = getBreadcrumb(); // Call the helper function
@endphp
<!-- Meta Description -->
<meta name="description" content="{{ $breadcrumbData['meta_description'] ?? 'Default meta description' }}">

<!-- Meta Keywords -->
<meta name="keywords" content="{{ $breadcrumbData['meta_keywords'] ?? 'Default meta keywords' }}">
<link rel="icon" href="{{ asset(getSetting()->logo) }}" type="image/gif" sizes="20x20">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


    <!-- Css All Plugins Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/remixicon.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/aos.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/animate.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/jquery-range-ui.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
</head>

<body>





    <main>
        {{ $slot }}
    </main>


    @stack('modals')


    <!-- new code start here  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery for simplicity -->

    <!-- Plugins -->
    <script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.zoom.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/aos.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/smoothscroll.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-range-ui.min.js') }}"></script>

    <!-- main-js -->
    <script src="{{ asset('assets/js/main.js')}}"></script>



</body>


<!-- Mirrored from maraviyainfotech.com/projects/blueberry-html/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 26 Sep 2024 13:07:09 GMT -->
</html>
