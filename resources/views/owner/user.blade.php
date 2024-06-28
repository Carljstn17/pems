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
                <div style="width:100%;">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('image/profile.jpeg') }}" alt="Receipt Photo" style="width:100%;">
                </div>
                <div>
                    <p class="mb-0 fs-4">{{ ucwords($user->username) }}</p>
                    <p class="mb-1 fs-5">{{ ucwords($user->role) }}
                        @if($user->srole == 1)
                            <i class="fs-5 bi-award link-dark"></i>
                        @endif
                    </p>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                @if (empty($user->email_verified_at))
                    <form action="{{ route('verification.resend.user') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary px-5">Verify</button>
                    </form>
                    @else
                    <div></div>
                @endif
                
                @if (!empty($user->email_verified_at))
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmResetModal">Reset Password</button>
                    @else
                    <div class="px-3 fs-6 text-danger">Verify your Email to reset password</div>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div class="container">
                <div class="border rounded mb-3 p-2">
                <div class="row">
                    <div class="form-group mb-3 col-md-4">
                        <label for="name" class="form-label">Last Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $user->lname }}" readonly>
                    </div>
                    
                    <div class="form-group mb-3 col-md-4">
                        <label for="name" class="form-label">First Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $user->fname }}" readonly>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="name" class="form-label">Middle Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $user->mname }}" readonly>
                    @if (!empty($user->email_verified_at))
                        <button class="text-primary float-end border-0 bg-white" data-toggle="modal" data-target="#openModalName">edit</button>
                    @else
                        <div class="text-danger float-end">verify email to edit information.</div>
                    @endif
                    </div>
                </div>
                </div>
                
                <div class="border p-2 rounded mb-3">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        @if (!empty($user->email_verified_at))
                            <span class="text-success float-end">Verified</span>
                            @else
                            <span class="text-danger float-end">Not Verified</span>
                         @endif
                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                        <button class="text-primary float-end border-0 bg-white" data-toggle="modal" data-target="#openModalEmail">edit</button>
                    </div>
    
                    <div class="form-group mb-4">
                        <label for="number" class="form-label">Contact Number:</label>
                        <input type="number" id="number" name="number" class="form-control" value="{{ $user->contact }}" readonly>
                        <button class="text-primary float-end border-0 bg-white" data-toggle="modal" data-target="#openModalContact">edit</button>
                    </div>
                </div>

                <div class="border p-2 rounded mb-3">
                    <div class="form-group mb-3">
                        <label for="birthday" class="form-label">Birthday:</label>
                        <input type="date" id="birthday" name="birthday" class="form-control" value="{{ $user->birthdate }}" readonly>
                    </div>
    
                    <div class="form-group mb-4">
                        <label for="address" class="form-label">Address:</label>
                        <textarea id="address" name="address" class="form-control" rows="4" style="width:100%;resize:none;" readonly>{{ trim($user->address) }}</textarea>
                        @if (!empty($user->email_verified_at))
                            <button class="text-primary float-end border-0 bg-white" data-toggle="modal" data-target="#openModalAddress">edit</button>
                        @else
                            <div class="text-danger float-end">verify email to edit information.</div>
                        @endif
                    </div>
                </div>
                
                <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="roleModalLabel">Manage Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @if (!empty($user->srole))
                                    Are you sure you want to revoke the role {{ $user->username }}?
                                @else
                                    Are you sure you want to assign the role to {{ $user->username }}?
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                @if (!empty($user->srole))
                                    <form action="{{ route('revoke', ['userId' => $user->id]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Revoke</button>
                                    </form>
                                @else
                                    <form action="{{ route('assign', ['userId' => $user->id]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Assign</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="openModalName" tabindex="-1" aria-labelledby="editModalName" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="roleModalLabel">Edit Name</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('owner.updateInfo', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label for="lname" class="col-sm-4 col-form-label">Last Name:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="lname" name="lname" class="form-control" value="{{ old('lname', $user->lname) }}">
                                            @error('lname')
                                                <div class="text-danger px-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="fname" class="col-sm-4 col-form-label">First Name:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="fname" name="fname" class="form-control" value="{{ old('fname', $user->fname) }}">
                                            @error('fname')
                                                <div class="text-danger px-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="mname" class="col-sm-4 col-form-label">Middle Name:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="mname" name="mname" class="form-control" value="{{ old('mname', $user->mname) }}">
                                            @error('mname')
                                                <div class="text-danger px-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            
                            @if ($errors->has('lname') || $errors->has('mname') || $errors->has('fname'))
                                <script>
                                    $(document).ready(function() {
                                        $('#openModalName').modal('show');
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="openModalEmail" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel">Update Email and Contact</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="updateForm" action="{{ route('updateEmail', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-4 col-form-label">Email Address:</label>
                                        <div class="col-sm-8">                                        
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                    <div class="text-danger px-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            
                            @if ($errors->has('email'))
                                <script>
                                    $(document).ready(function() {
                                        $('#openModalEmail').modal('show');
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="openModalContact" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel">Update Email and Contact</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="updateForm" action="{{ route('updateContact', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label for="contact" class="col-sm-4 col-form-label">Contact Number:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact', $user->contact) }}">
                                            @error('contact')
                                                    <div class="text-danger px-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            
                            @if ($errors->has('contact'))
                                <script>
                                    $(document).ready(function() {
                                        $('#openModalContact').modal('show');
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="openModalAddress" tabindex="-1" aria-labelledby="editModalAdress" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="roleModalLabel">Edit Name</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('updateBA', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <label for="birthdate" class="form-label">Birthday:</label>
                                        <input type="date" id="birthdate" name="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate) }}">
                                        @error('birthdate')
                                                <div class="text-danger px-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                        <label for="address" class="form-label">Address:</label>
                                    <div class="row mb-3 px-3">
                                        <textarea id="address" name="address" class="form-control" rows="4" style="resize:none;">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                                <div class="text-danger px-2">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            @if ($errors->has('address', 'birthday'))
                                <script>
                                    $(document).ready(function() {
                                        $('#openModalAddress').modal('show');
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="confirmResetModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="{{ route('update.password') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="oldPassword">Old Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" value="{{ old('old_password') }}">
                            @error('old_password')
                                    <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="newPassword">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" value="{{ old('new_password') }}">
                            @error('new_password')
                                    <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                            <input type="checkbox" onclick="myFunction()"><span class="text-secondary"> show password</span>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-danger">Reset Password</button>
                        </div>
                      </form>
                        @if ($errors->any('old_password', 'new_password'))
                            <script>
                                $(document).ready(function() {
                                    $('#confirmResetModal').modal('show');
                                });
                            </script>
                        @endif
                        <script>
                            function myFunction() {
                                var x = document.getElementById("old_password");
                                var y = document.getElementById("new_password");
                                  if (x.type === "password" && y.type === "password") {
                                    x.type = "text";
                                    y.type = "text";
                                  } else {
                                    x.type = "password";
                                    y.type = "password";
                                  }
                                }
                        </script>
                    </div>
                  </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
         // Function to store input values before modal is closed
        function storeInputValues() {
            sessionStorage.setItem('lname', document.getElementById('lname').value);
            sessionStorage.setItem('fname', document.getElementById('fname').value);
            sessionStorage.setItem('mname', document.getElementById('mname').value);
            sessionStorage.setItem('birthdate', document.getElementById('birthdate').value);
            sessionStorage.setItem('address', document.getElementById('address').value);
            sessionStorage.setItem('email', document.getElementById('email').value);
            sessionStorage.setItem('contact', document.getElementById('contact').value);
            sessionStorage.setItem('old_password', document.getElementById('old_password').value);
            sessionStorage.setItem('new_password', document.getElementById('new_password').value);
        }
    
        // Function to retrieve and populate input values when modal is shown
        function populateInputValues() {
            document.getElementById('lname').value = sessionStorage.getItem('lname');
            document.getElementById('fname').value = sessionStorage.getItem('fname');
            document.getElementById('mname').value = sessionStorage.getItem('mname');
            document.getElementById('birthdate').value = sessionStorage.getItem('birthdate');
            document.getElementById('address').value = sessionStorage.getItem('address');
            document.getElementById('email').value = sessionStorage.getItem('email');
            document.getElementById('contact').value = sessionStorage.getItem('contact');
            document.getElementById('old_password').value = sessionStorage.getItem('old_password');
            document.getElementById('new_password').value = sessionStorage.getItem('new_password');
        }
    
        // Triggered when the modal is shown
        $('#openModalName').on('show.modal', function (event) {
            populateInputValues();
        });
    
        // Triggered when the modal is closed
        $('#openModalName').on('hide.modal', function (event) {
            storeInputValues();
        });
        
        $('#openModalAddress').on('show.modal', function (event) {
            populateInputValues();
        });
    
        // Triggered when the modal is closed
        $('#openModalAddress').on('hide.modal', function (event) {
            storeInputValues();
        });
        
        $('#openModalEmail').on('show.modal', function (event) {
            populateInputValues();
        });
    
        // Triggered when the modal is closed
        $('#openModalEmail').on('hide.modal', function (event) {
            storeInputValues();
        });
        
        $('#openModalContact').on('show.modal', function (event) {
            populateInputValues();
        });
    
        // Triggered when the modal is closed
        $('#openModalContact').on('hide.modal', function (event) {
            storeInputValues();
        });

        $('#confirmResetModal').on('show.modal', function (event) {
            populateInputValues();
        });
    
        // Triggered when the modal is closed
        $('#confirmResetModal').on('hide.modal', function (event) {
            storeInputValues();
    </script>

@endsection