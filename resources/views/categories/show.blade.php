<!-- show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $categoryName }}</h1>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse ($mangas as $manga)
                <div class="col">
                    <div class="card h-100 d-flex flex-column align-self-stretch">
                        <img src="{{ asset($manga->cover) }}" alt="Cover of {{ $manga->titres }}" class="img-fluid">
                        <div class="card-body">
                            <h5 class="card-title">{{ $manga->titres }}</h5>
                            <p class="card-text">Auteur: {{ $manga->auteur }}</p>
                            <p class="card-text"><small class="text-muted">Publié le {{ \Carbon\Carbon::parse($manga->dates)->format('d/m/Y') }}</small></p>
                            <a href="{{ url('/mangas/' . $manga->idmanga) }}" class="btn btn-primary mt-auto">Voir plus</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Aucun manga trouvé pour cette catégorie.</p>
            @endforelse
        </div>
    </div>
@endsection
