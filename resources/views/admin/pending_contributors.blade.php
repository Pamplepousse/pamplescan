{{-- resources/views/admin/pending_contributors.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Demandes de contributeurs en attente</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.approve_contributor', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Approuver</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
