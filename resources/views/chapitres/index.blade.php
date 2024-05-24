@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des chapitres</h1>
    <a href="{{ route('chapitres.create') }}" class="btn btn-primary mb-3">Ajouter un chapitre</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Manga</th>
                <th>Numéro du chapitre</th>
                <th>Titre du chapitre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chapitres as $chapitre)
                <tr>
                <td>{{ $chapitre->manga->titres }}</td>
                <td>{{ $chapitre->numchap }}</td>
                <td>{{ $chapitre->titlechap }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection