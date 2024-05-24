@section('content')
    @include('layouts.app')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Manga</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-dark py-3">
    <div class="container">
        <h1 class="text-white">Accueil Manga</h1>
    </div>
</header>

<main class="container mt-5">
    <section id="latest-mangas">
        <h2 class="mb-4">Derniers Mangas Ajoutés</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse ($mangas as $manga)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{asset ($manga->cover)}}" alt="Couverture de {{ $manga->titre }}" class="img-fluid">
                        <div class="card-body">
                            <h5 class="card-title">{{ $manga->titre }}</h5>
                            <p class="card-text">Auteur: {{ $manga->auteur }}</p>
                            <p class="card-text"><small class="text-muted">Publié le {{ $manga->dates->format('d/m/Y') }}</small></p>
                            <a href="/mangas/{{ $manga->idmanga }}" class="btn btn-primary">Voir plus</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Aucun manga récent trouvé.</p>
            @endforelse
        </div>
    </section>
</main>


<!-- Bootstrap JS avec Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
