@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modifier mon profil') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('account.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="gender">Genre</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Homme</option>
                                <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Femme</option>
                                <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small>Laissez vide si vous ne souhaitez pas changer votre mot de passe</small>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

