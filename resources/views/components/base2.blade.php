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
    @vite(['resources/css/base2.css', 'resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg">
    <nav class="navbar navbar-expand-sm navbar-light bg-light px-4 navigation">
        <a class="navbar-brand d-none d-sm-inline" href="#">PROJECT EXPENSES MANAGEMENT SYSTEM</a>
        <span class="d-inline d-sm-none">PEMS</span>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
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
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100 bg-white">
                    <a href="{{ url('staff/dashboard') }}" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none link-dark">
                        <span class="fs-4 d-none d-sm-inline mt-2">Staff Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="{{ url('staff/dashboard') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/staff/projects') }}" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-buildings"></i> <span class="ms-1 d-none d-sm-inline">Projects</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-wallet"></i> <span class="ms-1 d-none d-sm-inline">Payroll</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-card-checklist"></i> <span class="ms-1 d-none d-sm-inline">Estimates</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-receipt"></i> <span class="ms-1 d-none d-sm-inline">Receipt</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-tools"></i> <span class="ms-1 d-none d-sm-inline">Tools</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle px-0 link-dark">
                                <i class="fs-4 bi-gear-wide"></i> <span class="ms-1 d-none d-sm-inline">Machinery</span>
                            </a>
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
