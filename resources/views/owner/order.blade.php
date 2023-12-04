<x-base>
    <x-slot name="content">
        <div class="container-fluid mt-2">
            <div class="py-2">
                <i class="fs-4 bi-card-checklist"></i> <span class="fs-4 d-sm-inline">Estimate</span>
            </div>

            <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm rounded">
                <div class="container-fluid">
                    <!-- Navbar Toggler Button for Mobile View -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavv" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Navbar Links -->
                    <div class="collapse navbar-collapse nav-order justify-content-md-center" id="navbarNavv">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active ms-md-1" onclick="setActive(this)" href="#">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-md-1" onclick="setActive(this)" href="#">Accepted</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-md-1" onclick="setActive(this)" href="#">Rejected</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-md-1" onclick="setActive(this)" href="#">Estimated</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container-fluid mt-5">
            <div class="row-container gap-3">
                <div class="col-container bg-white shadow-sm rounded p-5 d-flex justify-content-center">
                    <a href="#" class="row text-decoration-none link-dark">
                        <div class="col-auto">
                            <span class="fs-4 d-none d-sm-inline">FR NO:</span>
                            <span class="fs-4 d-sm-inline d-sm-none ">FN:</span>
                        </div>
                        <div class="col-auto">
                            <span class="fs-4 d-none d-sm-inline">FR Date:</span>
                            <span class="fs-4 d-sm-inline d-sm-none ">FD:</span>
                        </div>
                    </a>
                </div>

                <div class="col-container bg-white shadow-sm rounded p-5 d-flex justify-content-center">
                    <a href="#" class="row text-decoration-none link-dark">
                        <div class="col-auto">
                            <span class="fs-4 d-none d-sm-inline">FR NO:</span>
                            <span class="fs-4 d-sm-inline d-sm-none ">FN:</span>
                        </div>
                        <div class="col-auto">
                            <span class="fs-4 d-none d-sm-inline">FR Date:</span>
                            <span class="fs-4 d-sm-inline d-sm-none ">FD:</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>



        <script>
            function setActive(clickedLink) {
                // Remove 'active' class from all links
                document.querySelectorAll('.navbar-nav a.nav-link').forEach(link => link.classList.remove('active'));

                // Add 'active' class to the clicked link
                clickedLink.classList.add('active');
            }
        </script>
    </x-slot>

    </x-base>

