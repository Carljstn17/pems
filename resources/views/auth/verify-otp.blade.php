<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    
        .show-countdown #countdown {
            display: block;
        }
    </style>
</head>
<body class="bg-light">
<main>
<div class="card mx-auto p-4" style="max-width: 400px;">
    <div class="card-body">
        <h2 class="card-title text-center p-4">Verify OTP</h2>

        <form method="POST" action="{{ route('verify-otp.submit') }}">
            @csrf

            <div class="form-group mb-4">
                <label for="otp"></label>
                <input type="text" name="otp" class="form-control" placeholder="Enter OTP" id="otp" value="{{ old('otp') }}" required>
                @error('otp')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-dark btn-block">Enter</button>
            </div>
        </form>
        
            <div class="d-flex justify-content-between align-items-center mt-2">
                <a href="{{ route('send-otp-form') }}" class="btn btn-outline-secondary border-dark-subtle px-5 py-3"><i class="bi-caret-left-fill"></i>Back</a>
                <button id="resend-button" class="btn btn-outline-secondary border-dark-subtle px-5 py-3" onclick="resendOTP()"><i class="bi-arrow-repeat"></i>Resend</button>
                <div id="countdown" class="text-secondary"></div>
            </div>
    </div>
</div>
</main>
    <!-- Ensure jQuery is loaded before your script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Your HTML and other scripts -->

<script>
$(document).ready(function() {
    var startTime = localStorage.getItem('countdownStartTime');
    if (startTime) {
        var currentTime = new Date().getTime();
        var elapsedTime = Math.floor((currentTime - parseInt(startTime)) / 1000);
        var remainingTime = 5 - elapsedTime;

        if (remainingTime > 0) {
            startCountdown(remainingTime);
        }
    }

    function startCountdown(seconds) {
        $("#resend-button").hide(); // Hide the resend button
        $("#countdown").text("Resend OTP in " + seconds + " seconds").parent().addClass('show-countdown'); // Show the countdown
        var countdownInterval = setInterval(function() {
            seconds--;
            $("#countdown").text("Resend OTP in " + seconds + " seconds");

            if (seconds <= 0) {
                clearInterval(countdownInterval);
                $("#countdown").text("");
                $("#resend-button").show();
                $("#resend-button").prop('disabled', false); // Re-enable the button
                $("#countdown").parent().removeClass('show-countdown'); // Hide the countdown
            }
        }, 1000);

        // Store start time in local storage
        localStorage.setItem('countdownStartTime', new Date().getTime());
    }

    function resendOTP() {
        // Disable the button to prevent multiple clicks
        $("#resend-button").prop('disabled', true);
        // Send the OTP
        $.ajax({
            url: "{{ route('resend-otp') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                alert("OTP Resent!");
                startCountdown(5);
            },
            error: function(xhr) {
                alert("Failed to resend OTP. Please try again.");
                // Re-enable the button on error
                $("#resend-button").prop('disabled', false);
            }
        });
    }

    // Attach the resendOTP function to the button click event
    $("#resend-button").click(resendOTP);
});

</script>

</body>
</html>
