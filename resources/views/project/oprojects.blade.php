<x-base2>

    <x-slot name="content">
        <div class="">
            <div class="mt-3">
                <i class="fs-4 bi-person-plus"></i> <span class="fs-4 d-sm-inline">On-Going Projects</span>
            </div>
           
            <div class="py-2">
                <div class="mt-5">
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
                        <p>No projects yet.</p>
                        @endforelse

                        {{-- {{ $projects->links() }} --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end fixed-bottom p-4 d-none d-sm-inline">
            <button class="btn btn-primary mb-2 py-3 px-5">
                <a href="{{ url('/staff/add-projects') }}" class="nav-link">Add New Project</a>
            </button><br>
            <button class="btn btn-primary py-3 px-5">View Old Project</button>
        </div>

        <div class="text-end fixed-bottom p-4 d-sm-inline d-sm-none">
            <button class="btn btn-primary mb-2 p-2">
                <a href="{{ url('/staff/add-projects') }}" class="nav-link">Add New</a>
            </button><br>
            <button class="btn btn-primary p-2">View Old</button>
        </div>
    </x-slot>

    </x-base2>


