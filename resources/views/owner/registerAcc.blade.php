@extends('layout.owner')

    @section('content')

    <div class="py-2 mt-2">
        <div class="d-flex align-items-center">
           <a href="{{ route('owner.register') }}" class="text-secondary text-decoration-none btn">
                    <i class="bi-backspace"></i>
            </a>
            <i class="fs-5 bi-person-plus me-1"></i> <span class="d-sm-inline text-nowrap head fs-5"> Register Account</span>
        </div>
    </div>    

    <div class="mt-3 ">
         <div class="card mx-auto p-4 mt-3">
                    <p class="fs-5 py-3 px-2">Fillup this form to add new account</p>
        <form method="POST" action="{{ url('/owner/register') }}">
            @csrf
            <div class="mb-3 input-group">
                <label for="" class="input-group-text">Job</label>
                <select class="form-select" name="role" id="role" required>
                    <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="laborer" {{ old('role') == 'laborer' ? 'selected' : '' }}>Laborer</option>
                </select>
            </div>
            
            <div class="input-group mb-3" id="project-select" style="display: none;">
                <label for="project_id" class="input-group-text">Project</label>
                <select name="project_id" id="project_id" class="form-select" required>
                    <option value="">Select project for the laborer</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->project_id }}&nbsp;-&nbsp;{{ $project->project_dsc }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <div class="text-danger px-2">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="mb-3 col-md-4">
                    <input type="text" class="form-control" name="lname" placeholder="Last Name" value="{{ old('lname') }}">
                    @error('lname')
                        <div class="text-danger px-2">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="mb-3 col-md-4">
                    <input type="text" class="form-control" name="fname" placeholder="First Name" value="{{ old('fname') }}">
                    @error('fname')
                        <div class="text-danger px-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 col-md-4">
                    <input type="text" class="form-control" name="mname" placeholder="Middle Name" value="{{ old('mname') }}">
                    @error('mname')
                        <div class="text-danger px-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" >
                @error('email')
                    <div class="text-danger px-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" name="contact" placeholder="Contact Number" value="{{ old('contact') }}" >
                @error('contact')
                    <div class="text-danger px-2">{{ $message }}</div>
                @enderror
            </div>

            <div class=" mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" >
                @error('username')
                    <div class="text-danger px-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Create Password, min of 8" id="passwordHelpBlock" value="{{ old('password') }}" >
                @error('password')
                    <div class="text-danger px-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
        </div>
    </div>
    
    <script>
    $(document).ready(function() {
        $('#role').change(function() {
            if ($(this).val() === 'laborer') {
                $('#project-select').show();
            } else {
                $('#project-select').hide();
            }
        }).trigger('change');
    });
</script>
@endsection
