@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-tools"></i> <span class="d-sm-inline">Tools | All Tools</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <form action="" method="GET" class="">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>

                <div>
                    <button class="btn btn-outline-primary">LOGS</button>
                </div>
            </div>
        </div>

        <div class="table table-responsive mt-3 px-2">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <td><span class="bold">Tool Type</span></td>
                        <td><span class="bold">Property</span></td>
                        <td><span class="bold">Tool Name</span></td>
                        <td><span class="bold">Unit Cost</span></td>
                        <td><span class="bold">Status</span></td>
                        <td><span class="bold">Whereabouts</span></td>
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
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-1 float-end">
            {{ $tools->links('vendor.pagination.bootstrap-4') }}
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

