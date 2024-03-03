@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-tools"></i> <span class="d-sm-inline">Tools | All Tools</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <p class="fs-5">Search Results for "{{ $query }}"</p>
                <form action="{{ route('owner.search.tool') }}" method="GET" class="">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table table-responsive mt-3 px-2">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <td>
                            <span class="bold d-none d-sm-inline">Tool&nbspType</span>
                            <span class="bold d-inline d-sm-none">T-&nbspType</span>
                        </td>
                        <td><span class="bold">Property</span></td>
                        <td>
                            <span class="bold d-none d-sm-inline">Tool&nbspName</span>
                            <span class="bold d-inline d-sm-none">T-&nbspName</span>
                        </td>
                        <td><span class="bold">Unit&nbspCost</span></td>
                        <td><span class="bold">Status</span></td>
                        <td><span class="bold">Whereabouts</span></td>
                    </tr>
                </thead>
                <tbody>
                        @foreach($tools as $tool)
                            <tr>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $tool->tool_type }}">{{ Str::limit($tool->tool_type, 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $tool->property }}">{{ Str::limit($tool->property, 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $tool->tool_name }}">{{ Str::limit($tool->tool_name, 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $tool->unit_cost }}">{{ Str::limit(number_format($tool->unit_cost, 2), 8) }}</td>
                                <td class="text-success text-nowrap" data-toggle="tooltip" title="{{ $tool->toolReport->status }}">{{ Str::limit($tool->toolReport->status, 8) }}</td>
                                <td class="text-nowrap" data-toggle="tooltip" title="{{ $tool->toolReport->whereabout }}">{{ Str::limit($tool->toolReport->whereabout, 8) }}</td>
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

