<div class="modal fade" id="addMachineryModal" tabindex="-1" aria-labelledby="addMachineryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMachineryModalLabel">+ Add Machinery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
                <!-- Your form goes here -->
                <form action="{{ route('store.machinery') }}" method="post">
                    @csrf
                
                    <div class="mb-3">
                        <label for="machinery_type" class="form-label">Type of Machinery</label>
                        <input type="text" list="machinery_type" name="machinery_type" class="form-control" placeholder="Enter type of machinery" required onchange="filterNames()">
                        <datalist name="machinery_type" id="machinery_type">
                            @foreach($machinery_types as $machinery)
                            <option value="{{ $machinery->machinery_type }}">
                                {{ $machinery->machinery_type }}
                            </option>
                            @endforeach
                        </datalist>
                    </div>
                
                    <div class="mb-3">
                        <label for="property" class="form-label">Property</label>
                        <input type="text" class="form-control" name="property" placeholder="Ex. WM = Welding Machine" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="machinery_name" class="form-label">Name</label>
                        <input type="text" list="machinery_name" name="machinery_name" class="form-control" placeholder="Enter type of machinery" required>
                        <datalist name="machinery_name" id="machinery_name">
                            @foreach($machinery_names as $machinery)
                            <option value="{{ $machinery->machinery_name }}">
                                {{ $machinery->machinery_name }}
                            </option>
                            @endforeach
                        </datalist>
                    </div>
                
                    <div class="mb-3">
                        <label for="unit_cost" class="form-label">Unit Cost</label>
                        <input type="number" class="form-control" name="unit_cost" placeholder="Enter unit cost" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" name="status" placeholder="Enter Status" required>
                    </div>

                    <div class="mb-3">
                        <label for="whereabout" class="form-label">Whereabout</label>
                        <input type="text" class="form-control" name="whereabout" placeholder="Enter whereabout" required>
                    </div>
        
                    <button type="submit" class="btn btn-primary">Submit Category</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
