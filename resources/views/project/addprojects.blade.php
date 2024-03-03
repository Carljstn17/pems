@extends('layout.staff')

    @section('content')
            <div class="py-2 mt-2">
                <i class="fs-5 bi-buildings"></i> <span class=" d-sm-inline">Projects | Add New Project</span>
            </div>
            
            <div class="">
                <div class="card mx-auto p-4 mt-3">
                    <h1 class="fs-4 py-3 px-2">Add Project Form</h1>
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
                            value="{{ old('project_id') }}" 
                            >
                            @error('project_id')
                                <div class="text-danger px-2">{{ $message }}</div>
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
                            value="{{ old('project_dsc') }}"
                            >
                            @error('project_dsc')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="mb-3">
                            <input 
                            type="number" 
                            class="form-control" 
                            id="contract" 
                            name="contract" 
                            placeholder="Enter Contract Price" 
                            autocomplete="off" 
                            value="{{ old('contract') }}"
                            >
                            @error('contract')
                                <div class="text-danger px-2">{{ $message }}</div>
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
                            value="{{ old('client') }}"
                            >
                            @error('client')
                                <div class="text-danger px-2">{{ $message }}</div>
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
                            value="{{ old('contact') }}"
                            >
                            @error('contact')
                                <div class="text-danger px-2">{{ $message }}</div>
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
                            value="{{ old('location') }}"
                            >
                            @error('location')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="mb-3">
                            <input 
                            type="date" 
                            class="form-control" 
                            id="date_started" name="date_started" 
                            value="{{ old('date_started') }}"
                            >
                            @error('date_started')
                                <div class="text-danger px-2">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <button type="submit" class="btn btn-primary mt-3">Save Project</button>
                    </form>
                    
                </div>
            </div>
        </div>
@endsection


