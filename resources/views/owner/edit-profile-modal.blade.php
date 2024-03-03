<!-- Update Modal -->
<div class="modal fade" id="editProfileModal{{ $user->id }}" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Update User Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('owner.updateInfo', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label for="fullName" class="form-label">Username:</label>
                        <input type="text" id="fullName" name="name" class="form-control" value="{{ $user->username }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fullName" class="form-label">Full Name:</label>
                        <input type="text" id="fullName" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="number" class="form-label">Contact Number:</label>
                        <input type="number" id="number" name="contact" class="form-control" value="{{ $user->contact }}" required>
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="number" class="form-label">Birthday:</label>
                        <input type="date" id="birthday" name="birthdate" class="form-control" value="{{ $user->birthdate }}" required>
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <textarea id="address" name="address" class="form-control" rows="2" style="width:100%;resize:none;" required>{{ trim($user->address) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
