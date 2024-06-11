<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;  
use Illuminate\Support\Facades\File;

class UserProfileController extends Controller
{
    // Show the user's account view
    public function show()
    {
        return view('account', ['user' => Auth::user()]);
    }

    // Show the edit profile view
    public function edit()
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    // Show the request access view
    public function requestAccess()
    {
        return view('access.request');
    }

    // Handle the access request submission
    public function submitAccessRequest(Request $request)
    {
        $user = Auth::user();
        $user->update(['role' => 'pending_contributor']);
        
        return redirect()->route('account')->with('success', 'Your request has been successfully sent. It will be reviewed shortly.');
    }

    // Update the user's profile
    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'required|string|in:male,female,other',
            'password' => 'sometimes|nullable|min:6|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('account')->with('success', 'Your profile has been successfully updated.');
    }

    // Update the user's profile photo
    public function updateProfilePhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete the old photo if it exists and is not the default photo
            if ($user->profile_photo && $user->profile_photo !== 'default.jpg') {
                File::delete(public_path('picture/profile_picture/' . $user->profile_photo));
            }

            // Move the new photo to the appropriate folder
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('picture/profile_picture'), $filename);

            // Update the image name in the database
            $user->profile_photo = $filename;
            $user->save();

            return redirect()->route('account')->with('success', 'Your profile photo has been successfully updated.');
        }

        return redirect()->back()->with('error', 'An error occurred while updating your profile photo.');
    }
}