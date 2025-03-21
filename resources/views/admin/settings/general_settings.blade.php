@extends('admin.layout.base')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <!-- Account -->
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-6">
                    <img
                        src="{{ asset($web->logo) }}"
                        alt="user-avatar"
                        class="d-block w-px-100 h-px-100 rounded"
                        id="uploadedAvatar" />
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input
                                type="file"
                                id="upload"
                                class="account-file-input"
                                hidden
                                accept="image/png, image/jpeg, image/jpg, image/ico, image/svg, image/png" data-logo-url="{{ route('admin.settings.general.logo') }}"/>
                        </label>

                        <div>Allowed JPG, GIF or PNG. Max size of {{ $web->file_upload_max_size }}KB</div>
                    </div>-
                </div>
            </div>
            <div class="card-body pt-4">
                <form id="generalSettingsForm" method="Post" action="{{ route('admin.settings.general.update') }}">
                    <div class="row">
                        <div class="mb-4 col-md-4">
                            <label for="firstName" class="form-label">Company Name</label>
                            <input
                                class="form-control"
                                type="text"
                                id="firstName"
                                name="name"
                                value="{{ $web->name }}"
                                autofocus />
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="email" class="form-label">Support E-mail</label>
                            <input
                                class="form-control"
                                type="text"
                                id="email"
                                name="email"
                                value="{{ $web->support_email }}"
                                placeholder="john.doe@example.com" />
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="checkoutPercentage" class="form-label">Checkout Percentage (%)</label>
                            <input
                                class="form-control"
                                type="number"
                                step="0.01"
                                id="checkoutPercentage"
                                name="checkoutPercentage"
                                value="{{ $web->checkoutPercentage }}"
                                placeholder="50" />
                        </div>
                        <div class="mb-4 col-md-4">
                            <label class="form-label" for="phoneNumber">Support Phone Number</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="tel"
                                    id="phoneNumber"
                                    name="phoneNumber"
                                    class="form-control"
                                    placeholder="202 555 0111"
                                    value="{{ $web->support_phone }}"
                                />
                            </div>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="lastName" class="form-label">Company Registration Number</label>
                            <input class="form-control" type="text" name="registrationNumber" id="lastName" value="{{ $web->registration_number }}" />
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="organization" class="form-label">Maximum File Upload (MB)</label>
                            <input
                                type="number"
                                class="form-control"
                                id="organization"
                                name="maxFileUploadSize"
                                value="{{ $web->file_upload_max_size/1024 }}" />
                            <small>
                                Maximum file size supported on server: {{ getServerLimitInKB()/1024 }}MB
                            </small>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="organization" class="form-label">Currency</label>
                            <select
                                class="form-control"
                                id="organization"
                                name="currency" >
                                <option value="">Select currency</option>
                                @foreach($currencies as $currency)
                                   <option value="{{ $currency->currency }}" {{ $currency->currency==$web->currency?'selected':'' }}>{{ $currency->currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-md-4">
                            <label for="organization" class="form-label">Site Favicon</label>
                            <input
                                type="file"
                                class="form-control"
                                id="organization"
                                name="favicon"/>
                            <small>
                                Maximum file size supported : {{ $web->file_upload_max_size/1024 }}MB
                            </small>
                        </div>

                        <div class="mb-4 col-md-4">
                            <label for="organization" class="form-label">Affiliate Commission (%)</label>
                            <input
                                type="number"
                                class="form-control"
                                id="organization"
                                name="affiliate_bonus"
                                value="{{ $web->affiliate_bonus }}" />
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="exampleFormControlTextarea1" class="form-label">Company Address</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                            name="address">{{ $web->address }}</textarea>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" >Terms & Conditions<sup class="text-danger">*</sup></label>
                            <textarea
                                type="text"
                                class="form-control summernote"
                                placeholder="Terms & Conditions"
                                name="terms"
                                aria-label="Post title">{!! $web->terms !!}</textarea>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" >Privacy Policy<sup class="text-danger">*</sup></label>
                            <textarea
                                type="text"
                                class="form-control summernote"
                                placeholder="Privacy Policy"
                                name="privacy"
                                aria-label="Post title">{!! $web->privacy !!}</textarea>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" >Return & Refund Policy<sup class="text-danger">*</sup></label>
                            <textarea
                                type="text"
                                class="form-control summernote"
                                placeholder="Return & Refund Policy"
                                name="refund"
                                aria-label="Post title">{!! $web->refund !!}</textarea>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" >Shipping Policy<sup class="text-danger">*</sup></label>
                            <textarea
                                type="text"
                                class="form-control summernote"
                                placeholder="Shipping Policy"
                                name="shipping"
                                aria-label="Post title">{!! $web->shipping !!}</textarea>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" >Field Support  Engineers Terms & Conditions<sup class="text-danger">*</sup></label>
                            <textarea
                                type="text"
                                class="form-control summernote"
                                placeholder="Field Support  Engineers Terms & Conditions"
                                name="engineers_terms"
                                aria-label="Post title">{!! $web->engineers !!}</textarea>
                        </div>

                        <div class="mb-4 col-md-12">
                            <label for="organization" class="form-label">Field Support  Engineers Terms & Conditions Document</label>
                            <input
                                type="file"
                                class="form-control"
                                id="organization"
                                name="engineers_document"/>
                            <small>
                                Maximum file size supported : {{ $web->file_upload_max_size/1024 }}MB
                            </small>
                        </div>
                        <div class="mb-4 col-md-12">
                            <label for="organization" class="form-label">Footer Section</label>
                            <textarea
                                type="text"
                                class="form-control"
                                placeholder="Footer Section"
                                name="footer_codes" rows="10"
                                aria-label="Post title">{!! $web->footer_codes !!}</textarea>
                            <small>
                                Use this to inject scripts to your website footer. Take great care to ensure you are entering the right codes.
                            </small>
                        </div>

                        <div class="mb-4 col-md-12">
                            <label for="organization" class="form-label">Header Section</label>
                            <textarea
                                type="text"
                                class="form-control"
                                placeholder="Header Section" rows="10"
                                name="header_codes"
                                aria-label="Post title">{!! $web->header_codes !!}</textarea>
                            <small>
                                This allows you to inject codes before the closing head tag
                            </small>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="oemRegistration"
                                name="oem_registration" {{ ($web->oem_registration)?'checked':'' }}
                                value="{{$web->oem_registration}}"/>
                                <label class="form-check-label" for="oemRegistration"
                                >Allow OEM Registration</label
                                >
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="engineerRegistration"
                                name="engineer_registration" {{ ($web->engineer_registration)?'checked':'' }}
                                value="{{ $web->engineer_registration }}"/>
                                <label class="form-check-label" for="engineerRegistration"
                                >Allow Engineer Registration</label
                                >
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="customRegistration"
                                name="customer_registration" {{ ($web->customer_registration)?'checked':'' }}
                                value="{{ $web->customer_registration }}"/>
                                <label class="form-check-label" for="customRegistration"
                                >Allow Customer Registration</label
                                >
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="affiliateRegistration"
                                name="affiliate_registration" {{ ($web->affiliate_registration)?'checked':'' }}
                                value="{{ $web->affiliate_registration }}"/>
                                <label class="form-check-label" for="affiliateRegistration"
                                >Allow Affiliate Registration</label
                                >
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="onlineCheckout"
                                name="online_checkout" {{ ($web->online_checkout)?'checked':'' }}
                                value="{{ $web->online_checkout }}"/>
                                <label class="form-check-label" for="onlineCheckout"
                                >{{ $web->online_checkout?'Deactivate':'Activate' }} Online Checkout</label
                                >
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="maintenance"
                                name="maintenance_mode" {{ ($web->maintenance_mode)?'checked':'' }}
                                value="{{ $web->maintenance_mode }}"/>
                                <label class="form-check-label" for="maintenance"
                                >{{ $web->maintenance_mode?'Deactivate':'Activate' }} Maintenance Mode <i class="fa fa-info-circle"
                                    data-bs-toggle="tooltip" title="When activated, only the admin route will be active, every other
                                    route will return a HTTP 403 - maintenance mode error."></i> </label
                                >
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="onlinePayout"
                                name="onlinePayout" {{ ($web->onlinePayout)?'checked':'' }}
                                value="{{ $web->onlinePayout }}"/>
                                <label class="form-check-label" for="onlinePayout"
                                >{{ $web->onlinePayout?'Deactivate':'Activate' }} Online Payout <i class="fa fa-info-circle"
                                    data-bs-toggle="tooltip" title="When activated, affiliates payout requests will be processed online through the payment
                                    processor once payout is approved."></i> </label
                                >
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="autoReferral"
                                name="autoReferral" {{ ($web->autoReferral)?'checked':'' }}
                                value="{{ $web->autoReferral }}"/>
                                <label class="form-check-label" for="autoReferral"
                                >{{ $web->autoReferral?'Deactivate':'Activate' }} Auto Referral Commission <i class="fa fa-info-circle"
                                    data-bs-toggle="tooltip" title="When activated, affiliates will be credited the referral commission
                                    which has been set above automatically"></i> </label
                                >
                            </div>
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label" for="phoneNumber">Enter your password to proceed</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="phoneNumber"
                                    name="password"
                                    class="form-control"
                                />
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                           @if($user->two_factor)
                                <label class="form-label" for="phoneNumber">Enter the code in your authenticator</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="phoneNumber"
                                        name="otp"
                                        class="form-control"
                                        minlength="6"
                                        maxlength="6"
                                    />
                                </div>
                            @else
                                <label class="form-label" for="phoneNumber">
                                    Two-factor Authentication
                                </label>
                                <p class="w-75 text-danger">
                                    You cannot make changes to these settings until you activate your two-factor
                                    authentication. Two-factor authentication adds an additional layer of security to your account by requiring more
                                    than just a password to log in or make crucial updates
                                    <a href="{{ route('admin.account.settings.security') }}">Set up</a>
                                </p>
                           @endif
                        </div>

                    </div>
                    <div class="mt-2 text-center">
                        <button type="submit" class="btn btn-primary me-3 submit"
                        {{ !$user->two_factor?'disabled':'' }}>Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>

    @push('js')
        <script src="{{ asset('dashboard/requests/admin/logo-upload.js') }}"></script>
        <script src="{{ asset('dashboard/js/pages-account-settings-account.js') }}"></script>
        <script src="{{ asset('dashboard/requests/admin/general_settings.js') }}"></script>
    @endpush
@endsection
