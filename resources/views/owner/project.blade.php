@extends('layout.owner')

    @section('content')
        <div class="py-2 mt-2">
                <i class="fs-5 bi-buildings"></i> <span class="fs-5 head d-sm-inline">Ongoing Projects</span>
            </div>
            
            <div class="pb-2 m-3">
                <div class="d-flex justify-content-end">
                    
        
                    <form action="{{ route('owner.search.project') }}" method="GET">
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
                    <thead class="bs-secondaryd">
                        <tr>
                            <th scope="col"><span class="bold text-nowrap">Project - ID</span></th>
                            <th scope="col"><span class="bold text-nowrap">Description</span></th>
                            <th scope="col"><span class="bold text-nowrap">Created At</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project )
                            <tr data-url="{{ route('owner.showproject', $project->id) }}" class="clickable-row">
                                <td><span class="text-nowrap">{{ $project->project_id }}</span></td>
                                <td><span class="text-nowrap">{{ $project->project_dsc }}</span></td>
                                <td><span class="text-nowrap">{{ $project->created_at->diffForHumans() }}</span></td>
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
            
            <div class="px-3 d-flex justify-content-end">
                {{ $projects->links('vendor.pagination.bootstrap-4') }}
            </div>
@endsection
