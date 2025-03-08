@extends('admin.layout.base')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        @include('admin.settings.account.components.account_settings_menu')

        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form id="formAccountSettings" method="POST" action="{{ route('admin.account.settings.update') }}">
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="firstName" class="form-label">Name</label>
                            <input
                                class="form-control"
                                type="text"
                                id="firstName"
                                name="name"
                                value="{{ $user->name }}"
                                autofocus />
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="tel"
                                    id="phoneNumber"
                                    name="phoneNumber"
                                    class="form-control"
                                    placeholder="202 555 0111"
                                value="{{ $user->phone_number }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-center">
                        <button type="submit" class="btn btn-primary me-3 submit">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>

    </div>

    @push('js')
        <script src="{{ asset('dashboard/requests/admin/account-settings.js') }}"></script>
    @endpush
@endsection
