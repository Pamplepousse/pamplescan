<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;  
use Illuminate\Support\Facades\File;


class UserProfileController extends Controller
{
    public function show()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    public function requestAccess()
    {
        return view('access.request');
    }

    public function submitAccessRequest(Request $request)
    {
        $user = Auth::user();
        $user->update(['role' => 'pending_contributor']);
        
        return redirect()->route('account')->with('success', 'Votre demande a été envoyée avec succès. Elle sera examinée sous peu.');
    }


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

    return redirect()->route('account')->with('success', 'Votre profil a été mis à jour avec succès.');
}


public function updateProfilePhoto(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('profile_photo')) {
        // Suppression de l'ancienne photo si elle existe et n'est pas la photo par défaut
        if ($user->profile_photo && $user->profile_photo !== 'default.jpg') {
            File::delete(public_path('picture/profile_picture/' . $user->profile_photo));
        }

        // Déplacement de la nouvelle photo dans le dossier approprié
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('picture/profile_picture'), $filename);

        // Mise à jour du nom de l'image dans la base de données
        $user->profile_photo = $filename;
        $user->save();

        return redirect()->route('account')->with('success', 'Votre photo de profil a été mise à jour avec succès.');
    }

    return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de votre photo de profil.');
}




}
