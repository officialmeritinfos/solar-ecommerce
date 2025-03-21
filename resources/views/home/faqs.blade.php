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


    <!-- rts faq area start -->
    <div class="rts-faq-area rts-section-gap">
        <div class="container">
            <div class="row g-24 align-items-start">
                <div class="col-lg-12">
                    <div class="title-area-left">
                        <p class="pre">
                            <span>Question</span> For US
                        </p>
                        <h2 class="title skew-up">
                            Some General Question?
                        </h2>
                    </div>
                    <div class="accordion-solar-faq">
                        <div class="accordion" id="accordionExample">
                            @foreach(companyFaqs() as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$faq->id}}" aria-expanded="true" aria-controls="collapseOne">
                                            {{ $faq->questions }}
                                        </button>
                                    </h2>
                                    <div id="collapseOne{{$faq->id}}" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {{ $faq->answers }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
