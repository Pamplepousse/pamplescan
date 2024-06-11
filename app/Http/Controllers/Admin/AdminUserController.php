<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Display a list of users with pending contributor role
    public function pendingContributors()
    {
        $users = User::where('role', 'pending_contributor')->get();
        return view('admin.pending_contributors', compact('users'));
    }

    // Approve a user as a contributor
    public function approveContributor(User $user)
    {
        $user->update(['role' => 'contrib']);
        return redirect()->back()->with('success', 'User approved as a contributor.');
    }

    // Promote a user to a higher role
    public function promote(User $user)
    {
        if ($user->role === 'user') {
            $user->role = 'contrib';
        } elseif ($user->role === 'contrib') {
            $user->role = 'admin';
        }
        $user->save();
        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    // Demote a user to a lower role
    public function demote(User $user)
    {
        if ($user->role === 'admin') {
            $user->role = 'contrib';
        } elseif ($user->role === 'contrib') {
            $user->role = 'user';
        }
        $user->save();
        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    // Display a list of all users
    public function index()
    {
        $users = User::all(); // Retrieve all users
        return view('admin.users.index', compact('users')); // Return the view with user data
    }

    // Update the specified user
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

    // Show the form for editing a user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
}