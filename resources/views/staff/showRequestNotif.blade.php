@extends('layout.staff')

    @section('content')
        <div class="">
            <div class="py-2 mt-2">
                <i class="fs-5 bi-buildings"></i> <span class=" d-sm-inline">Advance-Request | {{ $requests->id }} </span>
                <span style="color: {{ $requests->status === 'pending' ? 'green' : 'blue' }}"> | {{ $requests->status }}</span>
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
                            <form action="{{ route('advanceAccept', $requests->id) }}" method="post" id="acceptRequestForm">
                                @csrf
                                @method('PUT')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">Accept Request</button>
                            </form>
                            
                            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to accept this advance request with the ID of <span class="bold">"{{ $requests->id }}"</span>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary" onclick="acceptRequest()">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
    function acceptRequest() {
        document.getElementById('acceptRequestForm').submit();
    }
</script>
@endsection


