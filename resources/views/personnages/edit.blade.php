@extends('layouts.app')

@section('content')

<div class="container">
    <h1>{{ isset($personnage) ? 'Modifier' : 'Ajouter' }} un personnage</h1>

    <form action="{{ isset($personnage) ? route('personnages.update', ['idmanga' => $idmanga, 'idpersonnage' => $personnage->idpersonnage]) : route('personnages.store', ['idmanga' => $idmanga]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($personnage))
            @method('PUT')
            <input type="hidden" name="idpersonnage" value="{{ $personnage->id }}">
        @endif
        <input type="hidden" name="idmanga" value="{{ $idmanga }}">
        
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ $personnage->nom ?? '' }}">
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ $personnage->prenom ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="surnom">Nom d'usage/Nom de scène/Pseudonyme (si différent du nom réel)</label>
            <input type="text" name="surnom" class="form-control" value="{{ $personnage->surnom ?? '' }}">
        </div>
        <div class="form-group">
            <label for="sexe">Sexe</label>
            <select name="sexe" class="form-control" required>
                <option value="Masculin" {{ isset($personnage) && $personnage->sexe == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                <option value="Féminin" {{ isset($personnage) && $personnage->sexe == 'Féminin' ? 'selected' : '' }}>Féminin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="espece">Espèce</label>
            <input type="text" name="espece" class="form-control" value="{{ $personnage->espece ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="pseudo">Titre(s)</label>
            <input type="text" name="pseudo" class="form-control" value="{{ $personnage->pseudo ?? '' }}">
        </div>
        <div class="form-group">
            <label for="en_vie">En vie</label>
            <select name="en_vie" class="form-control" required>
                <option value="oui" {{ isset($personnage) && $personnage->en_vie ? 'selected' : '' }}>Oui</option>
                <option value="non" {{ isset($personnage) && !$personnage->en_vie ? 'selected' : '' }}>Non</option>
            </select>
        </div>
        <div class="form-group">
            <label for="postetravail">Poste/Travail</label>
            <input type="text" name="postetravail" class="form-control" value="{{ $personnage->poste_travail ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="descriptionphysique">Description physique</label>
            <textarea name="descriptionphysique" class="form-control">{{ $personnage->description_physique ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="descriptiongeneral">Description générale</label>
            <textarea name="descriptiongeneral" class="form-control">{{ $personnage->description_generale ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file">
            @if(isset($personnage) && $personnage->image)
                <img src="{{ asset('public/' . $personnage->image) }}" alt="{{ $personnage->nom }} {{ $personnage->prenom }}" class="mt-2" style="max-height: 200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($personnage) ? 'Modifier' : 'Ajouter' }}</button>
    </form>
</div>

@endsection
