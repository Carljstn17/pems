@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-card-checklist"></i> <span class=" d-sm-inline">Estimate Page</span>
        </div>
        <main class="mx-auto margin p-2" style="width:350px;">
            <div class="d-grid gap-3">
                <div class="row">
                    <a href="{{ url('/staff/estimate/latest') }}" class="btn btn-dark p-3">Latest Estimate</a>
                </div>
                <div class="row">
                    <a href="{{ url('/staff/estimate/new') }}" class="btn btn-dark p-3">New Estimate</a>
                </div>
                <div class="row">
                    <a href="{{ url('/staff/estimate/reject') }}" class="btn btn-dark p-3">Rejected Estimate</a>
                </div>
            </div>
        </main>
@endsection


