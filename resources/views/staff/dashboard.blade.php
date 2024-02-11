@extends('layout.staff')

    @section('content')

    <div class="py-2 mt-2">
        <i class="fs-5 bi-speedometer2"></i> <span class="d-sm-inline">Dashboard | Staff</span>
    </div>

    

    <div class="mt-5 px-2">
        <div class="row-container gap-4">
            <div class=" shadow-sm bg-dark rounded-4 p-4">
                <p class="text-light">On-Going Project</p>
                <p class="text-light fs-5">{{ $projects }}</p>
            </div>
            <div class=" shadow-sm bg-secondary rounded-4 p-4">
                <p class="text-light">Latest Estimate</p>
                <p class="text-light fs-5">{{ $estimates }}</p>
            </div>
            <div class=" shadow-sm bg-success rounded-4 p-4">
                <p class="text-light">Latest Payroll</p>
                <p class="text-light fs-5">{{ $payrolls  }}</p>
            </div>
            <div class=" shadow-sm bg-primary rounded-4 p-4">
                <p class="text-light">Latest Receipt</p>
                <p class="text-light fs-5">{{ $receipts }}</p>
            </div>
        </div>
    </div>
        
    @endsection

