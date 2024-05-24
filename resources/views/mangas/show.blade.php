@extends('layouts.app')

@section('content')

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du Manga</title>
           <meta charset="UTF-8">
    <title>Détail du Manga</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap Reboot CSS -->
    <link href="{{ asset('public/css/bootstrap-reboot.min.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Grid CSS -->
    <link href="{{ asset('public/css/bootstrap-grid.min.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pamplescan</title>
    <link rel="shortcut icon" href="{{ asset('public/picture/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <!-- Bootstrap JS avec Popper (s'assurer que le lien est valide) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <div class="col text-center">
            <h1 class="title-dark">{{ $manga->titres }}</h1>
        </div>
    </div>
<main class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{asset ($manga->cover)}}" alt="Couverture de {{ $manga->titre }}" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2>Titre : {{ $manga->titres }}</h2>
            <p><strong>Auteur:</strong> {{ $manga->auteur }}</p>
            <p><strong>Date de publication:</strong> {{ $manga->dates->format('d/m/Y') }}</p>
            <p><strong>Catégorie:</strong> 
@foreach($manga->categories as $category)
    {{ $category->name }}@if(!$loop->last), @endif
@endforeach
</p>

            <p><strong>Description:</strong> {{ $manga->descri }}</p>
            <p><strong>Status:</strong> {{ $manga->statut === 'licensed' ? 'Licencié en France' : 'Disponible' }}</p>
        </div>
    </div>

<section class="mt-4">
    <h3>Chapitres</h3>
    <div class="list-group">
        @if($manga->statut === 'licensed')
            <p>Ce manga est licencié en France et n'est plus disponible pour la lecture.</p>
        @else
            @forelse($manga->chapitres as $chapitre)
                <a href="{{ route('chapitre.show', ['idchap' => $chapitre->idchap]) }}" class="list-group-item list-group-item-action">
                    Chapitre {{ $chapitre->numchap }} : {{ $chapitre->titlechap }}
                </a>
            @empty
                <p>Aucun chapitre n'est paru pour l'instant.</p>
            @endforelse
        @endif
    </div>
</section>
<div class="container mt-3">
    <h2>Commentaires</h2>
@foreach ($manga->comments as $comment)
<div class="card mb-2">
    <div class="card-body">
        <p>{{ $comment->content }}</p>
        <div class="text-muted">Posté par {{ $comment->user->name }}</div>
        <div>
            <button class="btn btn-success like-button" data-comment="{{ $comment->id }}" data-liked="true">
                Like <span id="like-count-{{ $comment->id }}">{{ $comment->userLikes->count() }}</span>
            </button>
            <button class="btn btn-danger like-button" data-comment="{{ $comment->id }}" data-liked="false">
                Dislike <span id="dislike-count-{{ $comment->id }}">{{ $comment->userDislikes->count() }}</span>
            </button>
        </div>
    </div>
</div>
@endforeach


    <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
        @csrf
        <input type="hidden" name="manga_id" value="{{ $manga->idmanga }}">
        <div class="form-group">
            <textarea name="content" class="form-control" required placeholder="Ajouter un commentaire..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Publier</button>
    </form>
</div>
</main>


<!-- Bootstrap JS avec Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js">
    
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-button');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.comment;
            const liked = this.dataset.liked === 'true'; // Convertir en boolean

            fetch('{{ url("/comments/") }}/' + commentId + '/toggle-like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ liked: liked })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('like-count-' + commentId).textContent = data.count.likes;
                document.getElementById('dislike-count-' + commentId).textContent = data.count.dislikes;
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

</script>

</body>
</html>
@endsection