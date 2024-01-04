<div class="col-12 col-lg-auto sidebar collapse show" id="navbarNav">
    <div class="d-flex flex-column flex-shrink-0 pt-1 min-vh-100 bg-white">
        <div class="justify-content-evenly">
            <button class="d-lg-none no-border float-end" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle sidebar">
                <i class="bi bi-x-circle float-end"></i>
            </button>

            <a href="{{ route('owner.dashboard') }}" class="d-flex flex-column align-items-center text-decoration-none link-dark">
                <span class="fs-5 head py-5 minus">~/OWNER NAV</span>
            </a>
        </div>
        
        <ul class="nav nav-pills flex-column mb-sm-auto px-3 pt-4 align-items-start gap-1 border-top" id="menu">
            <li class="nav-item px-2 {{ request()->is('owner/dashboard') ? 'active' : '' }}">
                <a href="{{ route('owner.dashboard') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-speedometer2"></i> <span class="ms-1 d-sm-inline">Dashboard</span>
                </a>
            </li>
            <li class="nav-item px-2 {{ request()->is('owner/accounts') ? 'active' : '' }}">
                <a href="{{ url('owner/accounts') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-buildings"></i> <span class="ms-1 d-sm-inline">Account</span>
                </a>
            </li>
            <li class="nav-item px-2 {{ request()->is('owner/estimate', 'owner/estimate/create', 'owner/estimate/show/*', 'owner/estimate/showreject/', ) ? 'active' : '' }}">
                <a href="{{ route('owner.estimate') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-wallet"></i> <span class="ms-1 d-sm-inline">Estimate</span>
                </a>
            </li>
            <li class="nav-item px-2">
                <a href="{{ route('owner.tool') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-card-checklist"></i> <span class="ms-1 d-sm-inline">Tool</span>
                </a>
            </li>
            <li class="nav-item px-2">
                <a href="{{ route('owner.machinery') }}" class="nav-link align-middle px-0 link-dark">
                    <i class="fs-5 bi-card-checklist"></i> <span class="ms-1 d-sm-inline">Machinery</span>
                </a>
            </li>
            <li class=" px-2 ">
                <a href="#submenu1" data-bs-toggle="collapse" class="nav-item nav-link px-0 align-middle">
                    <i class="fs-4 bi-archive link-dark"></i> <span class="ms-1 d-sm-inline link-dark">Transct History</span> 
                </a>
                <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu" style="width: 310px;">
                    <li class="nav-item">
                        <a href="{{ route('owner.payroll') }}" class="nav-link px-0 link-dark"> <span class=" d-sm-inline px-2">Payroll</span> </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link px-0 link-dark"> <span class=" d-sm-inline px-2">Receipt</span> </a>
                    </li>
                </ul>
            </li>
            <div class="border-top d-sm-inline" style="width: 310px;"></div>
            <li class="px-2 mt-3 bottom" style="width: 310px;">
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

            

