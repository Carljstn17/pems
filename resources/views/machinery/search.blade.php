@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-tools"></i> <span class="d-sm-inline fs-5 head">Machinery | All Machinery</span>
    </div>

    <div class="pb-2 m-3">
        <div class="d-flex justify-content-between gap-2">
            <div>
                <p class="fs-5">Search Results for "{{ $query }}"</p>
            </div>

            <form action="{{ route('machinery.search') }}" method="GET">
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
                    <td><span class="bold">Machinery Type</span></td>  <!-- Update table header -->
                    <td><span class="bold">Property</span></td>
                    <td><span class="bold">Machinery Name</span></td>  <!-- Update table header -->
                    <td><span class="bold">Unit Cost</span></td>
                    <td><span class="bold">Status</span></td>
                    <td><span class="bold">Whereabouts</span></td>
                    <td></td>
                </tr>
            </thead>

            

            <tbody>
                @foreach($machineries as $machinery) 
                        <tr>
                            <td>{{ $machinery->machinery_type }}</td>  <!-- Update field name -->
                            <td>{{ $machinery->property }}</td>
                            <td>{{ $machinery->machinery_name }}</td>  <!-- Update field name -->
                            <td>{{ $machinery->unit_cost }}</td>
                            <td class="text-success">{{ $machinery->machineryReport->status }}</td>  <!-- Update field name -->
                            <td>{{ $machinery->machineryReport->whereabout }}</td>  <!-- Update field name -->
                            <td class="text-center">
                                <button class="btn btn-outline-dark" data-toggle="modal" data-target="#editMachineryModal{{ $machinery->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="editMachineryModal{{ $machinery->id }}" tabindex="-1" role="dialog" aria-labelledby="editMachineryModalLabel" aria-hidden="true">
                            <!-- Update modal ID and label -->
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editMachineryModalLabel">Edit Machinery - {{ $machinery->property }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body mt-2">
                                        <!-- Your edit form goes here -->
                                        <form action="{{ route('update.machinery', ['machinery' => $machinery->id]) }}" method="post">
                                            @csrf
                                            @method('PUT')
                    
                                            <!-- Input fields for editing -->
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <input type="text" class="form-control" name="status" value="{{ $machinery->machineryReport->status }}" required>
                                            </div>
                    
                                            <div class="mb-3">
                                                <label for="whereabout" class="form-label">Whereabout</label>
                                                <input type="text" class="form-control" name="whereabout" value="{{ $machinery->machineryReport->whereabout }}" required>
                                            </div>
                    
                                            <!-- Submit button -->
                                            <button type="submit" class="btn btn-primary">Update</button>
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
