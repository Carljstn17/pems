@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline">Receipt | ID: {{ $receipts->id }}</span>
        <span style="color: {{ $receipts->remarks === 'valid' ? 'green' : 'red' }}"> | {{ $receipts->remarks }}</span>
    </div>

    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary text-decoration-none px-3">
            <i class="bi-backspace"> back</i>
        </a>
        <div class="border mt-2 p-4 rounded">
            
            <div class="mb-3 input-group">
                <span class="input-group-text">Project:</span>
                <input type="text" class="form-control" value="{{ $receipts->project->project_id }}&nbsp;-&nbsp; {{ $receipts->project->project_dsc }}" readonly>
            </div>
        
            <div class="mb-3 input-group">
                <span class="input-group-text">Category:</span>
                <input type="text" class="form-control" value="{{ $receipts->description }}" readonly>
            </div>
        
            <div class="mb-3 input-group">
                <span class="input-group-text">SI/OR NO.:</span>
                <input type="text" class="form-control" value="{{ $receipts->si_or_no }}" readonly>
            </div>
        
            <div class="mb-3 input-group">
                <span class="input-group-text">Supplier:</span>
                <input type="text" class="form-control" value="{{ $receipts->supplier->name }}" readonly>
            </div>
        
            <div class="mb-3 input-group">
                <span class="input-group-text">Receipt Amount:</span>
                <input type="number" class="form-control" value="{{ $receipts->amount }}" readonly>
            </div>
        
            <div class="mb-3 input-group">
                <span class="input-group-text">Receipt Date:</span>
                <input type="date" class="form-control" value="{{ $receipts->receipt_date }}" readonly>
            </div>
        
            <div class="d-flex justify-content-between">
                <div class="input-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageModal">
                        View Receipt Photo
                    </button>
                </div>
    
                @if(Auth::user() && Auth::user()->id == $receipts->user_id)
                    <form action="{{ route('updateReceiptRemarks', $receipts->id) }}" method="post" id="updateRemarksForm">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal">Incorrect</button>
                    </form>

                    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to update the remarks to 
                                    <span class="bold text-danger">'invalid'</span>  for this receipt id 
                                    <span class="bold">"{{ $receipts->id }}"</span>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" onclick="updateReceiptRemarks()">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            

            @include('receipt.image-modal')
        </div>        
    </div>

    <script>
        function updateReceiptRemarks() {
            document.getElementById('updateRemarksForm').submit();
        }
    </script>
@endsection