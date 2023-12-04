<x-base2>

    <x-slot name="content">
        <div class="container-fluid">
            <div class="py-12">
                <div class="card mx-auto p-4 mt-5" style="max-width: 1000px;">
                    <form action="{{ url('/staff/store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
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
                    
                        <div class="mb-3">
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
                    
                        <div class="mb-3">
                            <input 
                            type="text" 
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
                    
                        <div class="mb-3">
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
                    
                        <div class="mb-3">
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
                    
                        <div class="mb-3">
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
                    
                        <div class="mb-3">
                            <input 
                            type="date" 
                            class="form-control" 
                            id="date_started" name="date_started" 
                            required>
                            @error('date_started')
                                {{ $message }}
                            @enderror
                        </div>
                    
                        <button type="submit" class="btn btn-primary mt-3">Save Project</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </x-slot>

    </x-base2>


