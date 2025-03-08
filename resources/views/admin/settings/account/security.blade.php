@extends('admin.layout.base')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.settings.account.components.account_settings_menu')

        <!-- Change Password -->
        <div class="card mb-6">
            <h5 class="card-header">Change Password</h5>
            <div class="card-body pt-1">
                <form id="formAccountSettings" method="POST" action="{{ route('admin.account.settings.password.update') }}">
                    <div class="row">
                        <div class="mb-6 col-md-12 form-password-toggle">
                            <label class="form-label" for="currentPassword">Current Password</label>
                            <div class="input-group input-group-merge">
                                <input
                                    class="form-control"
                                    type="password"
                                    name="currentPassword"
                                    id="currentPassword"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-6 col-md-6 form-password-toggle">
                            <label class="form-label" for="newPassword">New Password</label>
                            <div class="input-group input-group-merge">
                                <input
                                    class="form-control"
                                    type="password"
                                    id="newPassword"
                                    name="newPassword"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>

                        <div class="mb-6 col-md-6 form-password-toggle">
                            <label class="form-label" for="confirmPassword">Confirm New Password</label>
                            <div class="input-group input-group-merge">
                                <input
                                    class="form-control"
                                    type="password"
                                    name="newPassword_confirmation"
                                    id="confirmPassword"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="mb-6 col-md-6 form-password-toggle">
                            @if($user->two_factor)
                                <label class="form-label" for="phoneNumber">Enter the code in your authenticator</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="phoneNumber"
                                        name="otp"
                                        class="form-control"
                                        maxlength="6" minlength="6"
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            @else
                                <label class="form-label" for="phoneNumber">
                                    Two-factor Authentication
                                </label>
                                <p class="w-75 text-danger">
                                    You cannot make changes to your password until you activate your two-factor
                                    authentication. Two-factor authentication adds an additional layer of security to your account by requiring more
                                    than just a password to log in or make crucial updates
                                </p>
                            @endif
                        </div>
                        <div class="mb-4 col-md-12">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="maintenance"
                                       name="logout_sessions" value="true" checked/>
                                <label class="form-check-label" for="maintenance"
                                > Logout other Devices
                                    <i class="fa fa-info-circle" data-bs-toggle="tooltip" title="This will logout other sessions except this one. They will
                                    be prompted to re-enter their password"></i> </label
                                >
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3 submit">Save changes</button>
                        <button type="reset" class="btn btn-label-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <!--/ Change Password -->

        <div class="row">
            <!-- Two-steps verification -->
            <div class="{{ $user->two_factor?'col-md-6':'col-md-12' }} d-flex align-items-stretch mt-1">
                <div class="card w-100">
                    <div class="card-body">

                        @if (!$user->two_factor)
                            <h5 class="mb-6">Two-Steps Verification</h5>
                            <!-- Notice Before Enabling 2FA -->
                            <div class="alert alert-warning">
                                <strong>Important:</strong> Once Two-Factor Authentication is set up, it cannot be deactivated.
                            </div>

                            <!-- Message for Users Without 2FA -->
                            <h5 class="mb-4 text-body">Two-Factor Authentication is not enabled yet.</h5>
                            <p class="w-75 mb-8">
                                Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to log in.
                                <a href="https://en.wikipedia.org/wiki/Multi-factor_authentication" target="_blank">Learn more.</a>
                            </p>

                            <!-- Instructions for 2FA Setup -->
                            <p>
                                To enable Two-Factor Authentication (2FA), follow these steps:
                            </p>

                            <ol>
                                <li>Scan the QR code displayed on your screen using an authenticator app (e.g., Google Authenticator, Authy).</li>
                                <li>After scanning, your authenticator app will generate a <b>6-digit verification code</b>.</li>
                                <li>Click the next step button to show a pop-up</li>
                                <li>enter the code in the verification field to complete the setup.</li>
                            </ol>

                            <!-- QR Code Display -->
                            @if (!empty($QR_Image))
                                <div class="text-center mb-4 mt-5">
                                    <h5>Scan this QR Code with your authenticator app:</h5>
                                    <p class="img-fluid border p-2">
                                        {!! $QR_Image !!}
                                        <br/>
                                    </p>
                                    <div class=" mb-2 text-center">
                                        <p>
                                            Alternatively,copy the code below to add to your Authenticator manually:<br/>
                                        </p>
                                        <p class="me-3 mb-0 fw-medium">
                                           <h4> {{ format_code($user->google2fa_secret) }}</h4>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="text-center">
                                <!-- Enable 2FA Button -->
                                <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#enableOTP">
                                    Next Step
                                </button>
                            </div>
                        @else
                            <h4 class="text-success mb-3"><i class="ti ti-lock"></i> Two-Factor Authentication is Active</h4>

                            <p>
                                Your account is now secured with <b>Two-Factor Authentication (2FA)</b>, adding an extra layer of security beyond just your password.
                                With 2FA enabled, you will be required to enter a <b>one-time verification code</b> generated from your <b>authenticator app</b> whenever you log in.
                            </p>

                            <h6 class="text-dark mt-4">How Does This Protect Your Account?</h6>
                            <ul class="mb-4">
                                <li>Even if someone steals your password, they cannot access your account without your verification code.</li>
                                <li>2FA prevents unauthorized access, even in cases of phishing or data breaches.</li>
                                <li>Each login attempt will require a <b>unique, time-sensitive</b> verification code from your authenticator app.</li>
                            </ul>

                            <h6 class="text-dark">Can I Disable Two-Factor Authentication?</h6>
                            <p>
                                <b>No, 2FA cannot be disabled directly from your account settings.</b>
                                For security reasons, <b>the only way to disable 2FA</b> is through the special link that was sent to your email when you activated it.
                                This link will expire after <b>5 years</b>, after which you will need to contact support to disable it manually.
                            </p>

                            <h6 class="text-dark">Didn’t Activate 2FA?</h6>
                            <p>
                                If you did not enable Two-Factor Authentication but received this notification, please contact <b>our support team immediately</b> to investigate and secure your account.
                            </p>

                        @endif
                    </div>

                </div>
            </div>

            @if($user->two_factor)
                <!-- Recovery Phrase -->
                <div class="col-md-6 d-flex align-items-stretch mt-1">
                    <div class="card w-100">
                        <div class="card-body">
                            <h5>Recovery Phrase</h5>
                            <p class="mb-4">
                                Your recovery phrase is a unique key to access your account securely. Keep it safe and do not share it with anyone.
                                Enter your OTP below to reveal your recovery phrase.
                            </p>

                            <!-- Password Input Section -->
                            <div class="mb-6 col-md-12 form-password-toggle">
                                <label for="recoveryPassword" class="form-label">Enter OTP from Authenticator</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" id="recoveryPassword" placeholder="Enter your OTP"
                                    minlength="6" maxlength="6">
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>

                            <!-- Button to Reveal Recovery Phrase -->
                            <div class="text-center">
                                <button class="btn btn-primary mb-4" id="verifyButton" data-recovery-url="{{ route('admin.account.settings.security.recovery-code') }}">
                                    Reveal Recovery Phrase
                                </button>
                            </div>

                            <!-- Recovery Phrase Container (Initially Hidden) -->
                            <div id="recoveryContainer" class="d-none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="bg-light rounded p-4 mb-4 position-relative">
                                            <div class="d-flex align-items-center mb-2">
                                                <h5 class="mb-0 me-3">Recovery Phrase</h5>
                                                <span class="badge bg-success">Secure</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <p id="recoveryPhrase" class="me-3 mb-0 fw-medium"></p>
                                                <span class="cursor-pointer" id="copyPhrase">
                                                    <i class="ti ti-copy" title="Copy"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <button class="btn btn-outline-secondary" id="downloadPhrase">Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>


        <!-- Modal -->
        <!-- Enable OTP Modal -->
        <div class="modal fade" id="enableOTP" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-6">
                            <h4 class="mb-2">Enable One-Time Password (OTP)</h4>
                            <p>Secure your account with Two-Factor Authentication (2FA).</p>
                        </div>
                        <form id="twoStepsForm" action="{{ route('admin.account.settings.security.set-up-otp') }}" method="POST">
                            <div class="mb-6">
                                <div class="auth-input-wrapper d-flex align-items-center justify-content-between numeral-mask-wrapper">
                                    <input
                                        type="tel"
                                        class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                                        maxlength="1"
                                        autofocus />
                                    <input
                                        type="tel"
                                        class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                                        maxlength="1" />
                                    <input
                                        type="tel"
                                        class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                                        maxlength="1" />
                                    <input
                                        type="tel"
                                        class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                                        maxlength="1" />
                                    <input
                                        type="tel"
                                        class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                                        maxlength="1" />
                                    <input
                                        type="tel"
                                        class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2"
                                        maxlength="1" />
                                </div>
                                <!-- Create a hidden field which is combined by 3 fields above -->
                                <input type="hidden" name="otp" />
                            </div>
                            <button class="btn btn-outline-success d-grid w-100 mb-6 submit">
                                Complete Setup
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Enable OTP Modal -->

        <!-- /Modal -->


    @push('js')
         <script src="{{asset('dashboard/requests/admin/two-factor-modal.js')}}"></script>
        <script src="{{ asset('dashboard/requests/admin/recovery_code_request.js') }}"></script>
        <script src="{{ asset('dashboard/requests/admin/account_security_settings.js') }}"></script>
    @endpush
@endsection
