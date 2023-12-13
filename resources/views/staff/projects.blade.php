@extends('layout.staff')

    @section('content')
        <div class="">
            <div class="py-2 mt-2">
                <i class="fs-5 bi-buildings"></i> <span class=" d-sm-inline">Project Page</span>
            </div>
            <main class="mx-auto margin p-2" style="width:350px;">
                <div class="d-grid gap-3">
                    <div class="row">
                        <a href="{{ url('/staff/ongoing-projects') }}" class="btn btn-dark p-3">On-Going Projects</a>
                    </div>
                    <div class="row">
                        <a href="{{ url('/staff/new-projects') }}" class="btn btn-dark p-3">New Projects</a>
                    </div>
                    <div class="row">
                        <a href="{{ url('/staff/old-projects') }}" class="btn btn-dark p-3">Old Projects</a>
                    </div>
                </div>
            </main>
        </div>
@endsection


