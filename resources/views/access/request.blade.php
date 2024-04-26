{{-- resources/views/access/request.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Demande d'accès contributeur</h1>
    <form method="POST" action="{{ route('access.submit') }}">
        @csrf
        <p>En soumettant cette demande, vous demandez un accès pour pouvoir contribuer au contenu du site.</p>
        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
    </form>
</div>
@endsection
