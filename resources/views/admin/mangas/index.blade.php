@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('admin.mangas.create') }}" class="btn btn-primary">Ajouter un manga</a>
    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mangas as $manga)
            <tr>
                <td>{{ $manga->titres }}</td>
                <td>{{ $manga->auteur }}</td>
                <td>
                    <a href="{{ route('admin.mangas.edit', $manga->idmanga) }}" class="btn btn-info">Éditer</a>
                    <form action="{{ route('admin.mangas.destroy', $manga->idmanga) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
