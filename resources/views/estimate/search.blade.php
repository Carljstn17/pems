@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class="d-sm-inline fs-5 head">Estimate | Latest</span>
        </div>

        <div class="pb-2 m-3">
            <div class="d-flex justify-content-between gap-2">
                <p class="fs-5">Search Results for "{{ $query }}"</p>

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


