@extends('layouts.app') {{-- Assurez-vous que ce layout existe --}}

@section('content')
<div class="container">
    <h1>Gestion des Utilisateurs</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Ajouter un utilisateur</a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-info">Éditer</a>
                    <form action="{{ route('admin.users.promote', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Promouvoir</button>
                    </form>
                    <form action="{{ route('admin.users.demote', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning">Rétrograder</button>
                    </form>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
