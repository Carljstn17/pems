<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/base.css', 'resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg">
    <nav class="navbar navbar-expand-sm navbar-light bg-light px-2 navigation">
        <div class="container-fluid d-sm-flex">
            <div class="div-1">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand d-none d-sm-inline" href="#">PROJECT EXPENSES MANAGEMENT SYSTEM</a>
            </div>

            <div class="div-2 navbar-collapse justify-content-end" id="navbarNav">
                @auth
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown text-end">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>




    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0"   id="navbarNav">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100 bg-white">
                    <a href="{{ url('staff/dashboard') }}" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none link-dark">
                        <span class="fs-4 d-none d-sm-inline mt-2">Owner Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="{{ url('owner/dashboard') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('owner/accounts') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-person-plus"></i> <span class="ms-1 d-none d-sm-inline">Account</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('order') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-card-checklist"></i> <span class="ms-1 d-none d-sm-inline">Estimate</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-backpack4"></i> <span class="ms-1 d-none d-sm-inline">Inventory</span>
                            </a>
                        </li>
                        <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-archive link-dark"></i> <span class="ms-1 d-none d-sm-inline link-dark">Transct History</span> </a>
                            <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="#" class="nav-link px-0 link-dark"> <span class="d-none d-sm-inline">Receipt</span> </a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0 link-dark"> <span class="d-none d-sm-inline">Issue</span> </a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0 link-dark"> <span class="d-none d-sm-inline">Return</span> </a>
                                </li>
                            </ul>
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

</body>
</html>
