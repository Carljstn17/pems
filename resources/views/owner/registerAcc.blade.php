@extends('layout.owner')

    @section('content')

    <div class="py-2 mt-2">
        <div class="d-flex align-items-center">
       <div class="d-sm-none me-2">
            <a href="{{ url()->previous() }}" class="text-secondary text-decoration-none">
                <i class="bi-backspace"></i>
            </a>
        </div>
        <i class="fs-5 bi-person-plus"></i> <span class="d-sm-inline">Account</span>
        </div>
    </div>    

        <div class="py-2 mt-3 border-bottom border-subtle pb-3">
            <form method="POST" action="{{ url('/owner/register') }}">
                @csrf
                <div class="mb-3 input-group">
                    <label for="" class="input-group-text">Job</label>
                    <select class="form-select" name="role" required>
                        <option value="owner">Owner</option>
                        <option value="staff">Staff</option>
                        <option value="laborer">Laborer</option>
                    </select>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger px-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" >
                    @error('email')
                        <div class="text-danger px-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="contact" placeholder="Contact Number" value="{{ old('contact') }}" >
                    @error('contact')
                        <div class="text-danger px-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class=" mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" >
                    @error('username')
                        <div class="text-danger px-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Create Password, min of 8" id="passwordHelpBlock" value="{{ old('password') }}" >
                    @error('password')
                        <div class="text-danger px-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
@endsection
