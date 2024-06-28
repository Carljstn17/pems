<div class="modal fade" id="updateReceiptModal" tabindex="-1" aria-labelledby="updateReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateReceiptModalLabel">Update Receipt | ID: {{ $receipts->id }}  | </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('updateReceipt', ['id' => $receipts->id]) }}" enctype="multipart/form-data" id="updateReceipt">
                    @csrf
                    @method('PUT')
                        <div class="mb-3 input-group">
                            <span class="input-group-text">Project:</span>
                            <select class="form-select" id="project_id" name="project_id">
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ $project->id == $project->id ? 'selected' : '' }}>
                                            {{ $project->project_id }} - {{ $project->project_dsc }}
                                        </option>
                                    @endforeach
                            </select>
                        </div>
                    
                        <div class="mb-3 input-group">
                            <span class="input-group-text">Description</span>
                            <select class="form-select" name="description">
                                    <option value="material" {{ $receipts->description == 'material' ? 'selected' : '' }}>Material</option>
                                    <option value="permit" {{ $receipts->description == 'permit' ? 'selected' : '' }}>Permit</option>
                                    <option value="machinery" {{ $receipts->description == 'machinery' ? 'selected' : '' }}>Gas</option>
                            </select>
                        </div>
                    
                        <div class="mb-3 input-group">
                            <span class="input-group-text">SI/OR NO.:</span>
                            <input type="text" class="form-control" name="si_or_no" value="{{ $receipts->si_or_no }}">
                        </div>
                    
                        <div class="mb-3 input-group">
                            <span class="input-group-text">Supplier:</span>
                            <select class="form-select" id="supplier" name="supplier_id">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $receipts->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                            </select>
                        </div>
                    
                        <div class="mb-3 input-group">
                            <span class="input-group-text">Receipt Amount:</span>
                            <input type="number" class="form-control" name="amount" step=".01" max="100000" value="{{ $receipts->amount }}" pattern="\d+(\.\d{2})?">
                        </div>
                    
                        <div class="mb-3 input-group">
                            <span class="input-group-text">Receipt Date:</span>
                            <input type="date" class="form-control" name="receipt_date" value="{{ $receipts->receipt_date }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="avatarInput" class="form-label">Change Receipt Photo:</label>
                            <input type="file" class="form-control" id="receipt_photo" name="receipt_photo" accept="image/*">
                        </div>
                    
                        <div class="d-flex justify-content-between">
                            <div class="input-group">
                                <button type="submit" class="btn btn-primary">Update Receipt</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
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