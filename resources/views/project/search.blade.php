@extends('layout.staff')

    @section('content')
        <div class="">
            <div class="mt-3">
                <i class="fs-5 bi-buildings"></i> <span class=" d-sm-inline">Projects | On-going</span>
            </div>

            <div class="py-2 mt-3">
                <div class="d-flex justify-content-between border-bottom border-subtle pb-3 gap-2">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        <span><i class="bi bi-plus"></i> Add New Project</span>
                    </button>

                    <form action="{{ route('search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                            <button type="submit" class="btn btn-outline-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            @include('project.nprojects')

            <p class="fs-5">Search Results for "{{ $query }}"</p>

            <div class="mt-3">
                <div class="row-container gap-3">
                    @foreach ($results as $result)
                        <div class="col shadow-sm bg-dark rounded-4 d-flex hover2">
                            <a href="{{ url('/staff/show', $result->id) }}" class="row text-decoration-none link-dark p-3">
                                <div class="row text-light ">
                                    <span class="fs-6 d-none d-sm-inline">ID: {{ $result->project_id }}</span>
                                    <span class="fs-6 d-sm-inline d-sm-none ">ID: {{ $result->project_id }}</span>
                                </div>
                                <div class="row p-2 text-light mx-auto text-center">
                                    <span class="fs-4 d-none d-sm-inline">{{ Str::limit($result->project_dsc, 20) }}</span>
                                    <span class="fs-4 d-sm-inline d-sm-none">  {{ Str::limit($result->project_dsc, 15) }}</span>
                                </div>
                                <div class="row text-secondary">
                                    <span class="fs-6 d-none d-sm-inline">Date: {{ $result->created_at->diffForHumans() }}</span>
                                    <span class="fs-6 d-sm-inline d-sm-none ">D: {{ $result->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        </div>

                    @endforeach

                    {{-- {{ $projects->links() }} --}}
                </div>
            </div>
@endsection


