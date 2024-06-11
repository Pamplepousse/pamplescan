@extends('layouts.app')

@section('content')

<div class="container">

    <h1>{{ isset($personnage) ? 'Modifier' : 'Ajouter' }} un personnage</h1>

    <form action="{{ isset($personnage) ? route('personnages.update', ['idmanga' => $idmanga, 'idpersonnage' => $personnage->id]) : route('personnages.store', ['idmanga' => $idmanga]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($personnage))
            @method('PUT')
        @endif
        <input type="hidden" name="idmanga" value="{{ $idmanga }}">

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $personnage->nom ?? '') }}">
            @error('nom')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $personnage->prenom ?? '') }}">
            @error('prenom')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="surnom">Nom d'usage/Nom de scène/Pseudonyme (si différent du nom réel)</label>
            <input type="text" name="surnom" class="form-control" value="{{ old('surnom', $personnage->surnom ?? '') }}">
            @error('surnom')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="sexe">Sexe</label>
            <select name="sexe" class="form-control" required>
                <option value="Masculin" {{ old('sexe', $personnage->sexe ?? '') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                <option value="Féminin" {{ old('sexe', $personnage->sexe ?? '') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
            </select>
            @error('sexe')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="espece">Espèce</label>
            <input type="text" name="espece" class="form-control" value="{{ old('espece', $personnage->espece ?? '') }}" required>
            @error('espece')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="pseudo">Titre(s)</label>
            <input type="text" name="pseudo" class="form-control" value="{{ old('pseudo', $personnage->pseudo ?? '') }}">
            @error('pseudo')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="en_vie">En vie</label>
            <select name="en_vie" class="form-control" required>
                <option value="oui" {{ old('en_vie', $personnage->en_vie ?? '') == 'oui' ? 'selected' : '' }}>Oui</option>
                <option value="non" {{ old('en_vie', $personnage->en_vie ?? '') == 'non' ? 'selected' : '' }}>Non</option>
            </select>
            @error('en_vie')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="postetravail">Poste/Travail</label>
            <input type="text" name="postetravail" class="form-control" value="{{ old('postetravail', $personnage->postetravail ?? '') }}" required>
            @error('postetravail')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="descriptionphysique">Description physique</label>
            <textarea name="descriptionphysique" class="form-control">{{ old('descriptionphysique', $personnage->descriptionphysique ?? '') }}</textarea>
            @error('descriptionphysique')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="descriptiongeneral">Description générale</label>
            <textarea name="descriptiongeneral" class="form-control">{{ old('descriptiongeneral', $personnage->descriptiongeneral ?? '') }}</textarea>
            @error('descriptiongeneral')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file">
            @if(isset($personnage) && $personnage->image)
                <img src="{{ asset('public/' . $personnage->image) }}" alt="{{ $personnage->nom }} {{ $personnage->prenom }}" class="mt-2" style="max-height: 200px;">
            @endif
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($personnage) ? 'Modifier' : 'Ajouter' }}</button>
    </form>
</div>

@endsection
