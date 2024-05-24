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
                <img src="{{ $manga->cover }}" class="img-fluid mb-4" alt="Image du chapitre">
                <h5 class="card-title">{{ $manga->titres }}</h5>
                <p><strong>Catégorie:</strong> 
                    @foreach($manga->categories as $category)
                        {{ $category->name }}@if(!$loop->last), @endif
                    @endforeach
                </p>
                <p class="card-text"><strong>Auteur: </strong>{{ $manga->auteur }}</p>
                <p class="card-text">{{ Str::limit($manga->descri, 100) }}</p>
                <a href="{{ url('/mangas', ['manga' => $manga->idmanga]) }}" class="btn btn-primary">Voir plus</a>
            </div>
        </div>
    </div>
@endforeach

        </div>
    @endif
</div>
@endsection
