<div class="modal fade" id="addToolsModal" tabindex="-1" aria-labelledby="addToolsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToolsModalLabel">+   Add Tool</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-2">
                <!-- Your form goes here -->
                <form action="{{ route('store.tools') }}" method="post">
                    @csrf
                
                    <div class="mb-3">
                        <label for="tool_type" class="form-label">Type of Tools</label>
                        <input type="text" list="tool_type" name="tool_type" class="form-control" id="tool_type" placeholder="Enter type of tools" value="{{ old('tool_type') }}" onchange="filterNames()">
                        <datalist name="tool_type" id="tool_type">
                            @foreach($tools_types as $tool)
                            <option value="{{ $tool->tool_type }}">
                                {{ $tool->tool_type }}
                            </option>
                            @endforeach
                        </datalist>
                        @error('tool_type')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
                
                    <div class="mb-3">
                        <label for="property" class="form-label">Property</label>
                        <input type="text" class="form-control" name="property" placeholder="Ex. WM = Welding Machine" id="property" value="{{ old('property') }}" >
                        @error('property')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
                
                    <div class="mb-3">
                        <label for="tool_name" class="form-label">Name</label>
                        <input type="text" list="tool_name" name="tool_name" class="form-control" placeholder="Enter type of tools" id="tool_name" value="{{ old('tool_name') }}" >
                        <datalist name="tool_name" id="tool_name">
                            @foreach($tools_names as $tool)
                            <option value="{{ $tool->tool_name }}">
                                {{ $tool->tool_name }}
                            </option>
                            @endforeach
                        </datalist>
                        @error('tool_name')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
                
                    <div class="mb-3">
                        <label for="unit_cost" class="form-label">Unit Cost</label>
                        <input type="number" class="form-control" name="unit_cost" placeholder="Enter unit cost" value="{{ old('unit_cost') }}" id="unit_cost" >
                        @error('unit_cost')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
                
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="New" {{ old('status') == 'New' ? 'selected' : '' }}>New</option>
                            <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="On Work" {{ old('status') == 'On Work' ? 'selected' : '' }}>On Work</option>
                            <option value="Not Available" {{ old('status') == 'Not Available' ? 'selected' : '' }}>Not Available</option>
                        </select>
                        @error('status')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="mb-3">
                        <label for="whereabout" class="form-label">Whereabout</label>
                        <input type="text" class="form-control" name="whereabout" placeholder="Enter whereabout" value="{{ old('whereabout') }}" id="whereabout" >
                        @error('whereabout')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
        
                    <button type="submit" class="btn btn-primary float-end">Submit Category</button>
                </form>
                
                @if ($errors->any())
                    <script>
                        $(document).ready(function() {
                            $('#addToolsModal').modal('show');
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
            function storeInputValues() {
                sessionStorage.setItem('user_id', document.getElementById('lname').user_id);
                sessionStorage.setItem('amount', document.getElementById('amount').value);
                sessionStorage.setItem('tool_name', document.getElementById('tool_name').value);
                sessionStorage.setItem('unit_cost', document.getElementById('unit_cost').value);
                sessionStorage.setItem('status', document.getElementById('status').value);
                sessionStorage.setItem('whereabout', document.getElementById('whereabout').value);
            }
        
            // Function to retrieve and populate input values when modal is shown
            function populateInputValues() {
                document.getElementById('user_id').value = sessionStorage.getItem('user_id');
                document.getElementById('amount').value = sessionStorage.getItem('amount');
                document.getElementById('tool_name').value = sessionStorage.getItem('tool_name');
                document.getElementById('unit_cost').value = sessionStorage.getItem('unit_cost');
                document.getElementById('status').value = sessionStorage.getItem('status');
                document.getElementById('whereabout').value = sessionStorage.getItem('whereabout');
            }
        </script>
