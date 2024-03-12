@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class=" d-sm-inline fs-5 head">Estimate | Rejected</span>
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
            <div class="table-responsive">
            <table class="table table-hover">
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
                        <tr data-url="{{ route('owner.estimateShow', ['group_id' => $firstEstimate->group_id]) }}" class="clickable-row">
                            <td>{{ $firstEstimate->status }}</td>
                            <td>{{ $firstEstimate->title }}</td>
                            <td>{{ $firstEstimate->user->username }}</td>
                            <td>{{ $firstEstimate->updated_at->diffForHumans() }}</td>
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

@endsection


