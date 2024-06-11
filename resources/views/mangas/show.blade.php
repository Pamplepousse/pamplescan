@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col text-center">
            <h1 class="title-dark">{{ $manga->titres }}</h1>
        </div>
    </div>
    <main class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset($manga->cover) }}" alt="Couverture de {{ $manga->titre }}" class="img-fluid">
                <div class="mt-3">
                    <a href="{{ route('personnages.index', ['idmanga' => $manga->idmanga]) }}" class="btn btn-primary">Voir les Personnages de {{ $manga->titres }}</a>
                </div>
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
                <div class="card-body d-flex">
                 @if ($comment->user->profile_photo)
                    <img src="{{ asset('public/picture/profile_picture/'.$comment->user->profile_photo) }}" alt="Photo de profil de {{ $comment->user->name }}" class="rounded-circle me-3" width="50" height="50">
                @else
                    <img src="{{ asset('public/picture/profile_picture/default.jpg')  }}" alt="Photo de profil de {{ $comment->user->name }}" class="rounded-circle me-3" width="50" height="50">
                @endif
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $comment->user->name }}</strong> 
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-light like-button" data-comment="{{ $comment->id }}" data-liked="true">
                                    <i class="fas fa-thumbs-up"></i> <span id="like-count-{{ $comment->id }}">{{ $comment->userLikes->count() }}</span>
                                </button>
                                <button class="btn btn-light like-button ms-2" data-comment="{{ $comment->id }}" data-liked="false">
                                    <i class="fas fa-thumbs-down"></i> <span id="dislike-count-{{ $comment->id }}">{{ $comment->userDislikes->count() }}</span>
                                </button>
                            </div>
                        </div>
                        <p class="mt-2">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
            @endforeach

            @auth
            <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="manga_id" value="{{ $manga->idmanga }}">
                <div class="form-group">
                    <textarea name="content" class="form-control" required placeholder="Ajouter un commentaire..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Publier</button>
            </form>
            @endauth
            @guest
            <p>Vous devez être connecté pour ajouter un commentaire. <a href="{{ route('login') }}">Se connecter</a></p>
            @endguest
        </div>
    </main>

    <!-- Bootstrap JS avec Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
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
@endsection
