{{-- resources/views/cgu/index.blade.php --}}
@extends('layouts.app')  {{-- Assurez-vous que ce layout existe et contient les éléments de base du HTML. --}}

@section('content')
<div class="container mt-5">
    <h1>Conditions Générales d'Utilisation</h1>
    @foreach($cguInfo as $info)
        <h2>{{ $info->title }}</h2>
        <p>{{ $info->content }}</p>
    @endforeach
</div>
@endsection
