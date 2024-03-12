@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-tools"></i> <span class="d-sm-inline fs-5 head">Machinery | All Machinery</span>
    </div>

    <div class="pb-2 m-3">
        <div class="d-flex justify-content-between gap-2">
            <p class="fs-5">Search Results for "{{ $query }}"</p>
            <form action="{{ route('owner.searchMachinery') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                    <button type="submit" class="btn btn-outline-dark">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table table-responsive mt-3 px-2">
        <table class="table table-bordered">
            <thead>
                <tr class="text-center">
                    <td>
                        <span class="bold d-none d-sm-inline">Machinery&nbspType</span>
                        <span class="bold d-inline d-sm-none">M-&nbspType</span>
                    </td>  
                    <td><span class="bold">Property</span></td>
                    <td>
                        <span class="bold d-none d-sm-inline">Machinery&nbspName</span>
                        <span class="bold d-inline d-sm-none">M-&nbspName</span>
                        </td> 
                    <td><span class="bold ">Unit&nbspCost</span></td>
                    <td><span class="bold">Status</span></td>
                    <td><span class="bold">Whereabouts</span></td>
                </tr>
            </thead>
            <tbody>
                    @foreach($machineries as $machinery) 
                        <tr>
                            <td class="text-nowrap" data-toggle="tooltip" title="{{ $machinery->machinery_type }}">{{ Str::limit($machinery->machinery_type, 8) }}</td>
                            <td class="text-nowrap" data-toggle="tooltip" title="{{ $machinery->property }}">{{ Str::limit($machinery->property, 8) }}</td>
                            <td class="text-nowrap" data-toggle="tooltip" title="{{ $machinery->machinery_name }}">{{ Str::limit($machinery->machinery_name, 8) }}</td>
                            <td class="text-nowrap" data-toggle="tooltip" title="{{ $machinery->unit_cost }}">{{ Str::limit($machinery->unit_cost, 8) }}</td>
                            <td class="text-success text-nowrap" data-toggle="tooltip" title="{{ $machinery->machineryReport->status }}">{{ Str::limit($machinery->machineryReport->status, 8) }}</td>
                            <td class="text-nowrap" data-toggle="tooltip" title="{{ $machinery->machineryReport->whereabout }}">{{ Str::limit($machinery->machineryReport->whereabout, 8) }}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
