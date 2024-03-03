@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class=" d-sm-inline">Estimate | Rejected</span>
        </div>

            <div class="d-flex justify-content-between align-itemscenter border-bottom border-subtle pb-3 gap-2">
                <p class="fs-5">Search Results for "{{ $query }}"</p>

                <form action="{{ route('search.reject') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        <div class="row p-2 mt-3 gap-2">
            @foreach($estimates as $group_id => $estimate)
                @php
                    $firstEstimate = $estimate->first();
                @endphp
            
                <a href="{{ route('estimate.form', ['group_id' => $firstEstimate->group_id]) }}" class="link-dark text-decoration-none">
                    <div class="row p-4 d-flex justify-content-center rounded-2 border hover3">
                        <div class="col">
                            <span class="fw-bold">Status: &nbsp</span>{{ $firstEstimate->status }}
                        </div>
                        <div class="col">
                            <span class="fw-bold">Entry ID: &nbsp</span>{{ $firstEstimate->group_id }}
                        </div>
                        <div class="col">
                            <span class="fw-bold">Entry by: &nbsp</span>{{ $firstEstimate->user->username }}
                        </div>
                        <div class="col">
                            <span class="fw-bold">Entry At: &nbsp</span>{{ $firstEstimate->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @endforeach

        </div>

@endsection


