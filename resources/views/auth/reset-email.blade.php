<form method="POST" action="{{ route('send-reset-link') }}">
    @csrf

    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}" required>

    <button type="submit">Send Reset Link</button>
</form>
