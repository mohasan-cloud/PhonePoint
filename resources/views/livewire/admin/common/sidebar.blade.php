  <!-- leftbar-tab-menu -->

  <?php
use App\Models\AdminSetting;
use App\Models\Modules;

  $adminseeting = AdminSetting::find(1);
  $modules = Modules::get();


  ?>

  <div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="{{ url('admin/dashboard') }}" class="logo">

            <span>
                <img src="{{ asset(@$adminseeting->logo) }}" alt="{{@$adminseeting->dashboard_name}}" class="logo-lg logo-light img-fluid" style="height: 60px;">
                <img src="{{ asset(@$adminseeting->logo) }}" alt="{{@$adminseeting->dashboard_name}}" class="logo-lg logo-dark img-fluid" style="height: 60px;">
            </span>
        </a>
    </div>

    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu" >
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">
                    <li class="menu-label pt-0 mt-0">

                        <span>Main Menu</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/dashboard') }}">
                            <img width="64" height="64" src="https://img.icons8.com/arcade/64/performance-macbook.png" alt="performance-macbook"/>
                            <span>Dashboards</span>
                        </a>

                       <!--end startbarDashboards-->
                    </li><!--end nav-item-->


                    @foreach($modules as $module) <!-- Loop through modules -->
                    <li class="nav-item">
                        @can('list ' . strtolower($module->term), $module) <!-- Check if the user has permission to list the module -->
                            <a class="nav-link" href="{{ url('admin/'.$module->slug) }}">
                                <!-- Use the module's icon if it exists, otherwise use a default icon -->
                                <img width="60" height="60" src="https://img.icons8.com/papercut/60/shop.png" alt="shop"/>
                                <span>{{ $module->name }}</span> <!-- Display module name -->
                            </a>
                        @endcan
                    </li>
                @endforeach


                @can('scan')


                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/products/scan') }}">
                        <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                        <img width="50" height="50" src="https://img.icons8.com/ios/50/barcode.png" alt="barcode"/>
                                                <span>Scan</span>
                    </a>
                </li>

                @endcan


                @can('Products')


                <li class="nav-item">
                    <a class="nav-link" href="{{ url('products') }}">
                        <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                        <img width="48" height="48" src="https://img.icons8.com/fluency/48/fast-moving-consumer-goods.png" alt="fast-moving-consumer-goods"/>
                                                <span>Products</span>
                    </a>
                </li>

                @endcan
                @can('bills')


                <li class="nav-item">
                    <a class="nav-link" href="{{ url('bills') }}">
                        <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                        <img width="60" height="60" src="https://img.icons8.com/papercut/60/stack-of-money.png" alt="stack-of-money"/>
                                                <span>Customer Bills</span>
                    </a>
                </li>

                @endcan
                @can('shopbills')


                <li class="nav-item">
                    <a class="nav-link" href="{{ url('shops/bills') }}">
                        <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                        <img width="60" height="60" src="https://img.icons8.com/papercut/60/stack-of-money.png" alt="stack-of-money"/>
                         <span> Shops Bills</span>
                    </a>
                </li>

                @endcan
                @can('manage categories')


<li class="nav-item">
    <a class="nav-link" href="{{ url('/categories') }}">
        <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
        <img width="64" height="64" src="https://img.icons8.com/arcade/64/categorize.png" alt="categorize"/>
                 <span> Categories</span>
    </a>
</li>

@endcan

@can('manage discounts')


<li class="nav-item">
    <a class="nav-link" href="{{ url('/discounts') }}">
        <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
        <img width="64" height="64" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-offers-recruitment-agency-flaticons-lineal-color-flat-icons-2.png" alt="external-offers-recruitment-agency-flaticons-lineal-color-flat-icons-2"/>
                         <span> Discount</span>
    </a>
</li>

@endcan
                    @can('manage shop')


                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/shops') }}">
                            <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                            <img width="60" height="60" src="https://img.icons8.com/papercut/60/shop.png" alt="shop"/>
                            <span>Shop</span>
                        </a>
                    </li>

                    @endcan

                    @can('manage expenses')


<li class="nav-item">
    <a class="nav-link" href="{{ url('/expenses') }}">
        <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
        <img width="64" height="64" src="https://img.icons8.com/external-flaticons-flat-flat-icons/64/external-expenses-accounting-flaticons-flat-flat-icons-6.png" alt="external-expenses-accounting-flaticons-flat-flat-icons-6"/>
                <span>Expenses</span>
    </a>
</li>

@endcan
                    @can('list user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/users') }}">
                            <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                            <img width="50" height="50" src="https://img.icons8.com/3d-fluency/50/group.png" alt="group"/>
                            <span>Users</span>
                        </a>
                    </li>
                    @endcan

                    @can('list permission')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/permissions-list') }}">
                            <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                            <img width="64" height="64" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-end-user-privacy-flaticons-lineal-color-flat-icons-2.png" alt="external-end-user-privacy-flaticons-lineal-color-flat-icons-2"/></i><span>Permissions</span>
                        </a>
                    </li>

                    @endcan
                    @can('list roles')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/role-list') }}">
                            <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                            <img width="48" height="48" src="https://img.icons8.com/color/48/connected-people.png" alt="connected-people"/></i><span>Roles</span>
                        </a>
                    </li>

                    @endcan
                {{-- @can('Routes Managment')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/routes') }}">
                            <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                            <i class="fa-solid fa-gear mr-2 menu-icon"></i><span>Routes</span>
                        </a>
                    </li>

                    @endcan --}}
                    @can('list adminsetting')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin-settings') }}">
                            <!-- Font Awesome icon with margin-right to create space between the icon and the text -->
                            <img width="48" height="48" src="https://img.icons8.com/color/48/automatic.png" alt="automatic"/>
                            <span>Admin Setting</span>
                        </a>
                    </li>

                    @endcan
                </ul><!--end navbar-nav--->

            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->
</div><!--end startbar-->
