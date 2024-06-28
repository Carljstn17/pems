<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function softDelete(User $user)
    {
        $user->delete();
        return redirect()->route('owner.register'); // Redirect to the user list page after soft deletion
    }

    public function softDeleteLaborer(User $user)
    {
        $user->delete();
        return redirect()->route('staff.laborer'); // Redirect to the user list page after soft deletion
    }
    
    public function updateInfo(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $lastUpdate = $user->last_updated_at;
    
        if ($lastUpdate === null || $user->updated_at->diffInDays($lastUpdate) >= 64) {
            // Allow the update
    
            $updateData = [];
    
            // Check if the 'name' field is being updated
            if ($request->filled('name')) {
                $updateData['name'] = $request->name;
            }
    
            // Check if the 'email' field is being updated
            if ($request->filled('email')) {
                $updateData['email'] = $request->email;
            }
    
            // Check if the 'contact' field is being updated
            if ($request->filled('contact')) {
                $updateData['contact'] = $request->contact;
            }
    
            // Check if the 'birthdate' field is being updated
            if ($request->filled('birthdate')) {
                $updateData['birthdate'] = $request->birthdate;
            }
    
            // Check if the 'address' field is being updated
            if ($request->filled('address')) {
                $updateData['address'] = $request->address;
            }
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
    
                // Store the image in the public disk
                $image->storeAs('images', $imageName, 'public');
    
                // Update the image column in the database
                $updateData['image'] = 'images/' . $imageName;
            }
    
            // Your update logic here
            $user->update($updateData);
    
            // Update the last_updated_at timestamp
            $user->update(['last_updated_at' => $user->fresh()->updated_at]);
    
            return redirect()->back()->with('success', 'Update successful');
        } else {
            // Do not allow the update
            return redirect()->back()->with('error', 'You can only update once every 64 days');
        }
    
        return redirect()->back()->with('success', 'User information updated successfully.');
    }
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function updateInfoForOwner(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'fname' => ['required','string' ,'max:25','regex:/^[a-zA-Z\s_]+$/'],
            'lname' => ['required','string' ,'max:25','regex:/^[a-zA-Z\s_]+$/'],
            'mname' => ['string' ,'max:25','regex:/^[a-zA-Z\s_]+$/'],
        ]);
    
        try {
            $user->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'mname' => $request->mname,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user information.')->withInput();
        }
    
        return redirect()->back()->with('success', 'User information updated successfully.')->withInput();
    }
    
    public function updateEmail(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'email' => 'required|email|unique:users|max:50',
        ]);
        
        try {
            $user->email_verified_at = null; // Remove email_verified_at data
            $user->email = $request->email;
            $user->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user information.')->withInput();
        }

        Notification::send($user, new VerifyEmailNotification($user));
    
        return redirect()->back()->with('success', 'User email updated successfully.');
    }
    
    public function updateContact(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'contact' => ['required', 'unique:users', 'min:11', 'max:11'],
        ]);
        
        try {
            $user->update([
                'contact' => $request->contact,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user information.')->withInput();
        }

    
        return redirect()->back()->with('success', 'User contact number has been updated successfully.');
    }

    
    public function updateAddress(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'birthdate' => 'required|date',
            'address' => 'required|string|max:255',
        ]);
    
        try {
            $user->update([
                'birthdate' => $request->birthdate,
                'address' => $request->address,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user information.')->withInput();
        }
    
        return redirect()->back()->with('success', 'User information updated successfully.')->withInput();
    }
    
    public function assignRole($userId)
    {
        $user = User::findOrFail($userId);
        $user->srole = '1';
        $user->save();
    
        return redirect()->back()->with('success', 'Role assigned successfully.');
    }
    
    public function revokeRole($userId)
    {
        $user = User::findOrFail($userId);
        $user->srole = null;
        $user->save();
    
        return redirect()->back()->with('success', 'Role revoked successfully.');
    }
    
    public function showVerificationForm($userId, $token)
    {
        $user = User::findOrFail($userId);
        
        try {
            $expiration = decrypt($token);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Token decryption failed
            return redirect()->route('expired');
        }
    
        if (Carbon::now()->gt($expiration)) {
            // Token has expired
            return redirect()->route('expired');
        }
        return view('emails.verify', compact('user', 'token'));
    }
    
    public function verifyEmail($userId)
    {
        $user = User::findOrFail($userId);

        $user->email_verified_at = now();
        $user->save();
    
        return redirect()->back()->with('success', 'Email has been verified successfully');
    }
    
    public function expiredLink()
    {
        return view('emails.expired');
    }

    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        if (empty($user->birthdate)) {
            $user->password = bcrypt('password');
        } else {
            $user->password = bcrypt(date('dmY', strtotime($user->birthdate)));
        }
        $user->save();
    
        return redirect()->back()->with('success', 'Password reset successfully.');
    }
    
    public function resendEmailVerify($userId)
    {
        $user = User::findOrFail($userId);
    
        if ($user) {
            Notification::send($user, new VerifyEmailNotification($user));
            return back()->with('success', 'Verification email sent!');
        }
    
        return back()->with('error', 'User not found.');
    }
    
    public function resendEmailUser(Request $request)
    {
        
        $user = $request->user();
        Notification::send($user, new VerifyEmailNotification($user));
    
        return back()->with('success', 'Verification email sent!');
    }
    
    public function updatePassword(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if the old password matches
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect'])->withInput();
        }

        // Update the password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password successfully updated');
    }
    
    public function index(Request $request)
    {
        $role = $request->input('role');
        $query = User::query();
    
        if ($role && $role !== 'all') {
            $query->where('role', $role);
        }
    
        $users = $query->orderByRaw("FIELD(role, 'owner', 'staff', 'laborer')")->latest()->paginate(10);
    
        return view('owner.register', compact('users'));
    }
    
    public function filterByProject(Request $request)
    {
        $projectId = $request->input('project_id');
        $projects = Project::where('status', 'new')->latest()->get();
        
        $selectedProject = null; // Default to null
    
        if ($projectId == 'all' || $projectId == '') {
            $selectedProjectDesc = 'All Projects'; // Set the default description
        } else {
            $selectedProject = Project::findOrFail($projectId);
            $selectedProjectDesc = $selectedProject->project_dsc;
        }
        
        if ($projectId == 'all') {
            $users = User::where('role', 'laborer')->latest()->get(); // Get all laborers
        } elseif ($projectId == '') {
            $users = User::where('role', 'laborer')->latest()->get(); // Get all laborers if 'All' is selected
        } else {
            $users = User::where('project_id', $projectId)->where('role', 'laborer')->latest()->get();
        }
    
        return view('staff.laborer', compact('users', 'projects', 'selectedProject'));
    }

}
