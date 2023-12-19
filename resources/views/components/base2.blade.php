<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/base2.css', 'resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg">
    <nav class="navbar navbar-light bg-light px-2 navigation">
        <div class="container-fluid d-sm-flex">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-none d-sm-inline" href="#">PROJECT EXPENSES MANAGEMENT SYSTEM</a>
            <span class="navbar-brand d-inline d-sm-none mx-2">PEMS</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap ">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebar" id="navbarNav">
                <div class="d-flex flex-column px-3 pt-2 min-vh-100 bg-white">
                    <a href="{{ url('staff/dashboard') }}" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none link-dark">
                        <span class="fs-4 d-sm-inline mt-2">Staff Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="{{ url('staff/dashboard') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/staff/projects') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-buildings"></i> <span class="ms-1 d-sm-inline">Projects</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('staff.payroll') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-wallet"></i> <span class="ms-1 d-sm-inline">Payroll</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('staff.estimate') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-card-checklist"></i> <span class="ms-1 d-sm-inline">Estimates</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('staff.receipt') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-receipt"></i> <span class="ms-1 d-sm-inline">Receipt</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/staff/tools') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-tools"></i> <span class="ms-1 d-sm-inline">Tools</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/staff/machinery') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-gear-wide"></i> <span class="ms-1 d-sm-inline">Machinery</span>
                            </a>
                        </li>
                        <div class="border-top d-sm-inline " style="width: 200px;"></div>
                        <li>
                            @auth
                                <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-person-circle link-dark"></i> <span class="ms-1 d-sm-inline link-dark">{{ Auth::user()->name }}</span> 
                                </a>
                                <ul class="collapse show nav flex-column ms-1" id="submenu2" data-bs-parent="#menu2">
                                    <li class="w-100">
                                        <a href="{{ route('logout') }}" class="nav-link px-0 link-dark"> <span class=" d-sm-inline">Logout</span> </a>
                                    </li>
                                </ul>
                            @endauth
                        </li>
                        </ul>
                    </div>
                </div>

                <div class="col-auto col-md-10">
                    {{ $content }}
                </div>

            </div>
    </div>










<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>
</html>
