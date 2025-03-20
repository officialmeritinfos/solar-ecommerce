@extends('home.layout.base')
@section('content')
    <!-- rts breadcrumb area -->
    <div class="rts-bread-crumb-area bg_image bg-breadcrumb">
        <div class="container ptb--65">
            <div class="row">
                <div class="col-lg-12">
                    <div class="con-tent-main">
                        <div class="wrapper">
                            <span class="bg-text-stok">{{ $pageName }}</span>
                            <div class="title skew-up">
                                <a href="#">{{ $pageName }}</a>
                            </div>
                            <div class="slug skew-up">
                                <a href="{{ route('home') }}">HOME /</a>
                                <a class="active" href="{{ url()->current() }}">{{ $pageName }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts breadcrumb area end -->

    @if($about)
        <!-- rts about area start -->
        <div class="rts-about-area rts-section-gap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <!-- about inner solar energy -->
                        <div class="rts-about-left-image-area">
                            <div class="thumbnail">
                                <img src="{{ asset($about->photo) }}" alt="solar energy">
                            </div>
                        </div>
                        <!-- about inner solar energy end -->
                    </div>
                    <div class="col-lg-6">
                        <!-- about nrighht content area start -->
                        <div class="about-right-content-area-solar-energy">
                            <div class="title-area-left">
                                <p class="pre">
                                    <span>About</span> {{ $siteName }}
                                </p>
                                <h2 class="title skew-up">
                                    {{ $about->title??'' }}
                                </h2>
                            </div>
                            <!-- tab area start about -->
                            <ul class="nav custom-nav-soalr-about nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Why Choose Us?</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Our Mission</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Our Goal</button>
                                </li>
                            </ul>

                            <!-- nav content start -->
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <!-- single nav content start -->
                                    <div class="single-about-content-solar">
                                        {!! $about->whyChooseUs??'' !!}
                                    </div>
                                    <!-- single nav content end -->
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <!-- single nav content start -->
                                    <div class="single-about-content-solar">
                                        {!! $about->mission??'' !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <!-- single nav content start -->
                                    <div class="single-about-content-solar">
                                        {!! $about->vision??'' !!}
                                    </div>
                                    <!-- single nav content end -->
                                </div>
                            </div>
                            <!-- nav content end -->
                            <!-- tab area start about end -->

                        </div>
                        <!-- about nrighht content area end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- rts about area end -->
    @endif
@endsection
