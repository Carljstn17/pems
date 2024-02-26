@extends('layout.laborer')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-chat-left-dots"></i></i> <span class="d-sm-inline">Concerns</span>
    </div>
    <div class="mt-3">
        <div class="card">
            <div class="card-header text-center">
                <p class="fs-5">Remaining concern/s for this month
                    <span class="fs-4 bold">-{{ 1 - $monthlyEntryCount }}</span>
                </p>
            </div>
            <div class="card-body">
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
                    
                <form action="{{ route('form.submitConcern') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="concern" rows="14" style="resize: none"; placeholder="Enter your concern here..." required></textarea>
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-send"></i> Send Concern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
