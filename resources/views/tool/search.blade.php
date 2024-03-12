@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-tools"></i> <span class="d-sm-inline fs-5 head">Tools | All Tools</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-between gap-2">
                <div>
                    <p class="fs-5">Search Results for "{{ $query }}"</p>
                </div>

                <form action="{{ route('tool.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-dark">Search</button>
                    </div>
                </form>
            </div>
        </div>

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
                    @foreach($tools as $tool) 
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
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body mt-2">
                                            <!-- Your edit form goes here -->
                                            <form action="{{ route('update.tool', ['tool' => $tool->id]) }}" method="post">
                                                @csrf
                                                @method('PUT')
                            
                                                <!-- Input fields for editing -->
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <input type="text" class="form-control" name="status" value="{{ $tool->toolReport->status }}" required>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="whereabout" class="form-label">Whereabout</label>
                                                    <input type="text" class="form-control" name="whereabout" value="{{ $tool->toolReport->whereabout }}" required>
                                                </div>
                            
                                                <!-- Submit button -->
                                                <button type="submit" class="btn btn-primary my-2 float-end">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

