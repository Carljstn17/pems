<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/logo.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <main>
<div class="">
    <div class="card mx-auto p-4" style="max-width: 400px;">
        <div class="card-body">
            <h2 class="card-title text-center p-4">Staff Login</h2>

            <form method="POST" action="{{ url('/staff/login') }}">
                @csrf

                <div class="form-group mb-2">
                    <label for="name"></label>
                    <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>
                    @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="password"></label>
                    <div class="form-group mb-2">
                        <input type="password" name="password" class="form-control" id="myInput" placeholder="Password" value="{{ old('password') }}" required>
                    </div>
                    @error('password')
                            <span class="text-danger">{{ $message }}</span>
                     @enderror
                    <div class="d-flex align-items-center ms-2">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2 ms-1 text-secondary">remember me</span>
                    </div>
                </div>

                <div class="g-recaptcha d-grid justify-content-center mb-4" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>

                <div class="d-grid mb-5">
                    <button type="submit" class="btn btn-dark btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>
