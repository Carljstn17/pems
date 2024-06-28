<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
    @if(session('success'))
        <div class="alert alert-success">
                {{ session('success') }}
        </div>
    @endif
        <h1>Email Verification</h1>
        <p>Please click the button below to verify your email address:</p>
        <form method="POST" action="{{ route('verify.email', ['userId' => $user->id]) }}">
            @csrf
            <button type="submit" class="btn btn-success">Verify Email Address</button>
        </form>
    </div>
</body>
</html>
