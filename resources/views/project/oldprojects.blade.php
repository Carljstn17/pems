@extends('layout.staff')

    @section('content')
        <div class="">
            <div class="py-2 mt-2">
                <i class="fs-5 bi-buildings"></i> <span class="d-sm-inline fs-5 head">Projects | Old/Finished</span>
            </div>
           
            <div class="py-2 mt-3">
                <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                    <a href="{{ route('add-project') }}" class="btn btn-outline-dark">
                        <span><i class="bi bi-plus"></i> Add New Project</span>
                    </a>

                    <form action="{{ route('search.old') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                            <button type="submit" class="btn btn-outline-dark">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('project.nprojects')
                
                <div class="mt-2 pb-3 gap-2 border-bottom border-subtle">
                    <div class="row-container gap-3">
                    @forelse ($oldProjects as $oldProject)

                            <div class="col-container shadow-sm bg-dark rounded-4 d-flex hover2">
                                <a href="{{ route('show-old', $oldProject->id) }}" class="row text-decoration-none link-dark p-3">
                                    <div class="row text-light ">
                                        <span class="fs-6 d-none d-sm-inline">ID: {{ $oldProject->project_id }}</span>
                                        <span class="fs-6 d-sm-inline d-sm-none ">ID: {{ $oldProject->project_id }}</span>
                                    </div>
                                    <div class="row p-2 text-light mx-auto text-center">
                                        <span class="fs-4 d-none d-sm-inline dsc">{{ Str::limit( $oldProject->project_dsc, 20) }}</span>
                                        <span class="fs-4 d-sm-inline d-sm-none dsc">  {{ Str::limit( $oldProject->project_dsc, 15) }}</span>
                                    </div>
                                    <div class="row text-secondary">
                                        <span class="fs-6 d-none d-sm-inline">Date: {{ $oldProject->created_at->diffForHumans() }}</span>
                                        <span class="fs-6 d-sm-inline d-sm-none ">D: {{ $oldProject->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            </div>
                        
                        @empty
                        <div class="text-center">
                            <i class="bi bi-box"></i>
                            <p class="no-text">No on-going projects yet.</p>
                        </div>
                    @endforelse
                </div>
                        {{-- {{ $projects->links() }} --}}
                    
                </div>

                <div class="mt-1">
                    {{ $oldProjects->links('vendor.pagination.bootstrap-4') }}
                </div>

                <div class="mt-3 px-3">
                    <a href="{{ url('/staff/ongoing-projects') }}" class="text-decoration-none text-secondary fst-italic">/View On-going Projects</a>
                </div>

            </div>
        </div>
@endsection


