<!-- Main Sidebar Container -->
@php
    $currentRoute = Route::current()->getName();
    $admin = Auth::guard('admin')->user();
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        {{-- <img src="" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">Admin {{trans('language.website')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ route('admin.avatar',['id'=> $admin->id]) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.profile') }}" class="d-block">{{ $admin->user_name}}</a>
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
                    <!-- <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./index.html" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Dashboard v1</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./index2.html" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Dashboard v2</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./index3.html" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Dashboard v3</p>
                        </a>
                      </li>
                    </ul> -->
                </li>

                @php
                    $routeProfile = [
                        'admin.profile'
                    ];
                    $routeActive = $routeProfile;
                @endphp
                <li class="nav-item {{ in_array($currentRoute, $routeActive) ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{ in_array($currentRoute, $routeActive) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            {{ trans('language.profile') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route("admin.profile") }}" class="nav-link {{ in_array($currentRoute, $routeProfile) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.profile_info') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $routeUserList = [
                        'admin.user.index'
                    ];
                    $routeUserCreate = [
                        'admin.user.create'
                    ];
                    $routeUserEdit = [
                        'admin.user.edit'
                    ];
                    $routeActive = array_merge($routeUserList, $routeUserCreate, $routeUserEdit);
                @endphp
                <li class="nav-item {{ in_array($currentRoute, $routeActive) ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{ in_array($currentRoute, $routeActive) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            {{ trans('language.user_management') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route("admin.user.index") }}" class="nav-link {{ in_array($currentRoute, $routeUserList) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.user_list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.user.create") }}" class="nav-link {{ in_array($currentRoute, $routeUserCreate) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.add_new') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $routeCustomerList = [
                        'admin.customer.index'
                    ];
                    $routeCustomerCreate = [
                        'admin.customer.create'
                    ];
                    $routeCustomerEdit = [
                        'admin.customer.edit'
                    ];
                    $routeActive = array_merge($routeCustomerList, $routeCustomerCreate, $routeCustomerEdit);
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
                            <a href="{{ route("admin.customer.index") }}" class="nav-link {{ in_array($currentRoute, $routeCustomerList) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.customer_list') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.customer.create") }}" class="nav-link {{ in_array($currentRoute, $routeCustomerCreate) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.add_new') }}</p>
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
                    $routeBrand = [
                        'admin.brand.index',
                    ];
                    $routeCoupon = [
                        'admin.coupon.index',
                        'admin.coupon.create',
                        'admin.coupon.edit',
                    ];
                    $routeActive = array_merge($routeProduct, $routeProductCategory, $routeBrand, $routeCoupon);
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
                        <li class="nav-item">
                            <a href="{{ route('admin.brand.index')}}" class="nav-link {{ in_array($currentRoute, $routeBrand) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.brand') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.coupon.index')}}" class="nav-link {{ in_array($currentRoute, $routeCoupon) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.coupon') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $routeOrder = [
                        'admin.order.index',
                        'admin.order.show',
                    ];
                    $routeActive = array_merge($routeOrder);
                @endphp
                <li class="nav-item {{ in_array($currentRoute, $routeActive) ? 'menu-open' : ''}}">
                    <a href="#" class="nav-link {{ in_array($currentRoute, $routeActive) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            {{ trans('language.order_management') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route("admin.order.index") }}" class="nav-link {{ in_array($currentRoute, $routeOrder) ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('language.order_list') }}</p>
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
