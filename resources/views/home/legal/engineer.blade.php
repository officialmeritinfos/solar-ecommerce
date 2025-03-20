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


    <!-- rts service details area start -->
    <div class="rts-service-details-area rts-section-gap">
        <div class="container">
            <div class="row g-40">
                <div class="col-lg-12">
                    {!! str_replace(['[Company]','[Phone]','[Email]','[Website]'],[$web->name,$web->support_phone,$web->support_email,url('/')], $web->engineers) !!}
                    @if($web->engineer_form)
                        <div class=" mt-5">
                            <a href="{{ asset($web->engineer_form) }}" download class="btn btn-outline-primary">Download the form and sign</a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <!-- rts service details area end -->

@endsection
