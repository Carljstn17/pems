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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;1,100;1,200;1,300;1,400;1,500&display=swap" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body class="" style="height: 100vh;">
        <div class="container-fluid bg-white">
            <div class="row">
                <div class="col-12 col-md-9 order-2">
                    <nav class="border-bottom border-subtle">
                        @include('layout.nav')
                    </nav>
                    <section class="container-fluid">
                        @yield('content')
                    </section>
                </div>
                <aside class="col-12 col-md-3 border border-subtle order-1">
                    @include('layout.sidebarLaborer')
                </aside>
            </div>
        </div>   
        
        <script>
        // Check the screen width on page load
        window.addEventListener('load', function() {
        updateClassBasedOnScreenWidth();
        });

        // Check the screen width on window resize
        window.addEventListener('resize', function() {
        updateClassBasedOnScreenWidth();
        });

        // Function to update the class based on screen width
        function updateClassBasedOnScreenWidth() {
        var myDiv = document.getElementById('navbarNav');

        // Check if the screen width is less than or equal to 767px
        if (window.innerWidth <= 767) {
            // Remove the class if the condition is met
            myDiv.classList.remove('show');
        } else {
            // Add the class if the condition is not met
            myDiv.classList.add('show');
        }
        }
        </script>
    </body>
    </html>
