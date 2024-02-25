@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class="d-sm-inline">Estimate | Latest</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createEstimateModal" style="transition: 0.8s; display: inline-flex; align-items: center;" >
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline">Create New Estimate</span>
                    <span class="d-sm-inline d-sm-none">Create</span>
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
            
            <a href="{{ route('owner.estimateShow', ['group_id' => $firstEstimate->group_id]) }}" class="link-dark text-decoration-none">
                <div class="row p-4 d-flex justify-content-center rounded-2 border hover3 mb-2">
                    <div class="col-sm-12 mb-2 col-lg-3">
                        <span class="bold">Status: &nbsp</span>{{ $firstEstimate->status }}
                    </div>
                    <div class="col-sm-12 mb-2 col-lg-3">
                        <span class="bold">Entry ID: &nbsp</span>{{ $firstEstimate->group_id }}
                    </div>
                    <div class="col-sm-12 mb-2 col-lg-3">
                        <span class="bold">Entry by: &nbsp</span>{{ $firstEstimate->user->username }}
                    </div>
                    <div class="col-sm-12 mb-2 col-lg-3">
                        <span class="bold">Updated At: &nbsp</span>{{ $firstEstimate->updated_at->diffForHumans() }}
                    </div>
                </div>
            </a>
            
            @empty
            <div class="text-center my-5">
                <i class="bi bi-box"></i>
                <p class="no-text">No estimates yet.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-1 d-flex justify-content-end"">
            {{ $estimates->links('vendor.pagination.bootstrap-4') }}
        </div>

        <div class="mt-3 border-top border-subtle d-flex justify-content-end">
            <a href="{{ route('owner.estimateReject') }}" class="text-decoration-none mt-2 fst-italic">/View Rejected Estimate</a>
        </div>

@endsection

