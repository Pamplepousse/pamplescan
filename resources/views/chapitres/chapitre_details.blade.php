@extends('layouts.app')

@section('content')
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
@endsection
