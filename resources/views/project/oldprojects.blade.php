@extends('layout.staff')

    @section('content')
        <div class="">
            <div class="py-2 mt-2">
                <i class="fs-5 bi-buildings"></i> <span class="d-sm-inline">Projects | Old/Finished</span>
            </div>
           
            <div class="py-2 mt-3">
                <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                        <a href="{{ url('/staff/new-projects') }}" class="btn btn-outline-primary" style="transition:0.8s;"">
                            <span class="d-none d-sm-inline"><i class="bi bi-plus"></i>Add New Project</span>
                            <span class="d-sm-inline d-sm-none"><i class="bi bi-plus"></i>Add</span>
                        </a>

                    <form action="{{ route('search.old') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
                
                <div class="mt-3 pb-3">
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
                        <div class="text-center col-span">
                            <i class="fs-1 bi bi-box"></i>
                            <p>No on-going projects yet.</p>
                        </div>
                        @endforelse

                        {{-- {{ $projects->links() }} --}}
                    </div>
                </div>

                <div class="mt-1">
                    {{ $oldProjects->links('vendor.pagination.bootstrap-4') }}
                </div>

                <div class="mt-3 pt-2 border-top border-subtle">
                    <a href="{{ url('/staff/ongoing-projects') }}" class="text-decoration-none">View On-going Projects</a>
                </div>

            </div>
        </div>
@endsection


