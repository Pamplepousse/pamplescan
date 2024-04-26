@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Éditer Manga</h1>
    <form action="{{ route('admin.mangas.update', $manga->idmanga) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="titres" class="form-label">Titre</label>
            <input type="text" class="form-control" id="titres" name="titres" value="{{ $manga->titres }}" required>
        </div>
        <div class="mb-3">
            <label for="auteur" class="form-label">Auteur</label>
            <input type="text" class="form-control" id="auteur" name="auteur" value="{{ $manga->auteur }}" required>
        </div>
        <div class="mb-3">
            <label for="dates" class="form-label">Date</label>
            <input type="date" class="form-control" id="dates" name="dates" value="{{ $manga->dates->format('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label for="cover" class="form-label">Image de Couverture (URL)</label>
            <input type="text" class="form-control" id="cover" name="cover" value="{{ $manga->cover }}" required>
        </div>
        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select class="form-control" id="statut" name="statut" required>
                <option value="licensed" {{ $manga->statut === 'licensed' ? 'selected' : '' }}>Licencié</option>
                <option value="unlicensed" {{ $manga->statut === 'unlicensed' ? 'selected' : '' }}>Non Licencié</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="descri" class="form-label">Description</label>
            <textarea class="form-control" id="descri" name="descri" rows="3" required>{{ $manga->descri }}</textarea>
        </div>
        <div class="mb-3">
            <label for="categories" class="form-label">Catégories</label><br>
            @foreach($categories->sortBy('name') as $category)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="category{{ $category->id }}" name="categories[]" value="{{ $category->id }}" {{ $manga->categories->contains($category->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
