@extends('admin.layout.base')
@section('content')
    @push('css')
        <!-- Page CSS -->
        <link rel="stylesheet" href="{{ asset('dashboard/vendor/css/pages/page-profile.css') }}" />
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="user-profile-header-banner">
                        <img src="{{ asset('dashboard/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top" />
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            <img
                                src="https://ui-avatars.com/api/?name={{$user->name}}&background=random"
                                alt="user image"
                                class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                        </div>
                        <div class="flex-grow-1 mt-3 mt-lg-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 mt-lg-6">{{ $user->name }}</h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                            <i class="ti ti-palette ti-lg"></i><span class="fw-medium">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </li>
                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                            <i class="ti ti-calendar ti-lg"></i><span class="fw-medium"> Joined {{ $user->created_at->format('d F Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5">
                <!-- About User -->
                <div class="card mb-6">
                    <div class="card-body">
                        <small class="card-text text-uppercase text-muted small">About</small>
                        <ul class="list-unstyled my-3 py-1">
                            <li class="d-flex align-items-center mb-4">
                                <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Full Name:</span>
                                <span>{{ $user->name }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-4">
                                <i class="ti ti-check ti-lg"></i><span class="fw-medium mx-2">Status:</span>
                                <span>{{ $user->is_active?'Active':'Inactive' }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-4">
                                <i class="ti ti-crown ti-lg"></i><span class="fw-medium mx-2">Role:</span>
                                <span>{{ ucfirst($user->role) }}</span>
                            </li>
                        </ul>
                        <small class="card-text text-uppercase text-muted small">Contacts</small>
                        <ul class="list-unstyled my-3 py-1">
                            <li class="d-flex align-items-center mb-4">
                                <i class="ti ti-phone-call ti-lg"></i><span class="fw-medium mx-2">Contact:</span>
                                <span>{{ $user->phone_number }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-4">
                                <i class="ti ti-mail ti-lg"></i><span class="fw-medium mx-2">Email:</span>
                                <span>{{ $user->email }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--/ About User -->
            </div>
        </div>

    </div>


@endsection
