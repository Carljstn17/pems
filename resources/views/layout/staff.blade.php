<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/logo.jpg') }}">

     <!-- Styles -->
     @vite(['resources/css/base2.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/sidebar.css',])

     {{-- <link rel="stylesheet" href="/css/base2.css">
     <link rel="stylesheet" href="/css/sidebar.css"> --}}
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;1,100;1,200;1,300;1,400;1,500&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body class="bg">
    <div class="container-fluid bg-white">
        <div class="row">
            <aside class="col-12 col-md-3 border border-subtle">
                @include('layout.sidebar')
            </aside>
            <div class="col-12 col-md-9">
                <nav class="border-bottom border-subtle">
                    @include('layout.navStaff')
                </nav>
                <section class="container-fluid">
                    @yield('content')
                </section>
            </div>
        </div>
    </div>   
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const rows = document.querySelectorAll(".clickable-row");
        rows.forEach(row => {
            row.addEventListener("click", function () {
                const url = this.getAttribute("data-url");
                if (url) {
                    window.location.href = url;
                }
            });
        });
    });
    </script>
</body>
</html>
