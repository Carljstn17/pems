@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class="d-sm-inline">Estimate | Rejected</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <a href="{{ url('/staff/estimate/new') }}" class="btn btn-outline-primary" style="transition:0.8s;"">
                    <span class="d-none d-sm-inline"><i class="bi bi-plus"></i>Add New Project</span>
                    <span class="d-sm-inline d-sm-none"><i class="bi bi-plus"></i>Add</span>
                </a>

                <form action="{{ route('search.reject') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-3 pb-1 px-3">
            @foreach($estimatesReject as $group_id => $estimate)
                @php
                    $firstEstimate = $estimate;
                @endphp
            
                <a href="{{ route('show.reject', ['group_id' => $firstEstimate->group_id]) }}" class="link-dark text-decoration-none">
                    <div class="row p-4 d-flex justify-content-center rounded-2 border hover3 mb-2">
                        <div class="col">
                            <span class="bold">Status: &nbsp</span>{{ $firstEstimate->status }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry ID: &nbsp</span>{{ $firstEstimate->group_id }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry by: &nbsp</span>{{ $firstEstimate->user->username }}
                        </div>
                        <div class="col">
                            <span class="bold">Entry At: &nbsp</span>{{ $firstEstimate->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-1">
            {{ $estimatesReject->links('vendor.pagination.bootstrap-4') }}
        </div>

        <div class="mt-3 pt-2 border-top border-subtle d-flex justify-content-between">
            <a href="{{ route('latest') }}" class="text-decoration-none">View Latest Estimate</a>
        </div>

@endsection


