{{-- resources/views/mangas/chapitres.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chapitres de {{ $manga->titre }}</title>
</head>
<body>
<div class="container">
    <h1>Chapitres de {{ $manga->titre }}</h1>
    <ul>
        @foreach ($manga->chapitres as $chapitre)
            <li>{{ $chapitre->titre }}</li>
        @endforeach
    </ul>
</div>
</body>
</html>
