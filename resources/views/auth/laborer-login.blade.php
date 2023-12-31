<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Form</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <main>
<div class="container-fluid">
    <div class="card mx-auto p-4" style="max-width: 400px;">
        <div class="card-body">
            <h2 class="card-title text-center p-4">Laborer Login</h2>

            <form method="POST" action="{{ url('/laborer/login') }}">
                @csrf

                <div class="form-group mb-2">
                    <label for="name"></label>
                    <input type="text" name="username" class="form-control" placeholder="Username" id="username" :value="@old('username')" required>
                </div>

                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror


                <div class="form-group mb-2">
                    <label for="password"></label>
                    <div class="form-group mb-2">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" :value="@old('password')" required>
                        </div>
                    </div>
                </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                <div class="d-grid m-3 mb-5">
                    <button type="submit" class="btn btn-dark btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>

</body>
</html>
