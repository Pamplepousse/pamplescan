@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('admin.chapitres.create') }}" class="btn btn-primary">Ajouter un chapitre</a>
    <table class="table">
        <thead>
            <tr>
                <th>Manga</th>
                <th>Numéro du chapitre</th>
                <th>Titre du chapitre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chapitres as $chapitre)
            <tr>
                <td>{{ $chapitre->manga->titres }}</td>
                <td>{{ $chapitre->numchap }}</td>
                <td>{{ $chapitre->titlechap }}</td>
                <td>
                    <a href="{{ route('admin.chapitres.edit', $chapitre->idchap) }}" class="btn btn-info">Éditer</a>
                    <form action="{{ route('admin.chapitres.destroy', $chapitre->idchap) }}" method="POST" style="display:inline-block;">
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
