<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSupplierModalLabel">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <form action="{{ url('/staff/store') }}" method="POST">
                        @csrf
                        <div class="mb-3 input-group">
                            <label for="project_id" class="input-group-text">Project ID</label>
                            <input 
                            type="text" 
                            class="form-control" 
                            id="project_id" 
                            name="project_id" 
                            placeholder="Enter Project ID" 
                            autocomplete="off" 
                            :value="@old('project_id')" 
                            required>
                            @error('project_id')
                                {{ $message }}
                            @enderror
                        </div>
                    
                        <div class="mb-3 input-group">
                            <label for="project_dsc" class="input-group-text">Description</label>
                            <input 
                            type="text" 
                            class="form-control" 
                            id="project_dsc" 
                            name="project_dsc" 
                            placeholder="Enter Project Description" 
                            autocomplete="off" 
                            required>
                            @error('project_dsc')
                                {{ $message }}
                            @enderror
                        </div>
                    
                        <div class="mb-3 input-group">
                            <label for="contract" class="input-group-text">Contact</label>
                            <input 
                            type="number" 
                            class="form-control" 
                            id="contract" 
                            name="contract" 
                            placeholder="Enter Contract Price" 
                            autocomplete="off" 
                            required>
                            @error('contract')
                                {{ $message }}
                            @enderror
                        </div>
                    
                        <div class="mb-3 input-group">
                            <label for="client" class="input-group-text">Client</label>
                            <input 
                            type="text" 
                            class="form-control" 
                            id="client" 
                            name="client" 
                            placeholder="Enter Client" 
                            autocomplete="off" 
                            required>
                            @error('client')
                                {{ $message }}
                            @enderror
                        </div>
                    
                        <div class="mb-3 input-group">
                            <label for="contact" class="input-group-text">Contact</label>
                            <input 
                            type="text" 
                            class="form-control" 
                            id="contact" 
                            name="contact" 
                            placeholder="Enter Contact No" 
                            autocomplete="off" 
                            required>
                            @error('contact')
                                {{ $message }}
                            @enderror
                        </div>
                    
                        <div class="mb-3 input-group">
                            <label for="location" class="input-group-text">Location</label>
                            <input 
                            type="text" 
                            class="form-control" 
                            id="location" 
                            name="location" 
                            placeholder="Enter Project Location" 
                            autocomplete="off" 
                            required>
                            @error('location')
                                {{ $message }}
                            @enderror
                        </div>
                    
                        <div class="mb-3 input-group">
                            <label for="date_started" class="input-group-text">Date started</label>
                            <input 
                            type="date" 
                            class="form-control" 
                            id="date_started" name="date_started" 
                            required>
                            @error('date_started')
                                {{ $message }}
                            @enderror
                        </div>

                        <a href="{{ url('/staff/ongoing-projects') }}" class="btn btn-primary">
                            Cancel
                        </a>
                    
                        <button type="submit" class="btn btn-primary">Save Project</button>
                    </form>
                    
                </div>

        </div>
    </div>
</div>


