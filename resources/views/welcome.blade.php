@extends('layouts.app')

@section('content')
<div class="container">
<main class="mt-5">
    <h2 class="mb-4">Derniers Chapitres Ajoutés</h2>

    <div id="chapterCarousel" class="carousel slide mb-5" data-ride="carousel">
        <div class="carousel-inner">
            @php
                $nonLicensedChapters = $latestChapters->filter(function ($chapitre) {
                    return $chapitre->manga->statut !== 'licensed';
                });
            @endphp

            @foreach ($nonLicensedChapters->chunk(4) as $index => $chunk)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $chapitre)
                            <div class="col-md-3">
                                <div class="card h-100">
                                    <img src="{{ asset($chapitre->manga->cover) }}" class="card-img-top" alt="Cover of {{ $chapitre->manga->titres }}">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $chapitre->manga->titres }} - Chapitre {{ $chapitre->numchap }}</h5>
                                        <a href="{{ route('chapitre.show', ['idchap' => $chapitre->idchap]) }}" class="btn btn-primary mt-auto">Lire le chapitre</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <a class="carousel-control-prev" href="#chapterCarousel" role="button" data-slide="prev" style="left: -60px;">
            <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true" style="height: 40px; width: 40px; line-height: 40px;"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#chapterCarousel" role="button" data-slide="next" style="right: -60px;">
            <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true" style="height: 40px; width: 40px; line-height: 40px;"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</main>


        <h2 class="mb-4 mt-5">Derniers Mangas Ajoutés</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($mangas as $manga)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($manga->cover) }}" class="card-img-top" alt="Cover of {{ $manga->titres }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $manga->titres }}</h5>
                            <p class="card-text">Auteur: {{ $manga->auteur }}</p>
                            <p class="card-text"><small class="text-muted">Publié le {{ \Carbon\Carbon::parse($manga->dates)->format('d/m/Y') }}</small></p>
                            <a href="{{ url('/mangas/' . $manga->idmanga) }}" class="btn btn-primary mt-auto">Voir plus</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection

