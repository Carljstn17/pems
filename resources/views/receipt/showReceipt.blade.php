@extends('layout.staff')

@section('content')
    <div class="py-2 mt-2">
        <i class="fs-5 bi-receipt"></i> <span class="d-sm-inline">Receipt | ID: {{ $receipts->id }}</span>
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
        
            <div class="mb-3 input-group">
                <img src="{{ asset('storage/' . $receipts->receipt_photo) }}" alt="Receipt Photo">
            </div>
        </div>        
    </div>
@endsection