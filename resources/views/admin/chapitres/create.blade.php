@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Ajouter un chapitre</h1>
    <form action="{{ route('admin.chapitres.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="idmanga">Manga:</label>
            <select name="idmanga" id="idmanga" class="form-control">
                @foreach ($mangas as $manga)
                    <option value="{{ $manga->idmanga }}">{{ $manga->titres }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="numchap">Numéro du chapitre:</label>
            <input type="text" name="numchap" id="numchap" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="titlechap">Titre du chapitre:</label>
            <input type="text" name="titlechap" id="titlechap" class="form-control">
        </div>

        <div class="form-group">
            <label for="content">Contenu du chapitre (Images):</label>
            <input type="file" name="content[]" id="content" class="form-control-file" multiple required>
            <small class="form-text text-muted">Sélectionnez et téléchargez les images pour le contenu du chapitre.</small>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter Chapitre</button>
    </form>
</div>
@endsection
