@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Créer un nouveau manga</h1>
    <form action="{{ route('mangas.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf

        <div class="form-group">
            <label for="titres">Titre:</label>
            <input type="text" name="titres" id="titres" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="auteur">Auteur:</label>
            <input type="text" name="auteur" id="auteur" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="descri">Description:</label>
            <textarea name="descri" id="descri" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="dates">Date de publication:</label>
            <input type="date" name="dates" id="dates" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cover">Couverture:</label>
            <input type="file" name="cover" id="cover" class="form-control-file" required>
        </div>

        <div class="form-group">
            <label for="statut">Statut:</label>
            <select name="statut" id="statut" class="form-control" required>
                <option value="licensed">Licencié</option>
                <option value="unlicensed">Non licencié</option>
            </select>
        </div>

        <div class="form-group">
            <h3>Catégories</h3>
            @foreach($categories as $category)
                <div class="form-check">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $category->id }}" class="form-check-input">
                    <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Créer Manga</button>
    </form>
</div>
@endsection