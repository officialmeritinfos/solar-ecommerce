@extends('home.layout.shop_base')
@section('content')
    @push('css')
        <style>
            /* Make thumbnail area horizontally scrollable */
            .flex-control-thumbs {
                display: flex !important;
                flex-wrap: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
                gap: 0.5rem;
                padding: 0.5rem 0;
                margin: 0;
                scrollbar-width: thin; /* For Firefox */
            }

            /* Hide scrollbar in WebKit browsers */
            .flex-control-thumbs::-webkit-scrollbar {
                height: 6px;
            }

            .flex-control-thumbs::-webkit-scrollbar-thumb {
                background-color: #ccc;
                border-radius: 3px;
            }

            .flex-control-thumbs li {
                flex: 0 0 auto;
                width: 80px;
                height: 80px;
                overflow: hidden;
                border-radius: 4px;
            }

            .flex-control-thumbs img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                cursor: pointer;
                border: 2px solid transparent;
                transition: border-color 0.3s;
            }

            .flex-control-thumbs img.flex-active {
                border-color: #0d6efd;
            }
        </style>

    @endpush

    <!--Product Details Start-->
    <section class="product-details">
        <div class="container pb-70">
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    {{-- Main FlexSlider --}}
                    <div id="product-slider" class="flexslider">
                        <ul class="slides mb-3">
                            {{-- Featured Image --}}
                            <li data-thumb="{{ asset($product->featuredImage) }}">
                                <div class="position-relative w-100" style="height: 400px; overflow: hidden;">
                                    <img src="{{ asset($product->featuredImage) }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover;"
                                         alt="Featured Image" />
                                </div>
                            </li>

                            {{-- Product Photos --}}
                            @foreach($product->photos as $photo)
                                <li data-thumb="{{ asset($photo->path) }}">
                                    <div class="position-relative w-100" style="height: 400px; overflow: hidden;">
                                        <img src="{{ asset($photo->path) }}"
                                             class="w-100 h-100"
                                             style="object-fit: cover;"
                                             alt="Product Image" />
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
                <div class="col-lg-6 col-xl-6 product-info">
                    <div class="card p-4 shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <h3 class="product-details__title mb-0">
                                {{ $product->name }}
                            </h3>

                            <div class="text-end">
                                <div>
                                    @php
                                        $comparePrice = $product->compare_price ?? $product->price;
                                        $salePrice = $product->sale_price ?? $product->price;
                                        $percentageOff = $comparePrice > 0 ? round((($comparePrice - $salePrice) / $comparePrice) * 100) : 0;
                                    @endphp

                                    <span class="text-muted text-decoration-line-through me-2">
                                        {{ getCurrencySign() }}{{ number_format($comparePrice, 2) }}
                                    </span>

                                    <span class="fw-bold fs-5 text-success">
                                        {{ getCurrencySign() }}{{ number_format($salePrice, 2) }}
                                    </span>

                                    @if($percentageOff > 0)
                                        <span class="badge bg-danger ms-2">
                                            -{{ $percentageOff }}%
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 border-top pt-3">
                            <p class="text-muted mb-1">{!! $product->short_description !!}</p>

                            <p class="mb-1">
                                <strong>Quantity:</strong>
                                @if($product->quantity > 0)
                                    <span class="text-success">{{ $product->quantity }} In Stock</span>
                                @else
                                    <span class="text-danger">Out of Stock</span>
                                @endif
                            </p>

                            <p class="mb-0">
                                <strong>REF:</strong> {{ $product->sku }}
                            </p>
                        </div>
                    </div>

                    <form>
                        <div class="product-details__quantity">
                            <h3 class="product-details__quantity-title">Choose quantity</h3>
                            <div class="quantity-box">
                                <button type="button" class="sub text-white"><i class="fa fa-minus"></i></button>
                                <input type="number" id="1" value="1" name="quantity" min="1"/>
                                <button type="button" class="add text-white"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>


                        <div class="product-details__buttons">
                            <div class="product-details__buttons-1">
                                <button type="submit"  class="theme-btn btn-style-one submit"><span class="btn-title">Add to Cart</span></button>
                            </div>
                        </div>
                    </form>
                    <div class="product-details__social">
                        @auth
                            <div class="container mt-4 p-4 bg-light rounded shadow-sm">
                                <div class="mb-3">
                                    <h5><i class="bi bi-currency-dollar me-2"></i>Make Money</h5>
                                    <p>Copy this link and share on your social media channels</p>

                                    <div class="input-group mb-3">
                                        <input type="text" id="shareLink" class="form-control" value="{{ route('shop.products.details',['slug'=>$product->slug,'id'=>$product->id,'DIST'=>auth()->user()->user_reference]) }}" readonly>
                                        <button class="btn btn-dark" onclick="copyToClipboard()">Copy</button>
                                    </div>

                                    <p>Click the buttons below and share to</p>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-outline-primary rounded-circle" onclick="shareTo('facebook')">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger rounded-circle" onclick="shareTo('google')">
                                            <i class="fa fa-google"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-info rounded-circle" onclick="shareTo('twitter')">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger rounded-circle" onclick="shareTo('pinterest')">
                                            <i class="fa fa-pinterest"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-primary rounded-circle" onclick="shareTo('linkedin')">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Product Details End-->

    <!--Product Description Start-->
    <section class="product-description">
        <div class="container pt-0 pb-90">
            <div class="product-discription">
                <div class="tabs-box">
                    <div class="tab-btn-box text-center">
                        <ul class="tab-btns tab-buttons clearfix">
                            <li class="tab-btn active-btn" data-tab="#tab-1">Description</li>
                            <li class="tab-btn" data-tab="#tab-2">Specifications</li>
                        </ul>
                    </div>
                    <div class="tabs-content">
                        <div class="tab active-tab" id="tab-1">
                            <div class="text">
                                <h3 class="product-description__title">Description</h3>
                                {!! $product->description !!}

                            </div>
                        </div>
                        <div class="tab" id="tab-2">
                            <div class="text">
                                <h3 class="product-description__title">Specifications</h3>
                                {!! $product->specifications !!}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Product Description End-->


    @push('js')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/flexslider.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.7.2/jquery.flexslider-min.js"></script>

        <script>
            $(window).on('load', function () {
                $('#product-slider').flexslider({
                    animation: "slide",
                    controlNav: "thumbnails",
                    directionNav: true,
                    smoothHeight: false,
                    start: function(slider) {
                        scrollThumbIntoView(slider);
                    },
                    after: function(slider) {
                        scrollThumbIntoView(slider);
                    }
                });

                function scrollThumbIntoView(slider) {
                    const $thumbs = $('.flex-control-thumbs li');
                    const $active = $thumbs.eq(slider.currentSlide);
                    const container = $active.parent()[0];
                    if (container && $active.length) {
                        container.scrollTo({
                            left: $active.position().left - 20,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        </script>

        <script>
            function copyToClipboard() {
                const copyText = document.getElementById("shareLink");
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile
                navigator.clipboard.writeText(copyText.value).then(() => {
                    alert("Link copied to clipboard!");
                });
            }

            function shareTo(platform) {
                const link = document.getElementById("shareLink").value;
                let shareUrl = "";

                switch(platform) {
                    case "facebook":
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(link)}`;
                        break;
                    case "twitter":
                        shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(link)}`;
                        break;
                    case "pinterest":
                        shareUrl = `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(link)}`;
                        break;
                    case "linkedin":
                        shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(link)}`;
                        break;
                    case "google": // Deprecated, included for matching UI
                        shareUrl = `https://plus.google.com/share?url=${encodeURIComponent(link)}`;
                        break;
                }

                if (shareUrl) {
                    window.open(shareUrl, '_blank');
                }
            }
        </script>


    @endpush
@endsection
