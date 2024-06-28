@extends('layout.staff')

    @section('content')

    <div class="py-2 mt-2">
        <i class="fs-5 bi-person-plus"></i> <span class="d-sm-inline fs-5 head">Account | Laborer only | {{ $selectedProject->project_dsc ?? '' }}</span> 
    </div>    
        
        <div class=" m-3 d-flex justify-content-between  gap-2">
            <div>
                <a class="btn btn-outline-dark text-nowrap" style="transition: 0.8s;" href="{{ route('staff.register.form')}}">
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
                                <th class="col-md-1">Username
                                    <div class="dropdown d-inline float-end" id="selectedProject">
                                        <i class="bi bi-funnel dropdown-toggle" id="filterDropdown" data-bs-toggle="dropdown" style="cursor: pointer;"></i>
                                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                                <li><a class="dropdown-item {{ request('project_id') == '' ? 'active' : '' }}" href="#" data-role="all" onclick="selectProject('', 'All')">All</a></li>
                                            @foreach($projects as $project)
                                                <li><a class="dropdown-item {{ request('project_id') == $project->id ? 'active' : '' }}" href="#" onclick="selectProject('{{ $project->id }}', '{{ $project->project_id }} - {{ $project->project_dsc }}')">{{ $project->project_id }} - {{ $project->project_dsc }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    
                                    <form id="filterForm" method="GET" action="{{ route('users.filter') }}">
                                        @csrf
                                        <input type="hidden" name="project_id" id="projectIdInput" value="{{ request('project_id') }}">
                                    </form>
                                </th>
                                <th class="col-md-2">FullName</th>
                                <th class="col-md-2">Email</th>
                                <th class="col-md-1">Contact</th>
                                <th class="col-md-1"></th>
                            </tr>
                        </thead>
                    <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-nowrap col-md-1" data-toggle="tooltip" title="{{ $user->username }}">{{ $user->username }}</td>
                                    <td class="text-nowrap col-md-2" data-toggle="tooltip" title="{{ $user->name }}">{{ $user->lname }} {{ $user->fname }} {{ $user->mname }}</td>
                                    <td class="text-nowrap col-md-3" data-toggle="tooltip" title="{{ $user->email }}">
                                        <span class="d-none d-sm-inline">{{ $user->email }}</span>
                                        <span class="d-sm-inline d-sm-none">{{ Str::limit($user->email, 8) }}</span>
                                        </td>
                                        <span class="d-none d-sm-inline">{{ Str::limit($user->name, 20) }}</span>
                                        <span class="d-sm-inline d-sm-none">{{ Str::limit($user->name, 8) }}</span>
                                    </td>
                                    <td class="text-nowrap col-md-1" data-toggle="tooltip" title="{{ $user->contact }}">
                                        <span class="d-none d-sm-inline">{{ Str::limit($user->contact, 11) }}</span>
                                        <span class="d-sm-inline d-sm-none">{{ Str::limit($user->contact, 8) }}</span>
                                    </td>
                                    <td class="d-flex justify-content-center gap-2">
   
                                        <a href="{{ route('staff.show.profile', $user->id) }}" class="link-dark" style="transition: 0.8s;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        @if((Auth::user() && Auth::user()->srole == 1))
                                            <form id="deleteStaffForm{{ $user->id }}" method="POST" action="{{ route('owner.user-delete', ['user' => $user->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger" onclick="confirmDeleteStaff({{ $user->id }})">
                                                    <i class="bi bi-trash3"></i>
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
        
        function selectProject(projectId, projectDesc) {
            document.getElementById("selectedProject").innerText = projectDesc;
            document.getElementById("projectIdInput").value = projectId;
            document.getElementById("filterForm").submit();
        }
        </script>
@endsection
