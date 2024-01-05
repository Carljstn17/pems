@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline">Payroll | On-going Project Payroll</span>
        </div>

        <div class="py-2 mt-3">
            <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                    <a href="{{ url('/staff/payroll/new') }}" class="btn btn-outline-primary" style="transition:0.8s;"">
                        <span><i class="bi bi-plus"></i>Create New Payroll</span>
                    </a>

                <form action="" method="GET" >
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-2 pb-3 gap-2 border-bottom border-subtle">
            <div class="row-container gap-3">
                @forelse ($projects as $project)
                    <div class="col-container shadow-sm bg-dark rounded-4 d-flex hover2">
                        <a href="{{ route('project.payroll', $project->id) }}" class="row text-decoration-none link-dark p-3">
                            <div class="row text-light ">
                                <span class="fs-6 d-none d-sm-inline">ID: {{ $project->project_id }}</span>
                                <span class="fs-6 d-sm-inline d-sm-none ">ID: {{ $project->project_id }}</span>
                            </div>
                            <div class="row p-2 text-light mx-auto text-center">
                                <span class="fs-4 d-none d-sm-inline">{{ Str::limit($project->project_dsc, 20) }}</span>
                                <span class="fs-4 d-sm-inline d-sm-none">  {{ Str::limit($project->project_dsc, 15) }}</span>
                            </div>
                            <div class="row text-secondary">
                                <span class="fs-6 d-none d-sm-inline">Date: {{ $project->created_at->diffForHumans() }}</span>
                                <span class="fs-6 d-sm-inline d-sm-none ">D: {{ $project->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    </div>
                @empty
                <div class="text-center">
                    <i class="bi bi-box"></i>
                    <p class="no-text">No payroll for on-going projects yet.</p>
                </div>
                @endforelse
            </div>
        </div>       
        
        <div class="mt-1">
            {{ $projects->links('vendor.pagination.bootstrap-4') }}
        </div>
        
        <div class="mt-3">
            <a href="{{ route('latest.payroll') }}" class="text-decoration-none mt-2">/View latest Payroll</a>
        </div>
       
@endsection


