<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
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
        // Ajouter la logique pour traiter la demande ici
        // Par exemple, envoyer un email à l'administrateur ou marquer l'utilisateur en attente d'approbation
        $user->update(['role' => 'pending_contributor']);
        
        return redirect()->route('account')->with('success', 'Votre demande a été envoyée avec succès. Elle sera examinée sous peu.');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|min:6|confirmed'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('account')->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}
