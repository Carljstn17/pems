@extends('layout.owner')

@section('content')
    <div class="py-2 mt-2">
        <div class="d-flex align-items-center">
            <div class="d-sm-none me-2">
                <a href="{{ url()->previous() }}" class="text-secondary text-decoration-none">
                    <i class="bi-backspace"></i>
                </a>
            </div>
            <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline fs-5 head">Receipt | ID: {{ $receipts->id }}  |</span>
            <span class="fs-5 head" style="color: {{ $receipts->remarks === 'valid' ? 'green' : 'red' }}"> {{ $receipts->remarks }}</span>
            
        </div>
    </div>

    <div class="mt-4">
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th >
                        <span class="bold text-nowrap">Project ID</span>
                    </th>
                    <th>
                        <span class="bold text-nowrap">Project Description</span>
                    </th>
                    <th>
                        <span class="bold text-nowrap">Entry By:</span>
                    </th>
                    <th >
                        <span class="bold">Date</span>
                    </th>
                </thead>
                <tbody>
                    <td >
                        <span>{{ $receipts->project->project_id }}</span>
                    </td>
                    <td>
                        <span>{{ $receipts->project->project_dsc }}</span>
                    </td>
                    <td >
                        <span>{{ $receipts->user->name }}</span>
                    </td>
                    <td >
                        <span>{{ $receipts->created_at->format('Y-m-d') }}</span>
                    </td>
                </tbody>
            </table>
        </div>
                
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
    
                @if($receipts->remarks !== 'invalid')
                    <form action="{{ route('updateReceiptRemarks', $receipts->id) }}" method="post" id="updateRemarksForm">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-danger text-nowrap" data-bs-toggle="modal" data-bs-target="#confirmationModal">Incorrect</button>
                    </form>
                @else
                    <span class="text-danger text-nowrap" >This receipt is invalid.</span>
                @endif


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