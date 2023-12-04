<x-base>
    <x-slot name="content">
        <div class="container-fluid mt-2">
            <div class="py-2">
                <i class="fs-4 bi-person-plus"></i> <span class="fs-4 d-sm-inline">Account</span>
            </div>

            <form method="POST" action="{{ url('/owner/register') }}" class="container-fluid bg-white rounded">
                @csrf
                <div class="row p-3">
                    <p class="fs-5">Register</p>

                    <div class="col-12 col-md-3 mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Register Name" required>
                    </div>

                    <div class="col-12 col-md-3 mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Register Email" required>
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
                                <th scope="col">Role</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Password</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->role }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ Str::limit($user->password, 6) }}</td>
                                    <td class="col col-md-3 px-5">
                                        <!-- Update Button -->
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success mb-2 mb-sm-0">Update</a>
                                        <!-- Soft Delete Button -->
                                        <form method="POST" action="{{ url('/users/soft-delete/{user}', $user->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </x-slot>
</x-base>
