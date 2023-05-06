<section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('images/breadcrumb_bg.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2>{{ $title }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('site.home')}}">{{ trans('language.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumbItem }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>