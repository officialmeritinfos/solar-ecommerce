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

    <div class="shopping-area-start rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-center title-g">
                        <p class="pre">
                        </p>
                        <h2 class="title">
                            {{ $pageName }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row g-24 mt--0">

                @foreach($products as $product)
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb--30 mb-4 d-flex">
                        <div class="single-shopping-product card w-100 d-flex flex-column">
                            <a href="{{ route('shop.products.details',['slug'=>$product->slug,'id'=>$product->id]) }}" class="thumbnail">
                                <div class="image-wrapper">
                                    <img src="{{ asset($product->featuredImage) }}" alt="shopping" class="product-img">
                                </div>
                            </a>
                            <div class="inner-content card-body d-flex flex-column justify-content-between">
                                <a href="{{ route('shop.products.details',['slug'=>$product->slug,'id'=>$product->id]) }}">
                                    <h6 class="title mb-2">{{ $product->name }}</h6>
                                </a>
                                <div class="button-cart-area mt-auto">
                                    <div class="inner">
                                        <div class="pricing-area">
                                            <span class="active">{{ getCurrencySign() }}{{ $product->sale_price }}</span>
                                            <span class="none">{{ getCurrencySign() }}{{ $product->price }}</span>
                                        </div>
                                        <a href="{{ route('shop.products.details',['slug'=>$product->slug,'id'=>$product->id]) }}" class="cart-btn">
                                            <i class="fa-regular fa-cart-shopping"></i>
                                            <span>Buy Now</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="invisible-btn">
                                <ul>
                                    <li><a href="{{ route('shop.products.details',['slug'=>$product->slug,'id'=>$product->id]) }}"><i class="fa-light fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="row mt--30">
                <div class="col-lg-12">
                    <div class="rts-elevate-pagination">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
