<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20',
        ]);

        $user = User::findOrFail($user->id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
        ]);

        return redirect()->route('owner.register')->with('success', 'User information updated successfully.');
    }

    public function updateLaborer(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:20',
        ]);

        $user = User::findOrFail($user->id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
        ]);

        return redirect()->route('staff.laborer')->with('success', 'User information updated successfully.');
    }

    public function updateInfo(Request $request, $id)
    {
        $laborer = User::findOrFail($id);

        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|numeric',
            'birthdate' => 'required|date',
            'address' => 'required|string',
        ]);

        $lastUpdate = $laborer->updated_at;

        if ($lastUpdate->diffInDays(Carbon::now()) >= 64) {
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
                $laborer->update(['image' => 'images/' . $imageName]);
            }
    
            // Your update logic here
            $laborer->update($updateData);
    
            return redirect()->back()->with('success', 'Update successful');
        } else {
            // Do not allow the update
            return redirect()->back()->with('error', 'You can only update once every 64 days');
        }

        return redirect()->back()->with('success', 'Laborer information updated successfully.');
    }
}
