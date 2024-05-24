@extends('layouts.app')

@section('content')
<section>
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            @if ($user->profile_photo)
                <img src="{{ asset('public/picture/profile_picture/' . $user->profile_photo) }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
            @else
                <img src="{{ asset('public/picture/profile_picture/default.jpg') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
            @endif
            <h5 class="my-3">{{ $user->name }}</h5>
            <!-- Formulaire pour mettre à jour la photo de profil -->
            <form action="{{ route('account.updateProfilePhoto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="profile_photo" class="form-label">Choisir une nouvelle photo de profil</label>
                    <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Nom</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->name }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->email }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Genre</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">
                  @if ($user->gender === 'male')
                      Homme
                  @elseif ($user->gender === 'female')
                      Femme
                  @else
                      Autre
                  @endif
                </p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Role</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->role }}</p>
              </div>
            </div>
            <hr>
            <!-- Bouton d'édition du profil -->
            <a href="{{ route('account.edit') }}" class="btn btn-primary">Modifier mon profil</a>

            <!-- Bouton de demande d'accès contributeur -->
            @if ($user->role === 'user')
                <a href="{{ route('access.request') }}" class="btn btn-secondary">Demander un accès contributeur</a>
            @endif
            @if ($user->role === 'contrib')
            <a href="{{ route('mangas.add') }}" class="btn btn-success">Ajouter un Manga/Œuvre</a>
            <a href="{{ route('chapitres.create') }}" class="btn btn-success">Ajouter un Chapitre</a>
            @endif
              @if ($user->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-success">Tableau de bord administrateur</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection


