<x-base2>

    <x-slot name="content">
        <div class="">
            <div class="mt-3">
                <i class="fs-4 bi-buildings"></i> <span class="fs-4 d-sm-inline">Projects | On-going</span>
            </div>
           
            <div class="py-2">
                <div class="d-flex justify-content-between border-bottom border-dark-subtle pb-3 gap-2">
                        <a href="{{ url('/staff/add-projects') }}" class="btn btn-outline-primary mt-3" style="transition:0.8s;"">
                            <span class="d-none d-sm-inline"><i class="bi bi-plus"></i>Add New Project</span>
                            <span class="d-sm-inline d-sm-none"><i class="bi bi-plus"></i>Add</span>
                        </a>

                    <form action="{{ route('search') }}" method="GET" class="mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                        </div>
                    </form>

                </div>
                
                <div class="mt-3 border-bottom border-dark-subtle pb-3">
                    <div class="row-container gap-3">
                        @forelse ($projects as $project)
                            <div class="col-container shadow-sm bg-dark rounded-4 d-flex hover2">
                                <a href="{{ url('/staff/show', $project->id) }}" class="row text-decoration-none link-dark p-3">
                                    <div class="row text-light ">
                                        <span class="fs-6 d-none d-sm-inline">ID: {{ $project->project_id }}</span>
                                        <span class="fs-6 d-sm-inline d-sm-none ">ID: {{ $project->project_id }}</span>
                                    </div>
                                    <div class="row p-2 text-light mx-auto text-center">
                                        <span class="fs-1 d-none d-sm-inline">{{ Str::limit($project->project_dsc, 20) }}</span>
                                        <span class="fs-1 d-sm-inline d-sm-none">  {{ Str::limit($project->project_dsc, 15) }}</span>
                                    </div>
                                    <div class="row text-secondary">
                                        <span class="fs-6 d-none d-sm-inline">Date: {{ $project->created_at->diffForHumans() }}</span>
                                        <span class="fs-6 d-sm-inline d-sm-none ">D: {{ $project->created_at->diffForHumans() }}</span>
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

                <div class="mt-3">
                    <a href="{{ url('/staff/old-projects') }}" class="text-decoration-none">View Old Project</a>
                </div>

            </div>
        </div>
    </x-slot>

    </x-base2>


