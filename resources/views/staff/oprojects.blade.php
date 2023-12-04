<x-base2>

    <x-slot name="content">
        <div class="container-fluid">
            <div class="py-2">
                <i class="fs-4 bi-person-plus"></i> <span class="fs-4 d-sm-inline">On-Going Projects</span>

                <div class="container-fluid mt-5">
                    <div class="row-container gap-3">
                        @forelse ($projects as $project)
                            <div class="col-container shadow-sm bg-dark rounded-4 d-flex justify-content-center hover">
                                <a href="#" class="row text-decoration-none link-dark p-3">
                                    <div class="row text-light">
                                        <span class="fs-6 d-none d-sm-inline">ID: {{ $project->project_id }}</span>
                                        <span class="fs-6 d-sm-inline d-sm-none ">ID: {{ $project->project_id }}</span>
                                    </div>
                                    <div class="row p-2 text-light">
                                        <span class="fs-1 d-none d-sm-inline text-center">{{ Str::limit($project->project_dsc, 20) }}</span>
                                        <span class="fs-1 d-sm-inline d-sm-none text-center">  {{ Str::limit($project->project_dsc, 15) }}</span>
                                    </div>
                                    <div class="row text-secondary">
                                        <span class="fs-6 d-none d-sm-inline">Date: {{ $project->created_at->diffForHumans() }}</span>
                                        <span class="fs-6 d-sm-inline d-sm-none ">D: {{ $project->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                            </div>
                        @empty
                        <p>No projects yet.</p>
                        @endforelse

                        {{-- {{ $projects->links() }} --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end fixed-bottom p-4">
            <button class="btn btn-primary mb-2 py-3 px-5">
                <a href="{{ url('/staff/add-projects') }}" class="nav-link">Add New Project</a>
            </button><br>
            <button class="btn btn-primary py-3 px-5">View Old Project</button>
        </div>
    </x-slot>

    </x-base2>


