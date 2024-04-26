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
        public function index()
    {
        $users = User::all(); // Récupérer tous les utilisateurs
        return view('admin.users.index', compact('users')); // Retourner la vue avec les données des utilisateurs
    }
public function update(Request $request, User $user)
{
    \Log::info('Request data:', $request->all());

    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        'role' => 'required|in:user,contrib,admin'
    ]);

    \Log::info('Validated data:', $validatedData);

    if ($request->has('role')) {
        $user->role = $request->role;
        \Log::info('Role to update:', [$user->role]);
    }

    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}




    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

}
