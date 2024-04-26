@extends('layouts.app')

@section('content')
<div class="container">
    <header class="bg-white py-3">
        <div class="container">
            <h1 class="text-black">Accueil Manga</h1>
        </div>
    </header>

    <main class="mt-5">
        <h2 class="mb-4">Derniers Mangas Ajoutés</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse ($mangas as $manga)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{asset ($manga->cover)}}" alt="Couverture de {{ $manga->titre }}" class="img-fluid">
                        <div class="card-body">
                            <h5 class="card-title">{{ $manga->titres }}</h5>
                            <p class="card-text">Auteur: {{ $manga->auteur }}</p>
                            <p class="card-text"><small class="text-muted">Publié le {{ $manga->dates->format('d/m/Y') }}</small></p>
                            <a href="{{ url('/mangas/' . $manga->idmanga) }}" class="btn btn-primary">Voir plus</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Aucun manga récent trouvé.</p>
            @endforelse
        </div>
    </main>


</div>
    <footer class="bg-dark text-white mt-5 py-3">
        <div class="container">
            <p>Votre contenu de pied de page ici</p>
        </div>
    </footer>
@endsection
