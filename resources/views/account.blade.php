@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Mon compte') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p><strong>Nom:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <!-- Bouton d'édition du profil -->
                    <a href="{{ route('account.edit') }}" class="btn btn-primary">Modifier mon profil</a>

                    <!-- Bouton de demande d'accès contributeur -->
                    <a href="{{ route('access.request') }}" class="btn btn-secondary">Demander un accès contributeur</a>
                    <!-- Ajoutez d'autres informations de l'utilisateur ici -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
