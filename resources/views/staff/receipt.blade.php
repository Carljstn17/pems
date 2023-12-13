@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <i class="fs-5 bi-wallet"></i> <span class="d-sm-inline">Receipt Page</span>
        </div>
        <main class="mx-auto margin p-2" style="width:350px;">
            <div class="d-grid gap-3">
                <div class="row">
                    <a href="{{ url('/staff/payroll/latest') }}" class="btn btn-dark p-3">Latest Receipt</a>
                </div>
                <div class="row">
                    <a href="{{ url('/staff/payroll/new') }}" class="btn btn-dark p-3">New Receipt</a>
                </div>
                <div class="row">
                    <a href="{{ url('/staff/payroll/on-going') }}" class="btn btn-dark p-3">Old Receipt</a>
                </div>
            </div>
        </main>
@endsection

