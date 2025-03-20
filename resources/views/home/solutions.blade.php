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


    <!-- rts blog area start -->
    <div class="rts-blog-area rts-section-gapTop reveal">
        <div class="container pb--160">

            <div class="row g-24 mt--20">

                @foreach($solutions as $solution)
                    <div class="col-lg-6 col-md-6 col-12">
                        <!-- blog-single area start -->
                        <div class="blog-single-one text-center">
                            <a href="{{ route('home.solutions.details',$solution->id) }}" class="thumbnail">
                                <div class="inner">
                                    <img src="{{ asset($solution->photo) }}" alt="blog-image">
                                </div>
                            </a>
                            <div class="head">
                                <div class="tag-area single-info">
                                    <i class="fa-light fa-tags"></i>
                                    <p>{{ $solution->title }}</p>
                                </div>
                            </div>
                            <div class="body text-start">

                                <a href="{{ route('home.solutions.details',$solution->id) }}" class="rts-btn btn-border radious-0">
                                    Read Details
                                    <i class="fa-regular fa-arrow-up-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- blog-single area end -->
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- rts blog area end -->

@endsection
