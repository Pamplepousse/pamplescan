<!-- show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $categoryName }}</h1>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse ($mangas as $manga)
                <div class="cardy">
                    <div class="card h-100">
                        <img src="{{ asset($manga->cover) }}" alt="Cover of {{ $manga->titres }}" class="img-fluid">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $manga->titres }}</h5>
                            <p class="card-text">Auteur: {{ $manga->auteur }}</p>
                            <p class="card-text"><small class="text-muted">Publié le {{ \Carbon\Carbon::parse($manga->dates)->format('d/m/Y') }}</small></p>
                            <div class="mt-auto">
                                <a href="{{ url('/mangas/' . $manga->idmanga) }}" class="btn btn-primary w-100">Voir plus</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Aucun manga trouvé pour cette catégorie.</p>
            @endforelse
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            height: 100%; 
        }
        .cardy {
            width:24%;
            padding-left:1%;
            padding-bottom:1%;
        }
        .card-body {
            display: flex;
            flex-direction: column;
        }
        .card-body > .card-title,
        .card-body > .card-text {
            flex-grow: 0;
        }
        .card-body > .mt-auto {
            margin-top: auto; /* Pousse le bouton vers le bas */
        }
        @media all and (orientation: portrait){
                 .cardy {
            width:100%;
            padding-left:1%;
            padding-bottom:1%;
        }   
            
        }
    </style>
@endpush
