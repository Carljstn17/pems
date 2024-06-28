@extends('layout.owner')

    @section('content')

    <div class="py-2 mt-2">
        <i class="fs-5 bi-person-plus"></i> <span class="fs-5 head d-sm-inline">Account</span>
    </div>    

        <div class=" m-3 d-flex justify-content-between  gap-2">
            <div>
                <a class="btn btn-outline-dark text-nowrap" style="transition: 0.8s;" href="{{ route('owner.register.form')}}">
                    <span class="d-none d-sm-inline"><i class="bi bi-plus"></i>Register Account</span>
                    <span class="d-sm-inline d-sm-none"><i class="bi bi-plus"></i>Register</span>
                </a>
            </div>
            
            <div>
            <div class="input-group">
                <button class="btn btn-outline-dark" type="button">
                    <i class="bi bi-search"></i>
                </button>
                <input class="form-control border-dark-subtle" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">
            </div>
            </div>

        </div>

        <div class="p-2 mt-2">
            <div class="table-responsive">
                    <table class="table table-bordered" id="myTable">
                        <thead class="header">
                            <tr>
                                <th class="col-md-2">Username
                                    <div class="dropdown d-inline float-end">
                                        <i class="bi bi-funnel dropdown-toggle" id="filterDropdown" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                            <li><a class="dropdown-item {{ request('role') == 'all' ? 'active' : '' }}" href="#" data-role="all">All</a></li>
                                            <li><a class="dropdown-item {{ request('role') == 'owner' ? 'active' : '' }}" href="#" data-role="owner">Owner</a></li>
                                            <li><a class="dropdown-item {{ request('role') == 'staff' ? 'active' : '' }}" href="#" data-role="staff">Staff</a></li>
                                            <li><a class="dropdown-item {{ request('role') == 'laborer' ? 'active' : '' }}" href="#" data-role="laborer">Laborer</a></li>
                                        </ul>
                                    </div>
                                    
                                    <form id="filterForm" method="GET" action="{{ route('users.index') }}">
                                        @csrf
                                        <input type="hidden" name="role" id="roleInput">
                                    </form>
                                </th>
                                <th class="col-md-2">Fullname</th>
                                <th class="col-md-2">Email</th>
                                <th class="col-md-1">Contact</th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                  
                                    <td class="text-nowrap col-md-1" data-toggle="tooltip" title="{{ $user->username }}">{{ $user->username }}</td>
                                    <td class="text-nowrap col-md-2" data-toggle="tooltip" title="{{ $user->name }}">{{ $user->fname }} {{ $user->mname }} {{ $user->lname }}</td>
                                    <td class="text-nowrap col-md-3" data-toggle="tooltip" title="{{ $user->email }}">
                                        <span class="d-none d-sm-inline">{{ $user->email }}</span>
                                        <span class="d-sm-inline d-sm-none">{{ Str::limit($user->email, 8) }}</span>
                                    </td>
                                    
                                    <td class="text-nowrap col-md-1" data-toggle="tooltip" title="{{ $user->contact }}">
                                        <span class="d-none d-sm-inline">{{ Str::limit($user->contact, 11) }}</span>
                                        <span class="d-sm-inline d-sm-none">{{ Str::limit($user->contact, 8) }}</span>
                                    </td>
                                    <td class="d-flex justify-content-center gap-2">
   
                                        <a href="{{ route('owner.show.profile', $user->id) }}" class="link-dark" style="transition: 0.8s;">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        @if($user->role !== 'owner')
                                            <form id="deleteStaffForm{{ $user->id }}" method="POST" action="{{ route('owner.user-delete', ['user' => $user->id]) }}" style="border:none; background-color:white;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" style="border:none; background-color:white; color:red" onclick="confirmDeleteStaff({{ $user->id }})">
                                                    <i class="bi bi-trash3" style="border:none; background-color:white;"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>  
                                </tr>
                                @include('owner.update-modal', ['user' => $user])
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
        <div class="px-3 d-flex justify-content-end">
            {{ $users->links('vendor.pagination.bootstrap-4') }}
        </div>

        <script>
            function confirmDeleteStaff(userId) {
                var confirmation = confirm('Are you sure you want to delete this user?');
        
                if (confirmation) {
                    // Proceed with the form submission
                    document.getElementById('deleteStaffForm' + userId).submit();
                } else {
                    // Cancelled, do not proceed
                    console.log('Deletion cancelled');
                }
            }

            function confirmDeleteLaborer(userId) {
                var confirmation = confirm('Are you sure you want to delete this user?');
        
                if (confirmation) {
                    // Proceed with the form submission
                    document.getElementById('deleteLaborerForm' + userId).submit();
                } else {
                    // Cancelled, do not proceed
                    console.log('Deletion cancelled');
                }
            }
            
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        
        <script>
        function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
    
            // Loop through all table rows
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break; // Break the inner loop if a match is found
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
        
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', event => {
                const role = event.target.dataset.role;
                document.getElementById('roleInput').value = role;
                document.getElementById('filterForm').submit();
            });
        });
        </script>

@endsection
