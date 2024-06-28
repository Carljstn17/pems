<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/17.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .no-border{
            border: none;
            background-color: transparent;
            padding: 0 10px;
        }
    </style>
</head>
<body class="bg-light">

<main>
<div class="">
    <div class="mx-auto" style="max-width: 380px;">
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

        <div class="my-4 h5 text-center">PROJECT EXPENSES MANAGEMENT SYSTEM</div>

        <form method="POST" action="{{ url('/owner/login') }}">
            @csrf

            <div class="card px-3 mb-2">
                <div class="form-group mb-2">
                    <label for="name"></label>
                    <input type="text" name="username" field="username" class="form-control" placeholder="Username" id="username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group mb-4">
                    <label for="password"></label>
                    <div class="form-group mb-2 d-flex justify-content-between border">
                        <input type="password" name="password" class="form-control no-border" id="password" placeholder="Password" value="{{ old('password') }}" required>
                        <button class="btn" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger mb-2">{{ $message }}</div>
                    @enderror
                    <div class="d-flex align-items-center ms-2 justify-content-between">
                        <div>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2 ms-1 text-secondary">remember me</span>
                        </div>
                        
                        <a href="{{ route('send-otp-form') }}" class="link-secondary text-decoration-none">reset password</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-4">
                        <div class="g-recaptcha mx-auto" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                        @error('g-recaptcha-response')
                            <div class="text-danger ms-4">{{ $message }}</div>
                        @enderror
    
                </div>
    
    
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-dark btn-block">Login</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
</main>
    <script>
        // Disable back button
        history.pushState(null, null, location.href);
        history.back();
        history.forward();
        window.onpopstate = function () {
            history.go(1);
        };
        
        document.getElementById('togglePassword').addEventListener('click', function () {
            var passwordInput = document.getElementById('password');
            var icon = this.querySelector('i');
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
