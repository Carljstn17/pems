@extends('layout.staff')

    @section('content')
        <div class="">
            <div class="py-2 mt-2">
                <i class="fs-5 bi-buildings"></i> <span class=" d-sm-inline">Advance-Request | {{ $requests->id }}</span>
            </div>
            
            <div class="py-2 mt-3">
                <div class="card">
                    <div class="card-header text-center">
                        <p class="fs-5">Request by: {{ $requests->user->username }}</p>
                    </div>
                    
                    <div class="card-body mt-3 p-4">
                        <div class="input-group mb-4">
                            <label for="" class="input-group-text">Amount:</label>
                            <input type="number" name="amount" class="form-control" value="{{ $requests->amount }}" readonly>
                        </div>
                        <div class="input-group mb-4">
                            <label for="" class="input-group-text">Reason of Request:</label>
                            <input type="text" name="text" class="form-control" value="{{ $requests->text }}">
                        </div>
                        <div class="float-end mb-3">
                            <a href="" class="btn btn-outline-primary"><i class="bi bi-send"></i> Accept Request</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection


