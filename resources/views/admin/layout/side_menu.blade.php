<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ $user->getDashboardUrl() }}" class="app-brand-link">
            <img src="{{ asset($web->favicon) }}" style="width: 100px;"/>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item">
            <a href="{{ $user->getDashboardUrl() }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Overview">Overview</div>
            </a>
        </li>

        <!-- Add spacing -->
        <li class="menu-spacing"></li>

        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
                <div data-i18n="Product Management">Product Management</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.products.list') }}" class="menu-link">
                        <div data-i18n="Manage Products">Manage Products</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.product.create') }}" class="menu-link">
                        <div data-i18n="Add New Product">Add New Product</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Manage Coupons">Manage Coupons</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Create Discount Code">Create Discount Code</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.category.index') }}" class="menu-link">
                        <div data-i18n="Categories">Categories</div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- Add spacing -->
        <li class="menu-spacing"></li>

        <!-- Front Pages -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                <div data-i18n="Order Management">Order Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="All Orders">All Orders</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link" >
                        <div data-i18n="Pending Orders">Pending Orders</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Completed Orders">Completed Orders</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Cancelled Orders">Cancelled Orders</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Manage Deliveries">Manage Deliveries</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Add spacing -->
        <li class="menu-spacing"></li>

        <!-- Apps & Pages -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Apps & Pages">Apps &amp; Pages</span>
        </li>

        <!-- Add spacing -->
        <li class="menu-spacing"></li>

        <!-- e-commerce-app menu start -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users-group"></i>
                <div data-i18n="Customer">Customers</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="All Customers">All Customers</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-user-dollar"></i>
                <div data-i18n="Affiliates">Affiliates</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.affiliate.show') }}" class="menu-link">
                        <div data-i18n="All Affiliates">All Affiliates</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.affiliate.earnings') }}" class="menu-link">
                        <div data-i18n="Affiliates Earnings">Affiliates Earnings</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.affiliate.payouts') }}" class="menu-link">
                        <div data-i18n="Payout Requests">Payouts Requests</div>
                    </a>
                </li>

            </ul>
        </li>
        <!-- e-commerce-app menu end -->

        <!-- Add spacing -->
        <li class="menu-spacing"></li>


        <!-- Academy menu start -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-writing"></i>
                <div data-i18n="Engineers & OEM Registrations">Engineers & OEM Registrations</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Engineers Submissions">Engineers Submission</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="OEM Submissions">OEM Submission</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Assign Follow-up">Assign Follow-up</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Add spacing -->
        <li class="menu-spacing"></li>

        <!-- Academy menu end -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-cash-banknote"></i>
                <div data-i18n="Payment & Withdrawal Management">Payment & Withdrawal Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Customers Payment">Customers Payments</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Affiliate Withdrawal Requests">Affiliate Withdrawal Requests</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Approved/Rejected Payouts">Approved/Rejected Payouts</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Add spacing -->
        <li class="menu-spacing"></li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-report-analytics"></i>
                <div data-i18n="Reports & Analytics">Reports & Analytics</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Sales Report">Sales Report</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <div data-i18n="Affiliate Performance Report">
                            Affiliate Performance Report
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Add spacing -->
        <li class="menu-spacing"></li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Staff Management">Staff Management</div>
            </a>
            <ul class="menu-sub">
                @can('view staff members')
                    <li class="menu-item">
                        <a href="{{ route('admin.staff') }}" class="menu-link">
                            <div data-i18n="Manage Staff Users">Manage Staff Users</div>
                        </a>
                    </li>
                @endcan
                @can('manage staff roles & permissions')
                    <li class="menu-item">
                        <a href="{{ route('admin.staff.roles-permissions') }}" class="menu-link">
                            <div data-i18n="Roles & Permissions">Roles & Permissions</div>
                        </a>
                    </li>
                @endcan
                @can('view staff activity logs')
                    <li class="menu-item">
                        <a href="{{ route('admin.staff.activity-logs') }}" class="menu-link">
                            <div data-i18n="Activity Logs">Activity Logs</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>

        <!-- Add spacing -->
        <li class="menu-spacing"></li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Settings">Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.settings.general') }}" class="menu-link">
                        <div data-i18n="General Settings">General Settings</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.delivery.settings') }}" class="menu-link">
                        <div data-i18n="Delivery Settings">Delivery Settings</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('admin.account.settings') }}" class="menu-link">
                        <div data-i18n="Account Settings">Account Settings</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Add spacing -->
        <li class="menu-spacing"></li>
        <!-- Misc -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Misc">Misc</span>
        </li>
        <li class="menu-item">
            <a href="{{ route('logout') }}"  class="menu-link">
                <i class="menu-icon tf-icons ti ti-logout"></i>
                <div data-i18n="Logout">Logout</div>
            </a>
        </li>
    </ul>
</aside>

