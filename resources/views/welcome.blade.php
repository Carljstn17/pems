<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <main class="mx-auto" style="width:380px;">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('image/logo.jpg') }}" alt="logo" class="img-fluid text-center">
                </div>

                <div class="col-md-8 align-self-center">
                    <div class="row">
                    <p class="h1 text-center">G.B GASPAR</p>
                    </div>
                    <div class="row">
                    <p class="h5 text-center letter">DESIGN & CONSTRUCTION</p>
                    </div>
                </div>
            </div>

            <div class="mt-5 h5 text-center">PROJECT EXPENSES MANAGEMENT SYSTEM</div>

            <div class="d-grid mt-5 container gap-3">
                <div class="row">
                    <a href="{{ url('owner-login') }}" class="btn btn-dark">Owner</a>
                </div>
                <div class="row">
                    <a href="{{ url('staff-login') }}" class="btn btn-dark">Staff</a>
                </div>
                <div class="row">
                    <a href="{{ url('laborer-login') }}" class="btn btn-dark">Laborer</a>
                </div>
            </div>

        </main>
    </body>
</html>