{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')  {{-- Assurez-vous que ce layout existe et contient les éléments de base du HTML. --}}

@section('content')
<div class="container mt-5">
    <h1>Tableau de bord Administrateur</h1>
    <div class="list-group">
        <a href="{{ route('admin.mangas.index') }}" class="list-group-item list-group-item-action">Gestion des Mangas</a>
        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">Gestion des Utilisateurs</a>
    </div>
</div>
@endsection
