<!-- create-receipt-modal.blade.php -->

<div class="modal fade" id="createReceiptModal" tabindex="-1" aria-labelledby="createReceiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSupplierModalLabel">Add New Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('entry.create') }}" enctype="multipart/form-data">
                    @csrf

                    <select name="project_id" id="project_id" class="form-select col col-md-2 col-sm-6 mb-3" required>
                        <option value="">Select a project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->project_id }}
                                <span>&nbsp;-&nbsp; {{ $project->project_dsc }}</span>
                            </option>
                        @endforeach
                    </select>

                    <div class="border p-4 rounded">
                        <div class="mb-3">
                            <select class="form-select" id="description" name="description" required>
                                <option value="material">Material</option>
                                <option value="permit">Permit</option>
                                <option value="machinery">Gas</option>
                            </select>
                        </div>
            
                        <div class="mb-3">
                            <input type="text" class="form-control" id="si_or_no" name="si_or_no" placeholder="SI/OR NO." required>
                        </div>
            
                        <div class="mb-3">
                            <select class="form-select" id="supplier" name="supplier_id" required>
                                <option value="">Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                            </select>
                        </div>
            
                        <div class="mb-3">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Receipt Amount" step=".01" required>
                        </div>

                        <div class="input-group mb-3">
                            <label for="receipt_date" class="input-group-text">Receipt Date:</label>
                            <input type="date" class="form-control" id="entry_date" name="receipt_date" required>
                        </div>
            
                        <div class="mb-3">
                            <input type="file" class="form-control" id="receipt_photo" name="receipt_photo" accept="image/*">
                        </div>
            
                        <button type="submit" class="btn btn-primary">Submit Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
