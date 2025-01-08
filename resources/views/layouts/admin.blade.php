<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <?php
use App\Models\Header;
use App\Models\About;
$sitename = Header::find(1);


$about = About::find(2);


?>

    <title>{{ (getSetting()->site_name) }}</title>

    <link rel="icon" href="{{ asset(getSetting()->logo) }}" type="image/gif" sizes="20x20">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
        <link href="{{asset('admin_assets/css/styles.css?v=2')}}" rel="stylesheet" />
        <link href="{{asset('admin_assets/css/app.css')}}" rel="stylesheet" />
        <link href="{{asset('admin_assets/css/dashforge.css')}}" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('admin_assets/plugins/summernote/summernote-bs4.min.css')}}">
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
            <link href="{{asset('admin_assets/bower_components/jquery.filer/css/jquery.filer.css')}}" type="text/css" rel="stylesheet" />
        <link href="{{asset('admin_assets/bower_components/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('admin_assets/libs/jsvectormap/css/jsvectormap.min.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App css -->
        <link href="{{asset('admin_assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin_assets/css/icons.min.cs')}}s" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin_assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />


        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Styles -->
        @livewireStyles
        <script type="text/javascript">
          var base_url = "{!!url('/')!!}"
          var images_limit = 1
        </script>
        <!-- Scripts -->
        <style>
        table.dataTable tbody tr {
            background-color: #fff;
        }

        table{
            width: 100% !important;
        }
        </style>
        @stack('css')

    </head>
    <body class="nav-fixed">
        @include('livewire.admin.common.navbar')



                @include('livewire.admin.common.sidebar')



                <main>
                    {{ $slot }}
                </main>

        @stack('modals')

        @livewireScripts
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('admin_assets/js/scripts.js')}}"></script>
        <script src="{{asset('admin_assets/assets/js/dynamic-form.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{asset('admin_assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <script src="{{asset('admin_assets/bower_components/jquery.filer/js/jquery.filer.min.js')}}"></script>
        <script src="{{asset('admin_assets/js/jquery.dataTables.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script src="{{asset('admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin_assets/libs/simplebar/simplebar.min.js')}}"></script>

        <script src="{{asset('admin_assets/libs/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{asset('admin_assets/data/stock-prices.js')}}"></script>
        <script src="{{asset('admin_assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
        <script src="{{asset('admin_assets/libs/jsvectormap/maps/world.js')}}"></script>
        <script src="{{asset('admin_assets/jscms/pages/index.init.js')}}"></script>
        <script src="{{asset('admin_assets/jscms/app.js')}}"></script>





        @stack('js')
    </body>
</html>
