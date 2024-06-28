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
                        <input type="text" list="machinery_type" name="machinery_type" class="form-control" placeholder="Enter type of machinery" value="{{ old('machinery_type') }}" id="machinery_type" onchange="filterNames()">
                        <datalist name="machinery_type" id="machinery_type">
                            @foreach($machinery_types as $machinery)
                            <option value="{{ $machinery->machinery_type }}">
                                {{ $machinery->machinery_type }}
                            </option>
                            @endforeach
                        </datalist>
                        @error('machinery_type')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
                
                    <div class="mb-3">
                        <label for="property" class="form-label">Property</label>
                        <input type="text" class="form-control" name="property" placeholder="Ex. WM = Welding Machine" value="{{ old('property') }}" id="property">
                        @error('property')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
                
                    <div class="mb-3">
                        <label for="machinery_name" class="form-label">Name</label>
                        <input type="text" list="machinery_name" name="machinery_name" class="form-control" placeholder="Enter type of machinery" value="{{ old('machinery_name') }}" id="machinery_name">
                        <datalist name="machinery_name" id="machinery_name">
                            @foreach($machinery_names as $machinery)
                            <option value="{{ $machinery->machinery_name }}">
                                {{ $machinery->machinery_name }}
                            </option>
                            @endforeach
                        </datalist>
                        @error('machinery_name')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
                
                    <div class="mb-3">
                        <label for="unit_cost" class="form-label">Unit Cost</label>
                        <input type="number" class="form-control" name="unit_cost" placeholder="Enter unit cost" value="{{ old('unit_cost') }}" id="unit_cost">
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
                        <input type="text" class="form-control" name="whereabout" placeholder="Enter whereabout" value="{{ old('whereabout') }}" id="whereabout">
                        @error('whereabout')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                    </div>
        
                    <button type="submit" class="btn btn-primary">Submit Category</button>
                </form>
                
                @if ($errors->any())
                    <script>
                        $(document).ready(function() {
                            $('#addMachineryModal').modal('show');
                        });
                    </script>
                @endif
                
            </div>
        </div>
    </div>
</div>

<script>
            function storeInputValues() {
                sessionStorage.setItem('machinery_type', document.getElementById('machinery_type').user_id);
                sessionStorage.setItem('property', document.getElementById('property').value);
                sessionStorage.setItem('machinery_name', document.getElementById('machinery_name').value);
                sessionStorage.setItem('unit_cost', document.getElementById('unit_cost').value);
                sessionStorage.setItem('status', document.getElementById('status').value);
                sessionStorage.setItem('whereabout', document.getElementById('whereabout').value);
            }
        
            // Function to retrieve and populate input values when modal is shown
            function populateInputValues() {
                document.getElementById('machinery_type').value = sessionStorage.getItem('machinery_type');
                document.getElementById('property').value = sessionStorage.getItem('property');
                document.getElementById('machinery_name').value = sessionStorage.getItem('machinery_name');
                document.getElementById('unit_cost').value = sessionStorage.getItem('unit_cost');
                document.getElementById('status').value = sessionStorage.getItem('status');
                document.getElementById('whereabout').value = sessionStorage.getItem('whereabout');
            }
        </script>
