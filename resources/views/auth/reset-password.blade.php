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

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .no-border{
            border: none;
        }
    </style>
</head>
<body class="bg-light">
<main>
<div class="card mx-auto p-4" style="max-width: 400px;">
    <div class="card-body">
        <h2 class="card-title text-center p-4">Reset Password</h2>

        <form method="POST" action="{{ route('reset-password.submit') }}">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="form-group mb-4 d-flex justify-content-between border">
                <label for="password"></label>
                <input type="password" name="password" class="form-control no-border" placeholder="New Password" id="password" value="{{ old('password') }}" required>
                <button class="btn" type="button" id="togglePassword">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group mb-4 d-flex justify-content-between border">
                <label for="password"></label>
                <input type="password" name="password_confirmation" class="form-control no-border" placeholder="Confirm New Password" id="password_confirmation" value="{{ old('password_confirmation') }}" required>
                 <button class="btn" type="button" id="toggleConfirmPassword">
                    <i class="bi bi-eye"></i>
                </button>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-dark btn-block">Reset</button>
            </div>
        </form>
    </div>
</div>
</main>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordInput = document.getElementById('password');
        var icon = this.querySelector('i');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        var confirmPasswordInput = document.getElementById('password_confirmation');
        var icon = this.querySelector('i');
        var type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
    
    history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
</script>
</body>
</html>

