{{-- resources/views/about/index.blade.php --}}
@extends('layouts.app')  {{-- Assurez-vous que ce layout existe --}}

@section('content')
<div class="container">
    <h1>À propos de Nous</h1>
    @foreach($aboutInfo as $info)
        <h2>{{ $info->title }}</h2>
        <p>{{ $info->content }}</p>
        </br>
    @endforeach
</div>
@endsection
