@extends('layout.owner')

    @section('content')

        <div>
            <div class="py-2 mt-2">
                <i class="fs-5 bi-speedometer2"></i> <span class="d-sm-inline">Dashboard</span>
            </div>

            

            <div class="mt-5 pb-3">
                <p>On-Going Project</p>
                <div class="row-container gap-3">
                    @forelse ($projects as $project)
                        <div class="col-container shadow-sm bg-dark rounded-4 d-flex hover2">
                            <a href="{{ url('/staff/show', $project->id) }}" class="row text-decoration-none link-dark p-3">
                                <div class="row text-light ">
                                    <span class="fs-6 d-none d-sm-inline">ID: {{ $project->project_id }}</span>
                                    <span class="fs-6 d-sm-inline d-sm-none ">ID: {{ $project->project_id }}</span>
                                </div>
                                <div class="row p-2 text-light mx-auto text-center">
                                    <span class="fs-4 d-none d-sm-inline dsc">{{ Str::limit($project->project_dsc, 20) }}</span>
                                    <span class="fs-4 d-sm-inline d-sm-none dsc">  {{ Str::limit($project->project_dsc, 15) }}</span>
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
                </div>

                <div class="mt-1 float-end">
                    {{ $projects->links('vendor.pagination.bootstrap-4') }}
                </div>

            </div>

            <div class="p-2 mt-5 gap-2">
                <p>Latest Estimate</p>
                @foreach($estimates as $group_id => $estimate)
                    @php
                        $firstEstimate = $estimate->first();
                    @endphp
                
                    <a href="{{ route('estimate.form', ['group_id' => $firstEstimate->group_id]) }}" class="link-dark text-decoration-none">
                        <div class="row p-4 d-flex justify-content-center rounded-2 border border-subtle hover3">
                            <div class="col">
                                <span class="bold">Status: &nbsp</span>{{ $firstEstimate->status }}
                            </div>
                            <div class="col">
                                <span class="bold">Entry ID: &nbsp</span>{{ $firstEstimate->group_id }}
                            </div>
                            <div class="col">
                                <span class="bold">Entry by: &nbsp</span>{{ $firstEstimate->user->username }}
                            </div>
                            <div class="col">
                                <span class="bold">Updated At: &nbsp</span>{{ $firstEstimate->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                    @break
                @endforeach

            </div>
        </div>
        
        @endsection

