@extends('layout.staff')

    @section('content')
        <div class="py-2 mt-2">
            <div class="d-flex align-items-center">
                <a href="{{ route('latest.receipt') }}" class="text-secondary text-decoration-none btn">
                            <i class="fs-5 bi-backspace"></i>
                </a>
                <i class="fs-5 bi-person-plus me-1"></i> <span class="d-sm-inline text-nowrap fs-5 head">Receipt | New Entry</span>
            </div>
        </div>

        <div class="mt-3">
            <div class="card mx-auto p-4 mt-3">
                <p class="fs-5 py-3 px-2">Fillup this form to create receipt entry</p>
                <form method="POST" action="{{ route('entry.create') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                    <select name="project_id" id="project_id" class="form-select col col-md-2 col-sm-6">
                        <option value="">Select a project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->project_id }}
                                <span>&nbsp;-&nbsp; {{ $project->project_dsc }}</span>
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="border p-4 rounded">
                        <div class="mb-3">
                            <select class="form-select" id="description" name="description">
                                <option value="material" {{ old('description') == 'material' ? 'selected' : '' }}>Material</option>
                                <option value="permit" {{ old('description') == 'permit' ? 'selected' : '' }}>Permit</option>
                                <option value="machinery" {{ old('description') == 'machinery' ? 'selected' : '' }}>Gas</option>
                            </select>
                            @error('description')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 input-group">
                            <label for="amount" class="input-group-text">SI/OR NO:</label>
                            <input type="text" class="form-control" id="si_or_no" name="si_or_no" placeholder="SI/OR NO." maxlength="50" value="{{ old('si_or_no') }}">
                            @error('si_or_no')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror           
                        </div>
            
                        <div class="mb-3">
                            <select class="form-select" id="supplier" name="supplier_id">
                                <option value="">Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                            </select>
                            @error('description')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="mb-3 input-group">
                            <label for="amount" class="input-group-text">Amount:</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Receipt Amount" step=".01" max="999999" value="{{ old('amount') }}" pattern="\d+(\.\d{2})?">
                            @error('amount')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror  
                        </div>

                        <div class="input-group mb-3">
                            <label for="receipt_date" class="input-group-text">Receipt Date:</label>
                            <input type="date" class="form-control" id="entry_date" name="receipt_date" value="{{ old('receipt_date') }}">
                        </div>
                            @error('receipt_date')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror  
            
                        <div class="mb-3">
                            <input type="file" class="form-control" id="receipt_photo" name="receipt_photo" accept="image/*" value="{{ old('name') }}">
                            @error('receipt_photo')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror  
                        </div>
            
                        <button type="submit" class="btn btn-primary">Submit Entry</button>
                    </div>
                </form>
            </div>
        </div>
        
     <script>
    $('#amount').on('input', function() {
        var maxValue = parseFloat($(this).attr('max'));
        if (parseFloat($(this).val()) >= maxValue) {
            
            var inputValue = $(this).val().replace(/[^\d.]/g, '');
            $(this).val(inputValue.substring(0, 6));
        }
    });
    
    $('#amount').on('keydown', function(event) {
        if (event.key === 'e') {
            event.preventDefault();
        }
    });
</script>
@endsection

