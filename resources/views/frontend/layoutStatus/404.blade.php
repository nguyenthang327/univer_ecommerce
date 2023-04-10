<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('images/breadcrumb_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2>Page Not Found</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">404 Page</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- 404-area -->
    <section class="error-area pt-80 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="error-content text-center">
                        <div class="error_txt">404</div>
                        <h5>oops! The page you requested was not found!</h5>
                        <p>The page you are looking for was moved, removed, renamed or might never existed.</p>

                        <a href="{{ route('site.home') }}" class="btn btn-fill-out mt-3">Back To Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 404-area-end -->

</main>
<!-- main-area-end -->
