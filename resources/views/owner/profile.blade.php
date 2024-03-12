@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-person-vcard"></i> <span class="d-sm-inline fs-5 head">Profile</span>
    </div>

    @if(session('error'))
    <div class="alert alert-danger">
            {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
                {{ session('success') }}
        </div>
        <script>
            // Reload the page after displaying the success message
            setTimeout(function() {
                location.reload();
            }, 2000); // Reload after 2 seconds (adjust the time as needed)
        </script>
    @endif

    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="border border-subtle rounded mb-4 text-center p-2">
                <div style="width:330px;">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('image/profile.jpeg') }}" alt="Receipt Photo" style="width:100%;">
                </div>
                <div>
                    <p class="mb-0 fs-4">{{ ucwords($user->username) }}</p>
                    <p class="mb-1 fs-5">{{ ucwords($user->role) }}</p>
                    <p class="mb-0 fs-6">ID: {{ $user->id }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="container">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="number" class="form-label">Contact Number:</label>
                    <input type="number" id="number" name="number" class="form-control" value="{{ $user->contact }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="birthday" class="form-label">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" class="form-control" value="{{ $user->birthdate }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <textarea id="address" name="address" class="form-control" rows="2" style="width:100%;resize:none;" readonly>{{ trim($user->address) }}</textarea>
                </div>

                <button type="button" class="btn btn-dark float-end" data-bs-toggle="modal" data-bs-target="#editProfileModal{{ $user->id }}">Edit</button>
            </div>
        </div>
    </div>
    
    @include('owner.edit-profile-modal', ['user' => $user])
    
@endsection