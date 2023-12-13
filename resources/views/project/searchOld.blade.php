@extends('layout.staff')

    @section('content')
        <div class="">
            <div class="mt-3">
                <i class="fs-4 bi-buildings"></i> <span class="fs-4 d-sm-inline">Projects | On-going</span>
            </div>

            <div class="d-flex justify-content-between border-bottom border-dark-subtle pb-3">
                <button class="btn btn-outline-primary py-2 px-3 mt-3" style="transition:0.5s;">
                    <a href="{{ url('/staff/add-projects') }}" class="nav-link">Add New Project</a>
                </button>

                <form action="{{ route('search.old') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control border-dark-subtle" name="query" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
            </div>

            <h1 class="m-3">Search Results for "{{ $query }}"</h1>

            <div class="mt-3">
                <div class="row-container gap-3">
                    @foreach ($results as $result)
                        <div class="col-container shadow-sm bg-dark rounded-4 d-flex hover2">
                            <a href="{{ url('/staff/show', $result->id) }}" class="row text-decoration-none link-dark p-3">
                                <div class="row text-light ">
                                    <span class="fs-6 d-none d-sm-inline">ID: {{ $result->project_id }}</span>
                                    <span class="fs-6 d-sm-inline d-sm-none ">ID: {{ $result->project_id }}</span>
                                </div>
                                <div class="row p-2 text-light mx-auto text-center">
                                    <span class="fs-1 d-none d-sm-inline">{{ Str::limit($result->project_dsc, 20) }}</span>
                                    <span class="fs-1 d-sm-inline d-sm-none">  {{ Str::limit($result->project_dsc, 15) }}</span>
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


