
<!-- new header code start -->

<?php

use App\Models\Header;
use App\Models\Route;

$header = Header::find(2);

use App\Models\SiteSetting;

$routes = Route::orderBy('order')->get();

$headrsnumber = SiteSetting::find(8);

?>
 <!-- Header -->
 <header class="bb-header">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-top-header">

                        <div class="col-right-bar">

                            <div class="cols">
                                <a href="track-order.html">Track Order</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-bottom-header">
                        <div class="cols bb-logo-detail">
                            <!-- Header Logo Start -->
                            <div class="header-logo">
                                <a href="{{ url('/') }}">

                                    
                                    <img src="{{ asset(getSetting()->logo) }}" alt="{{ getSetting()->site_name }}" class="light">
                                    <img src="{{ asset(getSetting()->logo) }}" alt="{{ getSetting()->site_name }}" class="dark">
                                    
                                    
                                </a>
                            </div>
                            <!-- Header Logo End -->

                        </div>

                        <div class="cols bb-icons">
                            <div class="bb-flex-justify">
                                <div class="bb-header-buttons">
                                    <div class="bb-acc-drop">
                                        @auth
                                        <!-- Authenticated User Menu -->
                                        <a href="javascript:void(0)"
                                            class="bb-header-btn bb-header-user dropdown-toggle bb-user-toggle"
                                            title="Account">
                                            <div class="header-icon">
                                               
                                            </div>
                                            <div class="bb-btn-desc">
                                                <span class="bb-btn-title">{{ explode(' ', Auth::user()->name)[0] }}</span> <!-- Show First Name -->
                                                <span class="bb-btn-stitle">Account</span>
                                            </div>
                                        </a>
                                        <ul class="bb-dropdown-menu">
                                            <li><a class="dropdown-item" href="/take-order">Take Order</a></li>
                                            <li><a class="dropdown-item" href="/watch">Watch</a></li>
                                            <li><a class="dropdown-item" href="/favorites">Favorite</a></li>
                                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                                            <li>
                                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                        @else
                                        <!-- Guest User Menu -->
                                        <a href="/login" class="bb-header-btn bb-header-user" title="Register">
                                            <div class="header-icon">
                                                <svg class="svg-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M512.476 648.247c-170.169 ... 985.115z" />
                                                </svg>
                                            </div>
                                            <div class="bb-btn-desc">
                                                <span class="bb-btn-title">Login & Register</span>
                                                <span class="bb-btn-stitle">Join us</span>
                                            </div>
                                        </a>
                                        @endauth
                                    </div>
                                    @auth
                                    <!-- Cart Icon (Visible to All) -->
                                    <a href="/cart" class="bb-header-btn bb-cart-toggle" title="Cart">
                                        <div class="header-icon">
                                            <svg class="svg-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M351.552 831.424c-35.328 ... 671.52" />
                                            </svg>
                                            <span class="main-label-note-new"></span>
                                        </div>
                                        <div class="bb-btn-desc">
                                            <span class="bb-btn-title"><b class="bb-cart-count">4</b> items</span>
                                            <span class="bb-btn-stitle">Cart</span>
                                        </div>
                                    </a>
                                    @endauth

                                    <a href="javascript:void(0)" class="bb-toggle-menu">
                                        <div class="header-icon">
                                            <i class="ri-menu-3-fill"></i>
                                        </div>
                                    </a>
                                   
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    .bb-main-menu {
    background-color: #f8f9fa;
}

.navbar-nav {
    margin-left: auto;
    margin-right: auto;
    display: flex;
    flex-direction: column;
}

.nav-item {
    padding: 10px 15px;
}

.nav-item:hover {
    background-color: #e9ecef;
}

.nav-link {
    color: #007bff !important;
    font-size: 16px;
}

.nav-link:hover {
    color: #0056b3 !important;
}

