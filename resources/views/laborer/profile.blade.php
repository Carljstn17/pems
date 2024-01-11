@extends('layout.laborer')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-person-vcard"></i> <span class="d-sm-inline">Profile</span>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card mb-4 text-center p-2">
                <div style="width:330px;">
                    <img src="{{ asset('storage/' . $laborers->image) }}" alt="Receipt Photo" style="width:100%;">
                </div>
                <div>
                    <p class="mb-0 fs-4">{{ $laborers->username }}</p>
                    <p class="mb-1 fs-5">Laborer</p>
                    <p class="mb-0 fs-6">ID: {{ $laborers->id }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="container">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $laborers->name }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $laborers->email }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="number" class="form-label">Contact Number:</label>
                    <input type="number" id="number" name="number" class="form-control" value="{{ $laborers->contact }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="birthday" class="form-label">Birthday:</label>
                    <input type="date" id="birthday" name="birthday" class="form-control" value="{{ $laborers->birthdate }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <textarea id="address" name="address" class="form-control" rows="2" style="width:100%;resize:none;" readonly>{{ trim($laborers->address) }}</textarea>
                </div>

                <button type="button" class="btn btn-dark float-end" data-bs-toggle="modal" data-bs-target="#editProfileModal{{ $laborers->id }}">Edit</button>
            </div>
        </div>
    </div>

    @include('laborer.edit-profile-modal', ['laborers' => $laborers])
    
@endsection