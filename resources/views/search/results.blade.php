@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Résultats pour "{{ $query }}"</h2>
    @if($mangas->isEmpty())
        <p>Aucun résultat trouvé.</p>
    @else
        <div class="row">
@foreach($mangas as $manga)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{'public/picture/'. $manga->cover }}" class="card-img-top" alt="{{ $manga->titre }}">
            <div class="card-body">
                <h5 class="card-title">{{ $manga->titre }}</h5>
                <p class="card-text">{{ $manga->auteur }}</p>
                <p class="card-text">{{ Str::limit($manga->descri, 100) }}</p>
                <a href="{{ route('mangas.show', ['idmanga' => $manga->idmanga]) }}" class="btn btn-primary">Voir plus</a>
            </div>
        </div>
    </div>
@endforeach

        </div>
    @endif
</div>
@endsection
