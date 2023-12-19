<div class="modal fade" id="addToolsModal" tabindex="-1" aria-labelledby="addToolsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToolsModalLabel">Create Tool</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
                <!-- Your form goes here -->
                <form action="{{ route('store.tools') }}" method="post">
                    @csrf
                
                    <div class="mb-3">
                        <label for="tool_type" class="form-label">Type of Tools</label>
                        <input type="text" list="tool_type" name="tool_type" class="form-control" placeholder="Enter type of tools" required onchange="filterNames()">
                        <datalist name="tool_type" id="tool_type">
                            @foreach($tools_types as $tool)
                            <option value="{{ $tool->tool_type }}">
                                {{ $tool->tool_type }}
                            </option>
                            @endforeach
                        </datalist>
                    </div>
                
                    <div class="mb-3">
                        <label for="property" class="form-label">Property</label>
                        <input type="text" class="form-control" name="property" placeholder="Ex. WM = Welding Machine" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="tool_name" class="form-label">Name</label>
                        <input type="text" list="tool_name" name="tool_name" class="form-control" placeholder="Enter type of tools" required>
                        <datalist name="tool_name" id="tool_name">
                            @foreach($tools_names as $tool)
                            <option value="{{ $tool->tool_name }}">
                                {{ $tool->tool_name }}
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
        
                    <button type="submit" class="btn btn-primary float-end">Submit Category</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
