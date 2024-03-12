@extends('layout.owner')

    @section('content')

            <div class="py-2 mt-2">
                <i class="fs-5 bi-speedometer2"></i> <span class="fs-5 head d-sm-inline">Dashboard</span>
            </div>

            <div class="mt-2 p-3">
                <div class="row-container gap-5">
                    <div class="row shadow-sm bg-dark rounded-4 p-4">
                        <p class="text-light">On-Going Project</p>
                        <p class="text-light fs-5">{{ $projects }}</p>
                    </div>
                    <div class="row shadow-sm bg-success rounded-4 p-4">
                        <p class="text-light">Latest Estimate</p>
                        <p class="text-light fs-5">{{ $estimates }}</p>
                    </div>
                    <div class="row shadow-sm bg-secondary rounded-4 p-4">
                        <p class="text-light">Latest Payroll</p>
                        <p class="text-light fs-5">{{ $payrolls  }}</p>
                    </div>
                    <div class="row shadow-sm bg-primary rounded-4 p-4">
                        <p class="text-light">Latest Receipt</p>
                        <p class="text-light fs-5">{{ $receipts }}</p>
                    </div>
                </div>
            </div>
@endsection
