@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-tools"></i> <span class="d-sm-inline">Machinery | All Machinery</span>
    </div>

    <div class="py-2 mt-3">
        <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
            <form action="{{ route('machinery.search') }}" method="GET">
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
                    <td><span class="bold">Machinery Type</span></td>  <!-- Update table header -->
                    <td><span class="bold">Property</span></td>
                    <td><span class="bold">Machinery Name</span></td>  <!-- Update table header -->
                    <td><span class="bold">Unit Cost</span></td>
                    <td><span class="bold">Status</span></td>
                    <td><span class="bold">Whereabouts</span></td>
                </tr>
            </thead>
            <tbody>
                @foreach($machineriesByType as $machineryType => $machineriesInType)  <!-- Update variable names -->
                    @foreach($machineriesInType as $machinery)  <!-- Update variable names -->
                        <tr>
                            <td>{{ $machinery->machinery_type }}</td>  <!-- Update field name -->
                            <td>{{ $machinery->property }}</td>
                            <td>{{ $machinery->machinery_name }}</td>  <!-- Update field name -->
                            <td>{{ $machinery->unit_cost }}</td>
                            <td class="text-success">{{ $machinery->machineryReport->status }}</td>  <!-- Update field name -->
                            <td>{{ $machinery->machineryReport->whereabout }}</td>  <!-- Update field name -->
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-1 float-end">
        {{ $machineries->links('vendor.pagination.bootstrap-4') }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
