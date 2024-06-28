@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-tools"></i> <span class="d-sm-inline fs-5 head">Tools | All Tools</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-between gap-2">
                <div>
                    <button class="btn btn-outline-dark" style="transition: 0.8s;" data-bs-toggle="modal" data-bs-target="#addToolsModal">
                        <span><i class="bi bi-plus"></i>Add Tools</span>
                    </button>
                </div>

                <form action="{{ route('tool.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-dark">Search</button>
                    </div>
                </form>
            </div>
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
        
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @include('tool.create_tools_modal')
        <div class="table table-responsive mt-3 pb-1 px-3">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <td><span class="bold">Tool Type</span></td>
                        <td><span class="bold">Property</span></td>
                        <td><span class="bold">Tool Name</span></td>
                        <td><span class="bold">Unit Cost</span></td>
                        <td><span class="bold">Status</span></td>
                        <td><span class="bold">Whereabouts</span></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($toolsByType as $toolType => $toolsInType) 
                        @foreach($toolsInType as $tool)
                            <tr>
                                <td>{{ $tool->tool_type }}</td>
                                <td>{{ $tool->property }}</td>
                                <td>{{ $tool->tool_name }}</td>
                                <td>{{ $tool->unit_cost }}</td>
                                <td class="text-success">{{ $tool->toolReport->status }}</td>
                                <td>{{ $tool->toolReport->whereabout }}</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-dark" data-toggle="modal" data-target="#editToolModal{{ $tool->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>                
                                </td>
                            </tr>

                            <div class="modal fade" id="editToolModal{{ $tool->id }}" tabindex="-1" role="dialog" aria-labelledby="editToolModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editToolModalLabel">Edit Tool - {{ $tool->property }}</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body mt-2">
                                            <!-- Your edit form goes here -->
                                            <form action="{{ route('update.tool', ['tool' => $tool->id]) }}" method="post">
                                                @csrf
                                                @method('PUT')
                            
                                                <!-- Input fields for editing -->
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                        <option value="New" {{ $tool->toolReport->status == 'New' ? 'selected' : '' }}>New</option>
                                                        <option value="Available" {{ $tool->toolReport->status == 'Available' ? 'selected' : '' }}>Available</option>
                                                        <option value="On Work" {{ $tool->toolReport->status == 'On Work' ? 'selected' : '' }}>On Work</option>
                                                        <option value="Not Available" {{ $tool->toolReport->status == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                                                    </select>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="whereabout" class="form-label">Whereabout</label>
                                                    <input type="text" class="form-control" name="whereabout" id="whereabout" value="{{ $tool->toolReport->whereabout }}" required>
                                                    <input type="text" class="form-control" name="whereabout" placeholder="Enter whereabout" value="{{ old('whereabout') }}" id="whereabout" >
                                                    @error('whereabout')
                                                        <div class="text-danger px-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                            
                                                <!-- Submit button -->
                                                <button type="submit" class="btn btn-primary my-2 float-end">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        
        
        <div class="mt-1 float-end">
            {{ $tools->links('vendor.pagination.bootstrap-4') }}
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function storeInputValues() {
                sessionStorage.setItem('status', document.getElementById('status').value);
                sessionStorage.setItem('whereabout', document.getElementById('whereabout').value);
            }
        
            // Function to retrieve and populate input values when modal is shown
            function populateInputValues() {
                document.getElementById('status').value = sessionStorage.getItem('status');
                document.getElementById('whereabout').value = sessionStorage.getItem('whereabout');
            }
        </script>
@endsection

