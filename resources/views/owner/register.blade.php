@extends('layout.owner')

    @section('content')
        <div class="container-fluid mt-2">
            <div class="py-2">
                <i class="fs-5 bi-person-plus"></i> <span class="d-sm-inline">Account</span>
            </div>

            <form method="POST" action="{{ url('/owner/register') }}" class="container-fluid bg-white rounded">
                @csrf
                <div class="row p-3">
                    <p class="fs-5">Register</p>

                    <div class="col-12 col-md-2 col-sm-6 mb-3">
                        <select class="form-select" name="role" required>
                            <option value="owner">Owner</option>
                            <option value="staff">Staff</option>
                            <option value="laborer">Laborer</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-5 mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                    </div>

                    <div class="col-12 col-md-5 mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="col-12 col-md-3 mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>

                    <div class="col-12 col-md-3 mb-3">
                        <input type="text" class="form-control" name="contact" placeholder="Contact Number" required>
                    </div>

                    <div class="col-12 col-md-3 mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Create Password" id="passwordHelpBlock" required>
                    </div>

                    <div class="col-12 col-md-3 col-sm-6 mb-3 d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div>
            </form>

            <div class="container-fluid mt-5">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-md-1">Role</th>
                                <th class="col-md-3">Email</th>
                                <th class="col-md-1">Contact</th>
                                <th class="col-md-2">Full Name</th>
                                <th class="col-md-2">Username</th>
                                <th class="col-md-1">Password</th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            @if ($user->role === 'owner' || $user->role === 'staff')
                                <tr>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->contact }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ Str::limit($user->password, 10) }}</td>
                                    <td class="d-flex justify-content-center gap-2">               
                                        <!-- Update Button -->
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Update</a>
                                        <!-- Soft Delete Button -->
                                        <form method="POST" action="{{ url('/users/soft-delete/{user}', $user->id) }}>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>  
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container-fluid mt-5">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-md-1">Role</th>
                                <th class="col-md-3">Email</th>
                                <th class="col-md-1">Contact</th>
                                <th class="col-md-2">Full Name</th>
                                <th class="col-md-2">Username</th>
                                <th class="col-md-1">Password</th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if ($user->role === 'laborer')
                                    <tr>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->contact }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ Str::limit($user->password, 10) }}</td>
                                        <td class="d-flex justify-content-center gap-2">               
                                            <!-- Update Button -->
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success">Update</a>
                                            <!-- Soft Delete Button -->
                                            <form method="POST" action="{{ url('/users/soft-delete/{user}', $user->id) }}>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>  
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

@endsection
