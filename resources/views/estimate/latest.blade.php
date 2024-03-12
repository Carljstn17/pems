@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class="d-sm-inline fs-5 head">Estimate | Latest</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('staff.estimate.form') }}" class="btn btn-outline-dark" style="transition: 0.8s;">
                    <span><i class="bi bi-plus text-nowrap"></i>Create New Estimate</span>
                </a>

                <form action="{{ route('estimate.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-dark">Search</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-3 pb-1 px-3">

            <div class="table-responsive">
            <table class="table table-hover"  id="estimateTable">
                <thead>
                    <tr>
                        <th scope="col"><span class="bold text-nowrap">Status</span></th>
                        <th scope="col"><span class="bold text-nowrap">Title</span></th>
                        <th scope="col"><span class="bold text-nowrap">Entry By</span></th>
                        <th scope="col"><span class="bold text-nowrap">Date</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estimates as $group_id => $estimate)
                        @php
                            $firstEstimate = $estimate->first();
                        @endphp
                        <tr data-url="{{ route('estimate.form', ['group_id' => $firstEstimate->group_id]) }}" class="clickable-row">
                            <td><span class="text-nowrap">{{ $firstEstimate->status }}</span></td>
                            <td><span class="text-nowrap">{{ $firstEstimate->title }}</span></td>
                            <td><span class="text-nowrap">{{ $firstEstimate->user->username }}</span></td>
                            <td><span class="text-nowrap">{{ $firstEstimate->updated_at->diffForHumans() }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center my-5">
                                <i class="bi bi-box"></i>
                                <p class="no-text">No estimates yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <div class="px-3 d-flex justify-content-between">
            <a href="{{ route('reject') }}" class="link-secondary text-decoration-none fst-italic">
                <span class="d-none d-sm-inline text-nowrap">/View Rejected Estimate</span>
                <span class="d-sm-inline d-sm-none">/Rejected</span>
            </a>
            {{ $estimates->links('vendor.pagination.bootstrap-4') }}
        </div>

@endsection

