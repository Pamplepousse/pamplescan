{{-- resources/views/chapitres/chapitre_details.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $chapitre->titlechap }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<main class="container mt-5">
    <h1>Chapitre: {{ $chapitre->titlechap }}</h1>
    <div>
        @foreach ($images as $image)
            <div class="my-3">
                <img src="{{ $image }}" alt="Image du chapitre" class="img-fluid">
            </div>
        @endforeach
    </div>
</main>

</body>
</html>
