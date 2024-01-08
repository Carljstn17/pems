@extends('layout.owner')

    @section('content')

    <div class="py-2 mt-2">
        <i class="fs-5 bi-person-plus"></i> <span class="d-sm-inline">Account</span>
    </div>    

        <div class="py-2 mt-3 border-bottom border-subtle pb-3">
            <button class="btn btn-outline-primary" style="transition: 0.8s;" data-bs-toggle="modal" data-bs-target="#registerModal">
                <span><i class="bi bi-plus"></i>Register Account</span>
            </button>
        </div>

            <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registerModalLabel">Register</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ url('/owner/register') }}" class="container-fluid bg-white rounded">
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
                                        <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                    </div>

                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                                    </div>

                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="contact" placeholder="Contact Number" required>
                                    </div>

                                    <div class=" mb-3">
                                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                                    </div>

                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Create Password" id="passwordHelpBlock" required>
                                    </div>

                                    <div class="">
                                        <button type="submit" class="btn btn-primary float-end">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            <div class="container-fluid mt-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-md-1">Company</th>
                                <th class="col-md-3">Email</th>
                                <th class="col-md-1">Contact</th>
                                <th class="col-md-2">Full Name</th>
                                <th class="col-md-1">Username</th>
                                <th class="col-md-1">Password</th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            @if ($user->role === 'owner' || $user->role === 'staff')
                                <tr>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ Str::limit($user->email, 25) }}</td>
                                    <td>{{ Str::limit($user->contact, 11) }}</td>
                                    <td>{{ Str::limit($user->name, 20) }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ Str::limit($user->password, 10) }}</td>
                                    <td class="d-flex justify-content-center gap-2">               
                                        <!-- Update Button -->
                                        <button class="btn btn-outline-primary" style="transition: 0.8s;" data-bs-toggle="modal" data-bs-target="#updateModal{{ $user->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- Soft Delete Button -->
                                        <form method="POST" action="{{ url('/users/soft-delete/{user}', $user->id) }}>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>  
                                </tr>
                                @include('owner.update-modal', ['user' => $user])
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container-fluid mt-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-md-1">Laborer</th>
                                <th class="col-md-3">Email</th>
                                <th class="col-md-1">Contact</th>
                                <th class="col-md-2">Full Name</th>
                                <th class="col-md-1">Username</th>
                                <th class="col-md-1">Password</th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if ($user->role === 'laborer')
                                    <tr>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ Str::limit($user->email, 25) }}</td>
                                        <td>{{ Str::limit($user->contact, 11) }}</td>
                                        <td>{{ Str::limit($user->name, 20) }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ Str::limit($user->password, 10) }}</td>
                                        <td class="d-flex justify-content-center gap-2">               
                                            <!-- Update Button -->
                                            <button class="btn btn-outline-primary" style="transition: 0.8s;" data-bs-toggle="modal" data-bs-target="#updateModal{{ $user->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Soft Delete Button -->
                                            <form method="POST" action="{{ url('/users/soft-delete/{user}', $user->id) }}>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>  
                                    </tr>

                                    @include('owner.update-modal', ['user' => $user])

                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
