<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Affiche la liste des demandes de contributeur en attente
    public function pendingContributors()
    {
        $users = User::where('role', 'pending_contributor')->get();
        return view('admin.pending_contributors', compact('users'));
    }

    // Approuver un utilisateur en tant que contributeur
    public function approveContributor(User $user)
    {
        $user->update(['role' => 'contrib']);
        return redirect()->back()->with('success', 'Utilisateur approuvé en tant que contributeur.');
    }
     public function promote(User $user)
    {
        if ($user->role === 'user') {
            $user->role = 'contrib';
        } elseif ($user->role === 'contrib') {
            $user->role = 'admin';
        }
        $user->save();
        return redirect()->back()->with('success', 'Rôle utilisateur mis à jour avec succès.');
    }

    public function demote(User $user)
    {
        if ($user->role === 'admin') {
            $user->role = 'contrib';
        } elseif ($user->role === 'contrib') {
            $user->role = 'user';
        }
        $user->save();
        return redirect()->back()->with('success', 'Rôle utilisateur mis à jour avec succès.');
    }
    public function index()
    {
        $users = User::all(); // Récupérer tous les utilisateurs
        return view('admin.users.index', compact('users')); // Retourner la vue avec les données des utilisateurs
    }
    
    
    
    
    


public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
    ]);

    $user = User::findOrFail($id);
    $user->update($request->only('name', 'email'));

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
}


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
}
