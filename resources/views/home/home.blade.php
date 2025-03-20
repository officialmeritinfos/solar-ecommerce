@extends('home.layout.base')
@section('content')


    <!-- banner two swiper start -->
    <div class="banner-two-swiper-start">
        <div class="swiper mySwiper-banner-2">
            <div class="swiper-wrapper">

                @foreach(homeSliders() as $slider)
                    <div class="swiper-slide">
                        <!-- single swiper style -->
                        <div class="banner-two-main-wrapper-solaric" style="background-image: url({{ asset($slider->photo) }});">
                            <span class="water-text images">{{ $slider->background_text }}</span>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="banner-solari-2-content ptb--200 ptb_sm--130">
                                            <span class="pre"> <span>Welcome</span> To {{ $siteName }}</span>
                                            <h1 class="banner-title">
                                                {{ $slider->title }}
                                            </h1>
                                            <p class="disc">
                                                {!! $slider->description !!}
                                            </p>
                                            <div class="button-solari-banner-area">
                                                <a href="{{ $slider->link_url??route('shop') }}" class="rts-btn btn-primary">{{ $slider->link_text??'Shop' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- single swiper style end -->
                    </div>
                @endforeach

            </div>
            <div class="swiper-pagination-b2"></div>
            <!-- <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div> -->
        </div>
    </div>
    <!-- banner two swiper end -->

    <!-- rts service area start -->
    <div class="rts-secvice-area-solaric-banner-bottom start rts-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-center title-g">
                        <p class="pre">
                            <span>MAIN</span> CATEGORY
                        </p>
                        <h2 class="title">
                            MAIN CATEGORY
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row g-24">
                @foreach(getCategories() as $category)
                    <div class="col-lg-3 col-md-6 cols-md-12 col-12" >
                        <!-- single service aarea start -->
                        <div class="single-service-solari" style="background-image: url({{ $category->image??asset('home/images/service/19.png') }});">
                            <div class="icon-area">
                                <img src="{{ $category->image??asset('home/images/service/19.png') }}" width="60" height="60" />

                            </div>
                            <a href="{{ route('shop.category.products',$category->slug) }}">
                                <h5 class="title">{{ $category->name }}</h5>
                            </a>
                            <p class="disc">
                                {{ $category->description }}
                            </p>
                        </div>
                        <!-- single service aarea end -->
                    </div>
                @endforeach

                <div class="col-lg-3 col-md-6 cols-md-12 col-12">
                    <!-- single service aarea start -->
                    <div class="single-service-solari four">
                        <div class="icon-area">

                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="30" cy="30" r="29.5" stroke="#E9E9E9" />
                                <path d="M30.7778 37.6112C30.8644 38.3254 30.6734 38.9772 30.2253 39.4961C29.6954 40.1099 28.8123 40.5206 27.8079 40.6337V41.4041C27.8079 41.7247 27.5483 41.9847 27.2282 41.9847C26.9081 41.9847 26.6485 41.7247 26.6485 41.4041V40.6254C25.1636 40.4254 24.0087 39.4877 23.6751 38.1475C23.5977 37.8364 23.7867 37.5212 24.0973 37.4437C24.4082 37.3665 24.7226 37.5555 24.8001 37.8666C25.0984 39.065 26.2674 39.494 27.2251 39.5036C27.2302 39.5036 27.2354 39.5037 27.2404 39.5038C27.2726 39.5036 27.3045 39.5036 27.3361 39.5028C28.1738 39.4829 28.9637 39.182 29.3484 38.7364C29.5832 38.4645 29.6743 38.1422 29.6269 37.7511C29.515 36.8282 28.7489 36.2988 27.1428 36.0347C24.6082 35.6179 24.0181 34.3323 23.9695 33.3272C23.902 31.9343 24.876 30.7668 26.3933 30.4221C26.4768 30.4031 26.5621 30.3869 26.6485 30.3736V29.5866C26.6485 29.2659 26.9081 29.0059 27.2282 29.0059C27.5483 29.0059 27.8079 29.2659 27.8079 29.5866V30.3686C28.8959 30.5264 29.9711 31.155 30.5071 32.4341C30.6311 32.7297 30.4923 33.0701 30.1971 33.1942C29.9019 33.3184 29.5621 33.1793 29.4382 32.8836C29.0218 31.8903 28.1308 31.487 27.271 31.4856C27.2473 31.4874 27.2228 31.4875 27.1988 31.4865C27.0118 31.491 26.8271 31.5144 26.6497 31.5547C25.8821 31.729 25.0791 32.2715 25.1275 33.2709C25.1427 33.584 25.1888 34.5366 27.3306 34.8888C28.1172 35.0182 30.5112 35.4118 30.7778 37.6112ZM44.767 41.2577L39.3435 47.6559C39.1554 47.8778 38.8919 47.9999 38.6013 47.9999C38.3108 47.9999 38.0472 47.8777 37.8592 47.656L35.6892 45.096C33.4534 46.9768 30.5715 48 27.4874 48C27.412 48 27.3367 47.9993 27.261 47.9982C27.1873 47.9994 27.1128 47.9999 27.0392 47.9999C22.5695 48.0001 18.5101 45.8121 16.404 42.2523C14.4928 39.0221 14.5346 35.1681 16.5186 31.6788C17.7604 29.4948 19.6623 27.0218 22.4681 23.9474C21.6712 23.5843 21.1154 22.7798 21.1154 21.8472C21.1154 20.5941 22.1187 19.5718 23.363 19.5424L21.5303 17.7068C20.614 16.7889 20.614 15.2955 21.5303 14.3777C22.3059 13.6008 23.5392 13.4682 24.4629 14.062C24.5621 14.1257 24.6592 14.1345 24.7682 14.0893C24.877 14.0442 24.9395 13.9693 24.9646 13.8539C25.1987 12.7798 26.1644 12.0001 27.2609 12C28.3575 12 29.3233 12.7796 29.5575 13.8537C29.5827 13.9693 29.6451 14.0442 29.7541 14.0894C29.8629 14.1345 29.9599 14.1257 30.0592 14.062C30.9829 13.4682 32.2161 13.6008 32.9917 14.3777C33.9081 15.2956 33.9081 16.7891 32.9918 17.7069L31.1592 19.5424C32.4034 19.572 33.4067 20.5942 33.4067 21.8474C33.4067 22.7799 32.8509 23.5844 32.054 23.9474C33.2361 25.2428 34.2544 26.4285 35.1307 27.5298C35.1958 26.8346 35.7811 26.2886 36.4917 26.2886H40.711C41.4651 26.2887 42.0786 26.9032 42.0785 27.6585V39.6516H44.0249C44.4088 39.6516 44.7474 39.8684 44.9084 40.2173C45.0695 40.5659 45.0154 40.9646 44.767 41.2577ZM22.3501 16.8856L25.0012 19.5409H29.5211L32.172 16.8856C32.6363 16.4205 32.6363 15.6639 32.172 15.1988C31.7791 14.8052 31.1539 14.7381 30.6855 15.0392C30.2688 15.3071 29.7675 15.3519 29.3104 15.1621C28.8531 14.9724 28.5304 14.5858 28.4248 14.1014C28.3061 13.5567 27.8166 13.1613 27.261 13.1613C26.7055 13.1614 26.2161 13.5568 26.0974 14.1014C25.9918 14.5858 25.669 14.9725 25.2117 15.1622C24.7544 15.3518 24.2532 15.307 23.8367 15.0393C23.3682 14.7381 22.743 14.8052 22.35 15.1988C21.8857 15.6639 21.8857 16.4206 22.3501 16.8856ZM22.2748 21.8472C22.2748 22.4786 22.7876 22.9923 23.4179 22.9923H31.1041C31.7344 22.9923 32.2472 22.4786 32.2472 21.8473C32.2472 21.2159 31.7344 20.7023 31.1041 20.7023H23.4179C22.7876 20.7022 22.2748 21.2159 22.2748 21.8472ZM34.9389 44.2109L32.4357 41.2578C32.1872 40.9645 32.1332 40.5657 32.2943 40.2169C32.4554 39.8681 32.794 39.6513 33.1779 39.6513H35.1242V29.4233C33.9731 27.872 32.5117 26.1443 30.6669 24.1536H23.8548C20.8147 27.4342 18.8003 30.0124 17.526 32.2536C15.7277 35.4161 15.6835 38.7569 17.4012 41.6603C19.3318 44.9234 23.1071 46.9064 27.2512 46.837C27.2577 46.8368 27.2642 46.8368 27.2707 46.837C30.1609 46.8865 32.861 45.9568 34.9389 44.2109ZM38.4601 46.9038C38.4599 46.904 38.4598 46.9042 38.4597 46.9043L38.4601 46.9038ZM43.6234 40.8127H41.4988C41.1787 40.8127 40.9191 40.5527 40.9191 40.2321V27.6583C40.9191 27.5452 40.8239 27.4497 40.711 27.4497H36.4917C36.3789 27.4497 36.2836 27.5452 36.2836 27.6583V40.232C36.2836 40.5526 36.024 40.8126 35.7039 40.8126H33.5793L38.6014 46.7372L43.6234 40.8127Z" fill="#1F1F25" />
                            </svg>

                        </div>
                        <a href="{{ route('shop') }}">
                            <h5 class="title">Shop</h5>
                        </a>
                        <p class="disc">
                            Shop the best from our store
                        </p>
                    </div>
                    <!-- single service aarea end -->
                </div>
            </div>
        </div>
    </div>
    <!-- rts service area end -->

    <div class="shopping-area-start rts-section-gap mb_dec-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-shop-main-center">
                        <h2 class="title">Our Recent
                            <span class="draw">
                                Product
                                <svg width="157" height="18" viewBox="0 0 157 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="wow" d="M1 16.569C35.3333 3.73568 107.7 -4.03506 156.5 7.96494" stroke="#4AAB3D" stroke-width="3"/>
                                </svg>
                            </span>
                        </h2>
                        <p class="disc">
                            Welcome to our Solar Shop, your one-stop destination <br> for all your solar energy needs.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-24 mt-5">
                @foreach(homeProducts() as $product)
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
        </div>
    </div>


    @if(useCaseSolutions()->count() >0)
        <!-- service heign area start -->
        <div class="rts-service-area-height-solari rts-section-gap position-relative">
        <span class="stok-bg images-r">
           SERVICE & SOLUTIONS
        </span>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title-area-center">
                            <p class="pre  skew-up">
                                <span> SERVICE & </span> SOLUTIONS
                            </p>
                            <h2 class="title  skew-up">
                                SERVICE & SOLUTIONS
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row g-24 mt--20">
                    @foreach(useCaseSolutions() as $solution)
                        <div class="col-xl-3 col-lg-4 col-sm-6 col-sm-6 col-12">
                            <!-- ignle service height solari -->
                            <div class="single-solari-service-start">
                                <div class="icon-area">
                                    @if($solution->photo)
                                        <img src="{{ asset($solution->photo) }}" width="47" height="47"/>
                                    @else
                                        <svg width="47" height="47" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M36.0892 5.03606C32.8467 5.03606 30.2142 7.66861 30.2142 10.911C30.2142 14.1535 32.8467 16.786 36.0892 16.786C39.3316 16.786 41.9641 14.1535 41.9641 10.911C41.9641 7.66861 39.3316 5.03606 36.0892 5.03606ZM36.0892 6.71463C38.405 6.71463 40.2855 8.59518 40.2855 10.911C40.2855 13.2269 38.405 15.1074 36.0892 15.1074C33.7733 15.1074 31.8928 13.2269 31.8928 10.911C31.8928 8.59518 33.7733 6.71463 36.0892 6.71463Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M36.9282 20.9823V19.3037C36.9282 18.8404 36.5521 18.4644 36.0889 18.4644C35.6257 18.4644 35.2496 18.8404 35.2496 19.3037V20.9823C35.2496 21.4456 35.6257 21.8216 36.0889 21.8216C36.5521 21.8216 36.9282 21.4456 36.9282 20.9823Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M44.2359 17.8711L42.5573 16.1925C42.2298 15.8652 41.6979 15.8652 41.3703 16.1925C41.0428 16.5198 41.0428 17.0519 41.3703 17.3793L43.0489 19.0578C43.3765 19.3851 43.9083 19.3851 44.2359 19.0578C44.5634 18.7305 44.5634 18.1984 44.2359 17.8711Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M46.1607 10.0716H44.4822C44.019 10.0716 43.6429 10.4476 43.6429 10.9109C43.6429 11.3742 44.019 11.7502 44.4822 11.7502H46.1607C46.6239 11.7502 47 11.3742 47 10.9109C47 10.4476 46.6239 10.0716 46.1607 10.0716Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M43.0489 2.76402L41.3703 4.44258C41.0428 4.7699 41.0428 5.302 41.3703 5.62932C41.6979 5.95664 42.2298 5.95664 42.5573 5.62932L44.2359 3.95076C44.5634 3.62344 44.5634 3.09134 44.2359 2.76402C43.9083 2.4367 43.3765 2.4367 43.0489 2.76402Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M30.8074 4.44258L29.1289 2.76402C28.8013 2.4367 28.2694 2.4367 27.9419 2.76402C27.6144 3.09134 27.6144 3.62344 27.9419 3.95076L29.6204 5.62932C29.948 5.95664 30.4799 5.95664 30.8074 5.62932C31.1349 5.302 31.1349 4.7699 30.8074 4.44258Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M35.2496 0.839403V2.51793C35.2496 2.98123 35.6257 3.35734 36.0889 3.35734C36.5521 3.35734 36.9282 2.98123 36.9282 2.51793V0.839403C36.9282 0.376103 36.5521 0 36.0889 0C35.6257 0 35.2496 0.376103 35.2496 0.839403Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M29.6204 16.1925L27.9419 17.8711C27.6144 18.1984 27.6144 18.7305 27.9419 19.0578C28.2694 19.3851 28.8013 19.3851 29.1289 19.0578L30.8074 17.3793C31.1349 17.0519 31.1349 16.5198 30.8074 16.1925C30.4799 15.8652 29.948 15.8652 29.6204 16.1925Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M27.6966 10.0716H26.018C25.5548 10.0716 25.1788 10.4476 25.1788 10.9109C25.1788 11.3742 25.5548 11.7502 26.018 11.7502H27.6966C28.1598 11.7502 28.5359 11.3742 28.5359 10.9109C28.5359 10.4476 28.1598 10.0716 27.6966 10.0716Z" fill="#4AAB3D" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2.28206 25.1787L0.0252364 16.1505C-0.0377095 15.8996 0.0185219 15.6336 0.177985 15.4304C0.336608 15.2265 0.580839 15.1073 0.839336 15.1073H26.0177C26.481 15.1073 26.857 15.4833 26.857 15.9466C26.857 16.4099 26.481 16.7859 26.0177 16.7859H19.5393L21.6375 25.1787H29.1398L28.3509 22.0255C28.2384 21.5757 28.512 21.1199 28.9619 21.0075C29.4109 20.895 29.8675 21.1686 29.9799 21.6176L30.8696 25.1787H37.5318L37.3731 24.5434C37.2607 24.0935 37.5343 23.6378 37.9833 23.5253C38.4331 23.4128 38.8889 23.6865 39.0013 24.1355L39.2624 25.1787H40.2854C40.7487 25.1787 41.1247 25.5547 41.1247 26.018C41.1247 26.4813 40.7487 26.8573 40.2854 26.8573H39.682L41.9388 35.8854C42.0018 36.1363 41.9455 36.4024 41.7861 36.6055C41.6274 36.8095 41.3832 36.9286 41.1247 36.9286H24.3391V45.3214H46.1604C46.6237 45.3214 46.9997 45.6974 46.9997 46.1607C46.9997 46.624 46.6237 47 46.1604 47H0.839336C0.376055 47 5.78268e-05 46.624 5.78268e-05 46.1607C5.78268e-05 45.6974 0.376055 45.3214 0.839336 45.3214H17.6249V36.9286H5.87501C5.48978 36.9286 5.15407 36.6668 5.06091 36.2933L2.7017 26.8573H1.67862C1.21533 26.8573 0.839336 26.4813 0.839336 26.018C0.839336 25.5547 1.21533 25.1787 1.67862 25.1787H2.28206ZM19.3035 36.9286V45.3214H22.6606V36.9286H19.3035ZM13.1927 35.2501L11.0945 26.8573H4.43229L6.53048 35.2501H13.1927ZM12.8251 26.8573L14.9233 35.2501H22.4247L20.3265 26.8573H12.8251ZM22.0571 26.8573L24.1553 35.2501H31.6568L29.5586 26.8573H22.0571ZM37.9514 26.8573H31.2892L33.3874 35.2501H40.0496L37.9514 26.8573ZM1.91445 16.7859L4.01265 25.1787H10.6757L8.57749 16.7859H1.91445ZM10.3072 16.7859L12.4054 25.1787H19.9077L17.8095 16.7859H10.3072Z" fill="#4AAB3D" />
                                        </svg>
                                    @endif
                                </div>
                                <a href="{{ route('home.solutions') }}">
                                    <h5 class="title">{{ $solution->title }}</h5>
                                </a>
                                <p class="disc">
                                    {!! \Illuminate\Support\Str::words($solution->contents, 30) !!}
                                </p>
                                <a href="{{ route('home.solutions.details', $solution->id) }}" class="read-more-btn">Read More<i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                            <!-- ignle service height solari end -->
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- service heign area end -->
    @endif



    <!-- rts- clients review area start -->
    <div class="rts-client-review-area-h2 rts-section-gapBottom">
        <div class="container">
            <div class="row mt--120 g-5">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <!-- single cpounter up area start -->
                    <div class="single-counter-up-start-solari">
                        <div class="bg-text">80+</div>
                        <div class="main-content">
                            <h2 class="title"><span class="counter">80</span>+</h2>
                            <p>Team Member</p>
                        </div>
                    </div>
                    <!-- single cpounter up area end -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <!-- single cpounter up area start -->
                    <div class="single-counter-up-start-solari">
                        <div class="bg-text">15k</div>
                        <div class="main-content">
                            <h2 class="title"><span class="counter">15</span>K</h2>
                            <p>Work Have Done</p>
                        </div>
                    </div>
                    <!-- single cpounter up area end -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <!-- single cpounter up area start -->
                    <div class="single-counter-up-start-solari">
                        <div class="bg-text">93K</div>
                        <div class="main-content">
                            <h2 class="title"><span class="counter">93</span>K</h2>
                            <p>Happy Clients</p>
                        </div>
                    </div>
                    <!-- single cpounter up area end -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <!-- single cpounter up area start -->
                    <div class="single-counter-up-start-solari">
                        <div class="bg-text">18</div>
                        <div class="main-content">
                            <h2 class="title"><span class="counter">18</span>K</h2>
                            <p>Award Winnings</p>
                        </div>
                    </div>
                    <!-- single cpounter up area end -->
                </div>
            </div>
        </div>
        <div class="shape-author-img images">
            <img src="{{ asset('home/images/testimonials/09.png') }}" alt="">
        </div>
        <div class="shape-author-img-2 images-r">
            <img src="{{ asset('home/images/testimonials/10.png') }}" alt="">
        </div>
    </div>
    <!-- rts- clients review area end -->



    <!-- rts blog area start -->
    <div class="rts-solari-blog-area-start rts-section-gap reveal" id="blog">
        <span class="stok-bg images-r">
            Our Blog
        </span>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-center">
                        <p class="pre skew-up">
                            <span> Our </span> Blog
                        </p>
                        <h2 class="title skew-up">
                            Our Latest Blog
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row g-24 mt--30 justify-content-center">
                <div class="col-lg-6">
                    <div class="single-blog-solaric-sm">
                        <a href="#" class="thumbnail">
                            <img src="{{ asset('home/images/blog/26.jpg') }}" alt="blog-area">
                        </a>
                        <div class="inner-content-solari-blog">
                            <div class="head">
                                <div class="single">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>25 Jan, 2022</span>
                                </div>
                                <div class="single">
                                    <i class="fa-regular fa-user"></i>
                                    <span>25 Jan, 2022</span>
                                </div>
                            </div>
                            <div class="body">
                                <a href="#">
                                    <h5 class="title">2019 Gattermann Award wind <br> honors Brad Burkhart Meyer</h5>
                                </a>
                                <a href="blog-details" class="rts-btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
