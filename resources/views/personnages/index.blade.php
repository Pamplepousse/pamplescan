@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des personnages</h1>
    <div class="row">
        @foreach($personnages as $personnage)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('public/' . $personnage->image) }}" class="card-img-top" alt="{{ $personnage->nom }} {{ $personnage->prenom }}">
                </div>
                <div class="card-body d-flex flex-column">
                    
                @if ($personnage->nom || $personnage->prenom)
                    <h3 class="card-title">{{ $personnage->nom }} {{ $personnage->prenom }}</h3>
                @elseif ($personnage->surnom)
                    <h3 class="card-title">{{ $personnage->surnom }}</h3>
                @endif

                @if ($personnage->surnom && ($personnage->nom || $personnage->prenom))
                    <h5 class="card-text">Alias : {{ $personnage->surnom }}</h5>
                @endif
                    <p class="card-text">Espèce: {{ $personnage->espece }}</p>
                    <p class="card-text">Poste/Travail: {{ $personnage->poste_travail }}</p>
                    <a href="{{ route('personnages.show', ['idmanga' => $personnage->idmanga, 'idpersonnage' => $personnage->idpersonnage]) }}" class="mt-auto btn btn-primary">Voir détails</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('/mangas/' . $manga->idmanga) }}" class="btn btn-secondary">Retour aux détails de {{ $manga->titres }}</a>
            @auth <!-- Vérifie si un utilisateur est connecté -->
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'contrib')
                    <a href="{{ route('personnages.create', ['idmanga' => $manga->idmanga]) }}" class="btn btn-success">Ajouter un personnage</a>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
