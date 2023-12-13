@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class="d-sm-inline">Estimate | Latest</span>
        </div>

            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                <a href="{{ url('/staff/estimate/new') }}" class="btn btn-outline-primary mt-3" style="transition:0.8s;"">
                    <span class="d-none d-sm-inline"><i class="bi bi-plus"></i>Add New Project</span>
                    <span class="d-sm-inline d-sm-none"><i class="bi bi-plus"></i>Add</span>
                </a>

                <form action="{{ route('estimate.search') }}" method="GET" class="mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>

            <h1 class="m-3">Search Results for "{{ $query }}"</h1>
        
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


