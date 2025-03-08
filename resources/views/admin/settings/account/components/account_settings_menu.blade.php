

<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ (url()->current() == route('admin.account.settings'))?'active':'' }}" href="{{ route('admin.account.settings') }}"
                    ><i class="ti-sm ti ti-users me-1_5"></i> Account</a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (url()->current() == route('admin.account.settings.security'))?'active':'' }}" href="{{ route('admin.account.settings.security') }}"
                    ><i class="ti-sm ti ti-lock me-1_5"></i> Security</a
                    >
                </li>
            </ul>
        </div>

    </div>
</div>
