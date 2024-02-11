@extends('layout.laborer')

@section('content')

    <div class="py-2 mt-2">
        <i class="fs-5 bi-envelope"></i></i> <span class="d-sm-inline">Advance Requests</span>
    </div>
    <div class="mt-3" style="width: 95%";>
        <div class="card">
            <div class="card-header text-center">
                <p class="fs-5">Remaining request/s for this month
                    <span class="fs-4 bold">-{{ 2 - $monthlyEntryCount }}</span>
                </p>
            </div>

            <div class="card-body p-5">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    <script>
                        // Reload the page after displaying the success message
                        setTimeout(function() {
                            location.reload();
                        }, 2000); // Reload after 2 seconds (adjust the time as needed)
                    </script>
                @endif

                <form action="{{ route('form.submitReq') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="number" name="amount" class="form-control" placeholder="Enter Amount">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" name="text" class="form-control" placeholder="What is the reason behind submitting this advance request?">
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-send"></i> Send Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection