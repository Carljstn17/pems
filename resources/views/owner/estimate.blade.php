@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class="d-sm-inline">Estimate | Latest</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createEstimateModal" style="transition: 0.8s;">
                    <span><i class="bi bi-plus"></i>Create New Estimate</span>
                </button>

                <form action="{{ route('estimate.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        @include('owner.estimateNew')
        
        <div class="mt-3 pb-1 px-3">
            @forelse($estimates as $group_id => $estimate)
                @php
                    $firstEstimate = $estimate->first();
                @endphp
            
                <a href="{{ route('estimate.form', ['group_id' => $firstEstimate->group_id]) }}" class="link-dark text-decoration-none">
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
                            <span class="bold">Updated At: &nbsp</span>{{ $firstEstimate->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @empty
            <p>No Latest Estimate yet.</p>
            @endforelse
        </div>

        {{-- <div class="mt-1">
            {{ $estimates->links('vendor.pagination.bootstrap-4') }}
        </div> --}}

        <div class="mt-3 border-top border-subtle d-flex justify-content-between">
            <a href="{{ route('reject') }}" class="text-decoration-none">View Rejected Estimate</a>
        </div>

@endsection

