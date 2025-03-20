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

    <!-- rts footer contact info area start -->
    <div class="rts-contact-info-area rts-section-gap">
        <div class="container">
            <div class="row g-24">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-contact--info-wrapper">
                        <div class="thumbnail">
                            <img src="{{ asset('home/images/footer/03.jpg') }}" alt="img">
                            <div class="icon">
                                <svg width="33" height="34" viewBox="0 0 33 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M31.9688 12.5C31.3887 12.5 30.9375 13.0156 30.9375 13.5312V30.0312C30.9375 30.6113 30.4219 31.0625 29.9062 31.0625H3.09375C2.51367 31.0625 2.0625 30.6113 2.0625 30.0312V13.5312C2.0625 13.0156 1.54688 12.5 1.03125 12.5C0.451172 12.5 0 13.0156 0 13.5312V30.0312C0 31.7715 1.35352 33.125 3.09375 33.125H29.9062C31.582 33.125 33 31.7715 33 30.0957V13.5312C33 13.0156 32.4844 12.5 31.9688 12.5ZM4.125 17.9785C4.18945 18.043 4.18945 18.1074 4.18945 18.1719C4.25391 18.2363 4.25391 18.2363 4.31836 18.3008C4.38281 18.3652 4.38281 18.4297 4.44727 18.4941C4.51172 18.4941 4.51172 18.4941 4.51172 18.4941L13.084 24.8105C14.0508 25.5195 15.2109 25.9062 16.5 25.9062C17.7246 25.9062 18.8848 25.5195 19.8516 24.7461L28.4238 18.4297C28.4238 18.4297 28.4238 18.4297 28.4883 18.4297C28.5527 18.3652 28.5527 18.3008 28.6172 18.2363C28.6816 18.1719 28.6816 18.1719 28.7461 18.1074C28.7461 18.043 28.7461 17.9785 28.8105 17.9141C28.8105 17.8496 28.8105 17.7852 28.8105 17.7207C28.8105 17.7207 28.875 17.7207 28.875 17.6562V3.21875C28.875 1.54297 27.457 0.125 25.7812 0.125H7.21875C5.47852 0.125 4.125 1.54297 4.125 3.21875V17.6562C4.125 17.7207 4.125 17.7207 4.125 17.7852C4.125 17.8496 4.125 17.9141 4.125 17.9785ZM6.1875 3.21875C6.1875 2.70312 6.63867 2.1875 7.21875 2.1875H25.7812C26.2969 2.1875 26.8125 2.70312 26.8125 3.21875V17.1406L18.627 23.1348C17.3379 24.1016 15.5977 24.1016 14.3086 23.1348L6.1875 17.1406V3.21875ZM22.6875 15.5938C22.6875 15.0137 22.1719 14.5625 21.6562 14.5625H11.3438C10.7637 14.5625 10.3125 15.0137 10.3125 15.5938C10.3125 16.1094 10.7637 16.5605 11.3438 16.5605H21.6562C22.1719 16.625 22.6875 16.1738 22.6875 15.5938ZM11.3438 10.4375H21.6562C22.1719 10.4375 22.6875 9.92188 22.6875 9.40625C22.6875 8.89062 22.1719 8.43945 21.6562 8.43945H11.3438C10.7637 8.43945 10.3125 8.95508 10.3125 9.40625C10.3125 9.98633 10.7637 10.4375 11.3438 10.4375Z" fill="#FD8F14" />
                                </svg>
                            </div>
                        </div>
                        <div class="content">
                            <span>Get an email</span>
                            <a href="mailto:{{ $web->support_email }}">
                                <h5 class="title under-line">{{ $web->support_email }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-contact--info-wrapper">
                        <div class="thumbnail">
                            <img src="{{ asset('home/images/footer/04.jpg') }}" alt="img">
                            <div class="icon">

                                <svg width="33" height="34" viewBox="0 0 33 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.9062 12.5H11.3438C10.957 12.5 10.6348 12.6289 10.3125 12.6934V4.25C10.3125 3.1543 11.2148 2.1875 12.375 2.1875H26.3613L28.875 4.70117V9.40625C28.875 9.98633 29.3262 10.4375 29.9062 10.4375C30.4219 10.4375 30.9375 9.98633 30.9375 9.40625V4.70117C30.9375 4.18555 30.6797 3.60547 30.293 3.21875L27.8438 0.769531C27.3926 0.382812 26.877 0.125 26.3613 0.125H12.375C10.0547 0.125 8.25 1.99414 8.25 4.25V8.56836C7.86328 8.50391 7.54102 8.375 7.21875 8.375H3.09375C1.35352 8.375 0 9.79297 0 11.4688V30.0312C0 31.7715 1.35352 33.125 3.09375 33.125H7.21875C7.99219 33.125 8.70117 32.8672 9.28125 32.3516C9.79688 32.8672 10.5059 33.125 11.3438 33.125H29.9062C31.582 33.125 33 31.7715 33 30.0312V15.5938C33 13.918 31.582 12.5 29.9062 12.5ZM8.25 30.0312C8.25 30.6113 7.73438 31.0625 7.21875 31.0625H3.09375C2.51367 31.0625 2.0625 30.6113 2.0625 30.0312V11.4688C2.0625 10.9531 2.51367 10.4375 3.09375 10.4375H7.21875C7.73438 10.4375 8.25 10.9531 8.25 11.4688V30.0312ZM30.9375 30.0312C30.9375 30.6113 30.4219 31.0625 29.9062 31.0625H11.3438C10.7637 31.0625 10.3125 30.6113 10.3125 30.0312V15.5938C10.3125 15.0781 10.7637 14.5625 11.3438 14.5625H29.9062C30.4219 14.5625 30.9375 15.0781 30.9375 15.5938V30.0312ZM17.5312 18.1719C16.6289 18.1719 15.9844 18.8809 15.9844 19.7188C15.9844 20.6211 16.6289 21.2656 17.5312 21.2656C18.3691 21.2656 19.0781 20.6211 19.0781 19.7188C19.0781 18.8809 18.3691 18.1719 17.5312 18.1719ZM17.5312 24.3594C16.6289 24.3594 15.9844 25.0684 15.9844 25.9062C15.9844 26.8086 16.6289 27.4531 17.5312 27.4531C18.3691 27.4531 19.0781 26.8086 19.0781 25.9062C19.0781 25.0684 18.3691 24.3594 17.5312 24.3594ZM23.7188 18.1719C22.8164 18.1719 22.1719 18.8809 22.1719 19.7188C22.1719 20.6211 22.8164 21.2656 23.7188 21.2656C24.5566 21.2656 25.2656 20.6211 25.2656 19.7188C25.2656 18.8809 24.5566 18.1719 23.7188 18.1719ZM23.7188 24.3594C22.8164 24.3594 22.1719 25.0684 22.1719 25.9062C22.1719 26.8086 22.8164 27.4531 23.7188 27.4531C24.5566 27.4531 25.2656 26.8086 25.2656 25.9062C25.2656 25.0684 24.5566 24.3594 23.7188 24.3594Z" fill="#FD8F14" />
                                </svg>

                            </div>
                        </div>
                        <div class="content">
                            <span>Make A Call</span>
                            <a href="tel:{{ $web->support_phone }}">
                                <h5 class="title">{{ $web->support_phone }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-contact--info-wrapper">
                        <div class="thumbnail">
                            <img src="{{ asset('home/images/footer/06.jpg') }}" alt="img">
                            <div class="icon">

                                <svg width="38" height="34" viewBox="0 0 38 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.0156 7.34375C17.0156 6.50586 17.6602 5.79688 18.5625 5.79688C19.4004 5.79688 20.1094 6.50586 20.1094 7.34375C20.1094 8.24609 19.4004 8.89062 18.5625 8.89062C17.6602 8.89062 17.0156 8.24609 17.0156 7.34375ZM17.5957 20.2344C15.5332 17.6562 10.8281 11.4043 10.8281 7.85938C10.8281 3.60547 14.2441 0.125 18.5625 0.125C22.8164 0.125 26.2969 3.60547 26.2969 7.85938C26.2969 11.4043 21.5273 17.6562 19.4648 20.2344C19.0137 20.8789 18.0469 20.8789 17.5957 20.2344ZM23.5898 10.1152C24.041 9.08398 24.2344 8.375 24.2344 7.85938C24.2344 4.76562 21.6562 2.1875 18.5625 2.1875C15.4043 2.1875 12.8906 4.76562 12.8906 7.85938C12.8906 8.375 13.0195 9.08398 13.4707 10.1152C13.8574 11.1465 14.502 12.2422 15.1465 13.3379C16.2422 15.1426 17.5312 16.8828 18.5625 18.1719C19.5293 16.8828 20.8184 15.1426 21.9141 13.3379C22.5586 12.2422 23.2031 11.1465 23.5898 10.1152ZM26.1035 14.498C26.1035 14.5625 26.0391 14.5625 25.9746 14.5625C26.4902 13.6602 27.0059 12.6934 27.3926 11.791L34.998 8.76172C35.9648 8.375 37.125 9.08398 37.125 10.1797V27.6465C37.125 28.291 36.7383 28.8711 36.0938 29.0645L26.1035 33.0605C25.9102 33.1895 25.7168 33.1895 25.459 33.125L11.3438 29.0645L2.0625 32.8027C1.0957 33.1895 0 32.4805 0 31.3848V13.918C0 13.2734 0.322266 12.6934 0.966797 12.5L8.89453 9.27734C9.02344 9.98633 9.2168 10.6309 9.47461 11.2754L2.0625 14.2402V30.6113L10.3125 27.3242V19.7188C10.3125 19.2031 10.7637 18.6875 11.3438 18.6875C11.8594 18.6875 12.375 19.2031 12.375 19.7188V27.1953L24.75 30.7402V19.7188C24.75 19.2031 25.2012 18.6875 25.7812 18.6875C26.2969 18.6875 26.8125 19.2031 26.8125 19.7188V30.6113L35.0625 27.3242V10.9531L26.1035 14.498Z" fill="#FD8F14" />
                                </svg>

                            </div>
                        </div>
                        <div class="content">
                            <span>Go for location</span>
                            <a href="https://www.google.com/maps" target="_blank">
                                <h5 class="title">{{ $web->address }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts footer contact info area end -->

    <!-- rts contact form area start  -->
    <div class="rts-contact-wrapper-form-area rts-section-gapBottom">
        <div class="container">
            <div class="row g-24 justify-content-center">
                <div class="col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="form--area">
                        <div class="title-area-left">
                            <p class="pre">
                                <span>Feel Free</span> To Contact Us
                            </p>
                            <h2 class="title">
                                Let’s Get in Touch
                            </h2>
                        </div>
                        <div id="form-messages"></div>
                        <form id="formAuthentication" action="{{ route('home.contact.submit') }}" method="post" class="contact-page-form mt--30">
                            @csrf
                            <div class="name-email-wraper">
                                <input name="name" type="text" placeholder="Your Name" >
                                <input name="email" type="email" placeholder="Email Address" >
                            </div>
                            <input type="text" name="subject" placeholder=" Subject">
                            <textarea name="message" placeholder="Type Your Message" ></textarea>

                            <div class="mb-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" for="repeatPassword">ReCaptcha:</label>
                                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button class="rts-btn btn-primary submit">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts contact form area end  -->

    @push('js')
        <script src="{{ asset('dashboard/requests/auth/register.js') }}"></script>
    @endpush

@endsection
