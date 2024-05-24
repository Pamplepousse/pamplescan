@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Éditer Chapitre</h1>
    <form action="{{ route('admin.chapitres.update', $chapitre->idchap) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="idmanga">Manga:</label>
            <select name="idmanga" id="idmanga" class="form-control" required>
                @foreach($mangas as $manga)
                    <option value="{{ $manga->idmanga }}" {{ $chapitre->idmanga == $manga->idmanga ? 'selected' : '' }}>{{ $manga->titres }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="numchap">Numéro du chapitre:</label>
            <input type="number" name="numchap" id="numchap" class="form-control" value="{{ $chapitre->numchap }}" required>
        </div>

        <div class="form-group">
            <label for="titlechap">Titre du chapitre:</label>
            <input type="text" name="titlechap" id="titlechap" class="form-control" value="{{ $chapitre->titlechap }}">
        </div>

        <div class="form-group">
            <label for="content">Contenu:</label>
            <textarea name="content" id="content" class="form-control" required>{{ $chapitre->content }}</textarea>
        </div>

        <div class="form-group">
            <label for="dates">Date:</label>
            <input type="date" name="dates" id="dates" class="form-control" value="{{ $chapitre->dates }}" required>
        </div>

        <div class="form-group">
            <label for="path">Chemin du fichier:</label>
            <input type="text" name="path" id="path" class="form-control" value="{{ $chapitre->path }}">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour Chapitre</button>
    </form>
</div>
@endsection
