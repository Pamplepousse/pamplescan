@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails du personnage</h1>
    <div class="card mb-4">
        <div style="height: 700px; overflow: hidden;">
            <img src="{{ asset('public/' . $personnage->image) }}" class="card-img-top" alt="{{ $personnage->nom }} {{ $personnage->prenom }}">
        </div>
        <div class="card-body">
            @if ($personnage->nom || $personnage->prenom)
                <h3 class="card-title">{{ $personnage->nom }} {{ $personnage->prenom }}</h3>
            @elseif ($personnage->surnom)
                <h3 class="card-title">{{ $personnage->surnom }}</h3>
            @endif

            @if ($personnage->surnom && ($personnage->nom || $personnage->prenom))
                <h5 class="card-text">Alias : {{ $personnage->surnom }}</h5>
            @endif
            <p class="card-text"><strong>Sexe :</strong> {{ $personnage->sexe}}</p>
            <p class="card-text"><strong>Espèce :</strong> {{ $personnage->espece }}</p>
            @if (!is_null($personnage->pseudo))
            <p class="card-text"><strong>Titres :</strong> {{ $personnage->pseudo}}</p>
             @endif
            <p class="card-text"><strong>Poste/Travail :</strong> {{ $personnage->poste_travail }}</p>
            <p class="card-text"><strong>En vie :</strong> {{ $personnage->en_vie}}</p>
            <p class="card-text"><strong>Description physique :</strong></p>
            <p>{{ $personnage->description_physique }}</p>
            <p class="card-text"><strong>Description générale :</strong></p>
            <p>{{ $personnage->description_generale }}</p>
        </div>
    </div>
    <a href="{{ route('personnages.index', ['idmanga' => $personnage->idmanga]) }}" class="btn btn-secondary">Retour à la liste des personnages</a>
    @auth
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'contrib')
            <a href="{{ route('personnages.edit', ['idmanga' => $personnage->idmanga, 'idpersonnage' => $personnage->idpersonnage]) }}" class="btn btn-primary">Modifier</a>
        @endif
    @endauth
</div>
@endsection
