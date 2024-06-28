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
        #countdown {
            display: none;
        }
    </style>
</head>
<body class="bg-light">
<main>
<div class="card mx-auto p-4" style="max-width: 400px;">
    <div class="card-body">
        <h2 class="card-title text-center p-4">Verify Email</h2>

        <form method="POST" action="{{ route('send-otp') }}">
            @csrf

            <div class="form-group mb-4">
                <label for="email"></label>
                <input type="text" name="email" class="form-control" placeholder="Email Address" id="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-grid mb-4">
                <button id="submit-button" type="submit" class="btn btn-dark" onclick="handleSubmit()">Send OTP</button>
                <div id="countdown" class="text-secondary"></div>
            </div>
        </form>
            <div class="d-flex justify-content-between mt-2">
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary border-dark-subtle px-5 py-3"><i class="bi-caret-left-fill"></i>Back</a>
            </div>
    </div>
</div>
</main>
    <script>
        function handleSubmit() {
            var button = document.getElementById("submit-button");
            var countdownElement = document.getElementById("countdown");

            button.style.display = "none";
            countdownElement.style.display = "block";

            var startTime = new Date().getTime();
            localStorage.setItem("countdownStartTime", startTime);

            var countdown = setInterval(function() {
                var currentTime = new Date().getTime();
                var elapsedTime = Math.floor((currentTime - startTime) / 1000);
                var remainingTime = 30 - elapsedTime;

                if (remainingTime <= 0) {
                    clearInterval(countdown);
                    countdownElement.innerText = "You can now resend OTP";
                    button.style.display = "inline-block";
                    countdownElement.style.display = "none";
                } else {
                    countdownElement.innerText = "Resend OTP in " + remainingTime + " seconds";
                }
            }, 1000);
        }

        window.onload = function() {
            var startTime = localStorage.getItem("countdownStartTime");
            if (startTime) {
                var currentTime = new Date().getTime();
                var elapsedTime = Math.floor((currentTime - parseInt(startTime)) / 1000);
                var remainingTime = 30 - elapsedTime;

                if (remainingTime <= 0) {
                    localStorage.removeItem("countdownStartTime");
                } else {
                    var button = document.getElementById("submit-button");
                    var countdownElement = document.getElementById("countdown");

                    button.style.display = "none";
                    countdownElement.style.display = "block";
                    countdownElement.innerText = "Resend OTP in " + remainingTime + " seconds";

                    var countdown = setInterval(function() {
                        var currentTime = new Date().getTime();
                        var elapsedTime = Math.floor((currentTime - parseInt(startTime)) / 1000);
                        var remainingTime = 30 - elapsedTime;

                        if (remainingTime <= 0) {
                            clearInterval(countdown);
                            countdownElement.innerText = "You can now resend OTP";
                            button.style.display = "inline-block";
                            countdownElement.style.display = "none";
                            localStorage.removeItem("countdownStartTime");
                        } else {
                            countdownElement.innerText = "Resend OTP in " + remainingTime + " seconds";
                        }
                    }, 1000);
                }
            }
        };
    </script>
</body>
</html>