<div class="col-12 col-lg-auto sidebar" id="navbarNav">
    <div class="d-flex flex-column flex-shrink-0 pt-1 min-vh-100 bg-white">
        <a href="{{ route('dashboard') }}" class="d-flex flex-column align-items-center text-decoration-none link-dark">
            <span class="fs-5 head py-5 minus">~/STAFF NAV</span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto px-3 pt-4 align-items-start gap-1 border-top" id="menu">
            <li class="nav-item px-2 {{ request()->is('staff/dashboard') ? 'active' : '' }} ">
                <a href="{{ url('staff/dashboard') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-speedometer2"></i> <span class="ms-1 d-sm-inline">Dashboard</span>
                </a>
            </li>
            <li class="nav-item px-2 {{ request()->is('staff/projects*', 'staff/ongoing-projects', 'staff/new-projects', 'staff/finish-project*', 'staff/old-projects', 'staff/show-old*', 'staff/add-projects', 'staff/store', 'staff/show*','search/project', 'search/project/old') ? 'active' : '' }}">
                <a href="{{ route('ongoing-projects') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-buildings"></i> <span class="ms-1 d-sm-inline">Projects</span>
                </a>
            </li>
            <li class="nav-item px-2 {{ request()->is('staff/payroll', 'staff/payroll/latest', 'staff/payroll/new', 'staff/payroll/on-going') ? 'active' : '' }}">
                <a href="{{ route('latest.payroll') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-wallet"></i> <span class="ms-1 d-sm-inline">Payroll</span>
                </a>
            </li>
            <li class="nav-item px-2 {{ request()->is('staff/estimate*', 'staff/estimate/latest', 'staff/estimate/new', 'staff/estimate/reject', 'items', 'staff/estimate/form/*', 'staff/estimate/reject/*', 'estimates/edit/*', 'estimates/update', 'estimates/soft-delete/*', 'search/estimate', 'search/reject') ? 'active' : '' }}">
                <a href="{{ route('latest') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-card-checklist"></i> <span class="ms-1 d-sm-inline">Estimates</span>
                </a>
            </li>
            <li class="nav-item px-2{{ request()->routeIs(['latest.receipt', 'on.receipt', 'showReceiptNew', 'entry.create', 'supplier.form', 'supplier', 'supplier.store', 'project.receipt', 'receipt.form']) ? ' active' : '' }}">
                <a href="{{ route('latest.receipt') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-receipt"></i> <span class="ms-1 d-sm-inline">Receipt</span>
                </a>
            </li>
            <li class="nav-item px-2 ">
                <a href="{{ route('staff.tool') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-tools"></i> <span class="ms-1 d-sm-inline">Tools</span>
                </a>
            </li>
            <li class="nav-item px-2 mb-3 ">
                <a href="{{ url('/staff/machinery') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-gear-wide"></i> <span class="ms-1 d-sm-inline">Machinery</span>
                </a>
            </li>
            <div class="border-top d-sm-inline" style="width: 310px;"></div>
            <li class="px-2 mt-3">
                @auth
                    <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <i class="fs-5 bi-person-circle link-dark"></i> <span class="ms-1 d-sm-inline link-dark">{{ Auth::user()->username }}</span> 
                    </a>
                    <ul class="collapse show ms-1" id="submenu2" data-bs-parent="#menu2">
                        <li>
                            <a href="{{ route('logout') }}" class="nav-link px-0 link-dark "> <span class=" d-sm-inline">Logout</span> </a>
                        </li>
                    </ul>
                @endauth
            </li>
            </ul>
        </div>
    </div>

            

