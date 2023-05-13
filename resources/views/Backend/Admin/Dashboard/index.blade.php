@extends('backend.admin.layout.master')
@section('title', trans('language.dashboard'))
@section('breadcrumb')
    <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link title">{{ trans('language.dashboard') }}</a>
    </li>
@endsection

@section('css_library')
    @include('backend.libraryGroup.style-library', ['chart' => true])
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            {{-- <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{trans('language.dashboard')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{trans('language.dashboard')}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row --> --}}
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $data['orderNeedProcess'] }}</h3>
                            <p>Tổng số đơn hàng cần xử lý</p>

                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $data['customers'] }}
                                {{-- <sup style="font-size: 20px">%</sup> --}}
                            </h3>

                            <p>Khách hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.customer.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $data['users'] }}</h3>

                            <p>Nhân viên</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.user.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $data['productSell'] }}</h3>

                            <p>Sản phẩm đang bán</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('user.product.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bold">{{ trans('language.top_favorite_product') }}</h3>
                            <div class="card-tools">
                                {{-- <a href="#" class="btn btn-tool btn-sm">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="#" class="btn btn-tool btn-sm">
                                    <i class="fas fa-bars"></i>
                                </a> --}}
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ trans('language.ordinal_number') }}</th>
                                        <th class="text-center">{{ trans('language.product') }}</th>
                                        <th class="text-center">{{ trans('language.number') }}</th>
                                        <th class="text-center">More</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['topFavoriteProduct'] as $key => $product)
                                        <tr>
                                            <td class="text-center">{{ ++$key }}</td>
                                            <td class="d-flex">
                                                <img src="{{ $product->gallery ? asset('storage/' . $product->gallery[0]['file_path']) : '' }}"
                                                    alt="{{ $product->name }} " class="img-circle img-size-32 mr-2"
                                                    onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                                                <span class="line-clamp-2">{{ $product->name }}</span>
                                            </td>
                                            <td class="text-center">{{ $product->total }}</td>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('user.product.edit', ['slug' => $product->slug]) }}"
                                                    class="text-muted">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card" id="chart_order" data-week={{$orderThisWeek}} data-week2={{$orderLastWeek}}>
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">{{trans('language.revenue_statistics')}}</h3>
                                {{-- <a href="javascript:void(0);">View Report</a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                @php
                                    $total = \App\Services\ProcessPriceService::regularPrice($orderThisWeek->last(), null);
                                @endphp
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{trans('language.today')}}: {{$total['new']}}</span>
                                    {{-- <span>Sales Over Time</span>
                                </p>
                                {{-- <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 33.1%
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                </p> --}}
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="sales-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This week {{trans('language.this_week')}}
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Last week {{trans('language.last_week')}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div><!-- /.container-fluid -->
    </section>

@stop

@section('js_library')
    @include('backend.libraryGroup.script-library', ['chart' => true])
@stop

@section('js_page')
    <script>
        $(function() {

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }
            console.log(123);
            var mode = 'index';
            var intersect = true;

            var $salesChart = $('#sales-chart')
            // eslint-disable-next-line no-unused-vars
            var salesChart = new Chart($salesChart, {
                type: 'bar',
                data: {
                    labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'],
                    datasets: [{
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: {{$orderThisWeek}}
                        },
                        {
                            backgroundColor: '#ced4da',
                            borderColor: '#ced4da',
                            data: {{$orderLastWeek}}
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function(value) {
                                    if (value >= 1000) {
                                        value /= 1000
                                        value += 'k'
                                    }

                                    return '$' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        })
    </script>
@stop