.dropdown-menu {
    background-color: #f8f9fa;
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.dropdown-item:hover {
    background-color: #e9ecef;
}

</style>

<style>.bb-mobile-menu {
    display: none;
    /* other styles */
}

.bb-mobile-menu.active {
    display: block;
}

.bb-mobile-menu-overlay {
    display: none;
    /* styles for overlay */
}

.bb-mobile-menu-overlay.active {
    display: block;
}
</style>

<div class="bb-main-menu-desk">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bb-inner-menu-desk">
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <i class="ri-menu-2-line"></i>
                        </button>

                        <div class="bb-main-menu collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                @foreach ($routes as $route)
                                    @if (!empty($route->url)) <!-- Check if the route has a non-empty URL -->
                                        <li class="nav-item">
                                            <a href="{{ url($route->url) }}" class="nav-link">{{ $route->name }}</a>
                                        </li>
                                    @elseif (!empty($route->module_id)) <!-- If no URL, check for module_id -->
                                        @php
                                            // Fetch the module data based on the module_id
                                            $moduleData = \App\Models\ModulesData::where('module_id', $route->module_id)->get();
                                        @endphp

                                        <!-- If module data exists, loop through it to create sub-menus -->
                                        @if ($moduleData->isNotEmpty())
                                           <!-- Modify this part to ensure dropdowns work properly -->
                                            <li class="nav-item dropdown">
                                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $route->name }}
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                    @foreach ($moduleData as $module)
                                                        <li>
                                                            <a class="dropdown-item" href="{{ $route->sub_menu_url.'/' . $module->slug }}">
                                                                {{ $module->title ?? 'No Title' }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                        @else
                                            <!-- Handle case when module_data is empty -->
                                            <li class="nav-item">
                                                <a class="nav-link" href="javascript:void(0);">{{ $route->name ?? 'Unnamed Route' }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <!-- Handle case when neither URL nor module_id is present -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0);">{{ $route->name ?? 'Unnamed Route' }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<div class="bb-mobile-menu-overlay"></div>
<div id="bb-mobile-menu" class="bb-mobile-menu">
    <div class="bb-menu-title">
        <span class="menu_title">My Menu</span>
        <button type="button" class="bb-close-menu">×</button>
    </div>
    <div class="bb-menu-inner">
        <div class="bb-menu-content">
            <ul>
                @foreach ($routes as $route)
                                @if (!empty($route->url)) <!-- Check if the route has a non-empty URL -->
                                    <li class="nav-item">
                                        <a href="{{ url($route->url) }}" class="nav-link">{{ $route->name }}</a>
                                    </li>
                                @elseif (!empty($route->module_id)) <!-- If no URL, check for module_id -->
                                    @php
                                        // Fetch the module data based on the module_id
                                        $moduleData = \App\Models\ModulesData::where('module_id', $route->module_id)->get();
                                    @endphp

                                    <!-- If module data exists, loop through it to create sub-menus -->
                                    @if ($moduleData->isNotEmpty())
                                        <li class="nav-item dropdown">
                                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                                               data-bs-toggle="dropdown" aria-expanded="false">
                                               {{ $route->name }}
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                @foreach ($moduleData as $module)
                                                    <li>
                                                        <a class="dropdown-item" href="{{ $route->sub_menu_url.'/' . $module->slug }}">
                                                            {{ $module->title ?? 'No Title' }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <!-- Handle case when module_data is empty -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0);">{{ $route->name ?? 'Unnamed Route' }}</a>
                                        </li>
                                    @endif
                                @else
                                    <!-- Handle case when neither URL nor module_id is present -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0);">{{ $route->name ?? 'Unnamed Route' }}</a>
                                    </li>
                                @endif
                            @endforeach
            </ul>
        </div>
        
    </div>
</div>

<!-- Bootstrap JS -->
<!-- Bootstrap CSS -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
    $('.bb-toggle-menu').on('click', function() {
        $('#bb-mobile-menu').toggleClass('active');
        $('.bb-mobile-menu-overlay').fadeIn();
    });

    $('.bb-close-menu, .bb-mobile-menu-overlay').on('click', function() {
        $('#bb-mobile-menu').removeClass('active');
        $('.bb-mobile-menu-overlay').fadeOut();
    });
});
$(document).ready(function() {
    // Toggle the dropdown on desktop view
    $('.navbar-nav .dropdown-toggle').on('click', function (e) {
        var $el = $(this).next('.dropdown-menu');
        var isVisible = $el.is(':visible');
        
        // Close all dropdowns first
        $('.dropdown-menu').slideUp('400');

        // If this was not already visible, open it
        if (!isVisible) {
            $el.stop(true, true).slideDown('400');
        }
    });

    // Hide the dropdowns if clicked outside
    $(document).click(function (e) {
        if (!$(e.target).closest('.navbar-nav').length) {
            $('.dropdown-menu').slideUp('400');
        }
    });
});

</script>
</header>
<!-- new header code end  -->
