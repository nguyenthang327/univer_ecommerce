@php
    $user = Auth::guard('user')->user();
    $currentRoute = Route::current()->getName();
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ route('user.avatar',['id'=> $user->id]) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('user.profile') }}" class="d-block">{{ $user->user_name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>

                @php
                    $routeProfile = [
                        'user.profile'
                    ];
                    $routeActive = $routeProfile;
                @endphp
                <li class="nav-item {{ in_array($currentRoute, $routeActive) ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link  {{ in_array($currentRoute, $routeActive) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            {{ trans('language.profile') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route("user.profile") }}" class="nav-link  {{ in_array($currentRoute, $routeProfile) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.profile_info') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @php
                    $routeCustomerList = [
                        'user.customer.index'
                    ];
                    $routeActive = $routeCustomerList;
                @endphp
                <li class="nav-item {{ in_array($currentRoute, $routeActive) ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{ in_array($currentRoute, $routeActive) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            {{ trans('language.customer_management') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.customer.index')}}" class="nav-link {{ in_array($currentRoute, $routeCustomerList) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.customer_list') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $routeProduct = [
                        'user.product.index',
                        'user.product.create',
                        'user.product.edit',
                    ];
                    $routeProductCategory= [
                        'admin.productCategory.index',
                    ];
                    $routeActive = array_merge($routeProduct, $routeProductCategory);
                @endphp
                <li class="nav-item {{ in_array($currentRoute, $routeActive) ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{ in_array($currentRoute, $routeActive) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            {{ trans('language.product') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.productCategory.index')}}" class="nav-link {{ in_array($currentRoute, $routeProductCategory) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.product_category') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.product.index')}}" class="nav-link {{ in_array($currentRoute, $routeProduct) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.product') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
