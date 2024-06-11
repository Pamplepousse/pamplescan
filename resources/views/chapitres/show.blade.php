@extends('layouts.app')


@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chapitre: {{ $chapitre->numchap }}</title>
    <style>
        @media (min-width: 992px) {
            .image-container img {
                width: 65%;
            }
        }
        @media (max-width: 991px) {
            .image-container img {
                width: 100%;
            }
        }
    </style>
</head>
<body>


    <div class="container mt-4">
        <h1 class="text-center"> <a href="{{ url('/mangas/' . $chapitre->manga->idmanga) }}" style="color: black;">{{ $chapitre->manga->titres }}</a></h1>
        <h2 class="text-center">{{ $chapitre->titlechap }}</h2>
        <nav class="mb-5 d-flex justify-content-center">
            @if($prevChapitre)
                <a href="{{ route('chapitre.show', ['idchap' => $prevChapitre->idchap]) }}" class="btn btn-primary me-2">Chapitre précédent</a>
            @else
                <a href="{{ url('/mangas/' . $chapitre->manga->idmanga) }}" class="btn btn-primary me-2">Retour au manga</a> 
            @endif
            

            @if($nextChapitre)
                <a href="{{ route('chapitre.show', ['idchap' => $nextChapitre->idchap]) }}" class="btn btn-primary me-2">Chapitre suivant</a>
            @else
                <a href="{{ url('/mangas/' . $chapitre->manga->idmanga) }}" class="btn btn-primary me-2">Retour au manga</a> 
            @endif
        </nav>
        <div class="image-container text-center">
            @foreach($images as $image)
                <img src="{{ $image }}" class="img-fluid mb-4" alt="Image du chapitre">
            @endforeach
        </div>

        <nav class="mb-5 d-flex justify-content-center">
            @if($prevChapitre)
                <a href="{{ route('chapitre.show', ['idchap' => $prevChapitre->idchap]) }}" class="btn btn-primary me-2">Chapitre précédent</a>
            @else
                <a href="{{ url('/mangas/' . $chapitre->manga->idmanga) }}" class="btn btn-primary me-2">Retour au manga</a> 
            @endif
            

            @if($nextChapitre)
                <a href="{{ route('chapitre.show', ['idchap' => $nextChapitre->idchap]) }}" class="btn btn-primary me-2">Chapitre suivant</a>
            @else
                <a href="{{ url('/mangas/' . $chapitre->manga->idmanga) }}" class="btn btn-primary me-2">Retour au manga</a> 
            @endif
        </nav>
    </div>
</body>
</html>
@endsection
