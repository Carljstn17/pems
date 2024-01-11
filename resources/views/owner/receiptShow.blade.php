@extends('layout.owner')

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
    
                <form action="{{ route('updateReceiptRemarks', $receipts->id) }}" method="post" id="updateRemarksForm">
                    @csrf
                    @method('PUT')
                
                    <button type="button" class="btn btn-danger" onclick="confirmUpdateRemarks()">Incorrect</button>
                </form>
            </div>

            @include('receipt.image-modal')
        </div>        
    </div>

    <script>
        function confirmUpdateRemarks() {
            var confirmation = confirm("Are you sure you want to update the remarks to 'invalid' for this batch and 'add' for advances?");
    
            if (confirmation) {
                document.getElementById('updateRemarksForm').submit();
            } else {
                // Optionally, you can provide feedback to the user that the update was canceled.
                alert("Update canceled. Remarks remain unchanged.");
                return false;
            }
        }
    </script>
@endsection