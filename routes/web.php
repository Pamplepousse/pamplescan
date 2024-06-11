<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MangaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\MangaAdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ChapitreController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\ChapitreAdminController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\PersonnageController;
use App\Http\Controllers\LienPersonnageController;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PageController;
use App\Notifications\VerifyEmail;

// Routes pour la gestion des personnages
Route::get('/{idmanga}/characters/create', [PersonnageController::class, 'create'])->name('personnages.create');
Route::post('/{idmanga}/characters', [PersonnageController::class, 'store'])->name('personnages.store');
Route::resource('personnages', PersonnageController::class);
Route::get('/{idmanga}/characters', [PersonnageController::class, 'index'])->name('personnages.index');
Route::get('/{idmanga}/characters/{idpersonnage}', [PersonnageController::class, 'show'])->name('personnages.show');
Route::get('/{idmanga}/characters/{idpersonnage}/edit', [PersonnageController::class, 'edit'])->name('personnages.edit');
Route::put('/{idmanga}/characters/{idpersonnage}', 'PersonnageController@update')->name('personnages.update');

// Route pour la page RGPD
Route::get('/rgpd', [PageController::class, 'rgpd'])->name('rgpd');

// Route pour l'envoi de l'email de vérification
Route::get('/send-verification-email', [VerificationController::class, 'sendVerificationEmail'])->name('verification.send');

// Routes pour les commentaires et les interactions
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{comment}/like', [CommentLikeController::class, 'like'])->name('comments.like');
Route::post('/comments/{comment}/dislike', [CommentLikeController::class, 'dislike'])->name('comments.dislike');
Route::post('/comments/{comment}/toggle-like', [CommentLikeController::class, 'toggleLike'])->name('comments.toggle-like');

// Route pour afficher un manga
Route::get('/mangas/{idmanga}', [MangaController::class, 'show'])->name('mangas.show');

// Route pour la page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Route pour la redirection vers la page de compte
Route::get('/home', function () {
    return redirect('/account');
});

// Routes d'authentification
Auth::routes();
Auth::routes(['verify' => true]);

// Routes protégées pour les contributeurs authentifiés
Route::middleware(['auth', 'is.contrib'])->group(function () {
    Route::get('/chapter', [ChapitreController::class, 'index'])->name('chapitres.index');
    Route::get('/chapter/create', [ChapitreController::class, 'create'])->name('chapitres.create');
    Route::post('/chapter', [ChapitreController::class, 'store'])->name('chapitres.store');
    Route::post('/mangas', [MangaController::class, 'store'])->name('mangas.store');
    Route::get('/mangas/contrib/add', [MangaController::class, 'create'])->name('mangas.add');
    Route::get('/{idmanga}/characters/create', [PersonnageController::class, 'create'])->name('personnages.create');
    Route::post('/{idmanga}/characters', [PersonnageController::class, 'store'])->name('personnages.store');
    Route::get('/{idmanga}/characters/{idpersonnage}/edit', [PersonnageController::class, 'edit'])->name('personnages.edit');
    Route::put('/{idmanga}/characters/{idpersonnage}', [PersonnageController::class, 'update'])->name('personnages.update');
});

// Route pour envoyer un message via le formulaire de contact
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Routes protégées pour les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [UserProfileController::class, 'show'])->name('account');
    Route::get('/account/edit', [UserProfileController::class, 'edit'])->name('account.edit');
    Route::put('/account/update', [UserProfileController::class, 'update'])->name('account.update');
    Route::get('/access/request', [UserProfileController::class, 'requestAccess'])->name('access.request');
    Route::post('/access/request', [UserProfileController::class, 'submitAccessRequest'])->name('access.submit');
    Route::put('/account/update-profile-photo', [UserProfileController::class, 'updateProfilePhoto'])->name('account.updateProfilePhoto');
});

// Routes protégées pour les administrateurs
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/chapter', [ChapitreAdminController::class, 'index'])->name('admin.chapitres.index');
    Route::get('/chapter/create', [ChapitreAdminController::class, 'create'])->name('admin.chapitres.create');
    Route::post('/chapter', [ChapitreAdminController::class, 'store'])->name('admin.chapitres.store');
    Route::get('/chapter/{chapitre}/edit', [ChapitreAdminController::class, 'edit'])->name('admin.chapitres.edit');
    Route::put('/chapter/{chapitre}', [ChapitreAdminController::class, 'update'])->name('admin.chapitres.update');
    Route::delete('/chapter/{chapitre}', [ChapitreAdminController::class, 'destroy'])->name('admin.chapitres.destroy');
});

// Route pour la déconnexion
Route::post('/logout', function () {
    request()->session()->invalidate();
    return redirect('/');
})->name('logout');

// Route pour la recherche
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Route pour afficher un chapitre
Route::get('/chapitre/{idchap}', [ChapitreController::class, 'show'])->name('chapitre.show');

// Route pour la page d'accueil affichant les mangas
Route::get('/', [MangaController::class, 'index'])->name('home');

// Route pour afficher un manga
Route::get('/mangas/{idmanga}', [MangaController::class, 'show'])->name('manga.show');

// Route pour la déconnexion (redondante, déjà définie plus haut)
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Routes d'administration protégées par le middleware is_admin
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('admin/mangas', MangaAdminController::class);
    Route::post('/admin/mangas', [MangaAdminController::class, 'store'])->name('admin.mangas.store');
    Route::get('/admin/mangas', [MangaAdminController::class, 'index'])->name('admin.mangas.index');
    Route::get('/admin/mangas/create', [MangaAdminController::class, 'create'])->name('admin.mangas.create');
    Route::get('/admin/mangas/{manga}/edit', [MangaAdminController::class, 'edit'])->name('admin.mangas.edit');
    Route::put('/admin/mangas/{manga}', [MangaAdminController::class, 'update'])->name('admin.mangas.update');
    Route::delete('mangas/{manga}', [MangaAdminController::class, 'destroy'])->name('admin.mangas.destroy');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/pending-contributors', [AdminUserController::class, 'pendingContributors'])->name('admin.pending_contributors');
    Route::post('/admin/approve-contributor/{user}', [AdminUserController::class, 'approveContributor'])->name('admin.approve_contributor');
    Route::post('/admin/users/{user}/promote', [AdminUserController::class, 'promote'])->name('admin.users.promote');
    Route::post('/admin/users/{user}/demote', [AdminUserController::class, 'demote'])->name('admin.users.demote');
});

// Routes pour les catégories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'showMangasByCategory'])->name('categories.show');

// Route pour le tableau de bord admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth', 'is_admin')->name('admin.dashboard');

// Route pour la page À propos
Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about.index');

// Route pour les conditions générales d'utilisation (CGU)
Route::get('/cgu', [App\Http\Controllers\CguController::class, 'index'])->name('cgu');

// Route pour éditer le compte utilisateur
Route::get('/account/edit', [UserProfileController::class, 'edit'])->name('account.edit');

// Route pour mettre à jour le compte utilisateur
Route::post('/account/update', [UserProfileController::class, 'update'])->name('account.update');

// Route pour la demande d'accès contributeur
Route::get('/access/request', [UserProfileController::class, 'requestAccess'])->name('access.request');
Route::post('/access/submit', [UserProfileController::class, 'submitAccessRequest'])->name('access.submit');

// Route pour afficher la page de contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Route pour envoyer un message via le formulaire de contact (redondante, déjà définie plus haut)
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

