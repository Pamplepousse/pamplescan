@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modifier Mon Compte') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('account.update') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Nom') }}</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required autocomplete="email">
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Nouveau mot de passe (laisser vide pour ne pas changer)') }}</label>
                            <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">
                            <input type="password" class="form-control mt-2" name="password_confirmation" placeholder="Confirmer le mot de passe">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Mettre à jour') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
