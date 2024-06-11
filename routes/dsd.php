<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    SearchController,
    MangaController,
    UserProfileController,
    ChapitreController,
    CommentController,
    CommentLikeController,
    PersonnageController,
    CategoryController,
    ContactController,
    PageController,
    Auth\VerificationController

};
use App\Http\Controllers\Admin\{
    MangaAdminController,
    ChapitreAdminController,
    UserController as AdminUserController,
    AdminUserController as AdminUserProfileController
};

// Routes publiques
Route::get('/', [MangaController::class, 'index'])->name('home');
Route::get('/home', function () {
    return redirect('/account');
});
Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about.index');
Route::get('/cgu', [App\Http\Controllers\CguController::class, 'index'])->name('cgu');
Route::get('/rgpd', [PageController::class, 'rgpd'])->name('rgpd');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'showMangasByCategory'])->name('categories.show');
Route::get('/mangas/{idmanga}', [MangaController::class, 'show'])->name('mangas.show');
Route::get('/chapitre/{idchap}', [ChapitreController::class, 'show'])->name('chapitre.show');

// Auth routes
Auth::routes(['verify' => true]);

// Email Verification
Route::get('/send-verification-email', [VerificationController::class, 'sendVerificationEmail'])->name('verification.send');

// Routes nécessitant l'authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [UserProfileController::class, 'show'])->name('account');
    Route::get('/account/edit', [UserProfileController::class, 'edit'])->name('account.edit');
    Route::put('/account/update', [UserProfileController::class, 'update'])->name('account.update');
    Route::put('/account/update-profile-photo', [UserProfileController::class, 'updateProfilePhoto'])->name('account.updateProfilePhoto');
    Route::get('/access/request', [UserProfileController::class, 'requestAccess'])->name('access.request');
    Route::post('/access/request', [UserProfileController::class, 'submitAccessRequest'])->name('access.submit');

    // Comment routes
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/like', [CommentLikeController::class, 'like'])->name('comments.like');
    Route::post('/comments/{comment}/dislike', [CommentLikeController::class, 'dislike'])->name('comments.dislike');
    Route::post('/comments/{comment}/toggle-like', [CommentLikeController::class, 'toggleLike'])->name('comments.toggle-like');

    // Routes pour les contributeurs
    Route::middleware(['is.contrib'])->group(function () {
        Route::get('/chapter', [ChapitreController::class, 'index'])->name('chapitres.index');
        Route::get('/chapter/create', [ChapitreController::class, 'create'])->name('chapitres.create');
        Route::post('/chapter', [ChapitreController::class, 'store'])->name('chapitres.store');
        Route::post('/mangas', [MangaController::class, 'store'])->name('mangas.store');
        Route::get('/mangas/contrib/add', [MangaController::class, 'create'])->name('mangas.add');

        // Personnage routes
        Route::get('/{idmanga}/characters/create', [PersonnageController::class, 'create'])->name('personnages.create');
        Route::post('/{idmanga}/characters', [PersonnageController::class, 'store'])->name('personnages.store');
        Route::get('/{idmanga}/characters/{idpersonnage}/edit', [PersonnageController::class, 'edit'])->name('personnages.edit');
        Route::put('/{idmanga}/characters/{idpersonnage}', [PersonnageController::class, 'update'])->name('personnages.update');
    });
});

// Routes d'administration
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Routes pour les chapitres
    Route::get('/chapter', [ChapitreAdminController::class, 'index'])->name('admin.chapitres.index');
    Route::get('/chapter/create', [ChapitreAdminController::class, 'create'])->name('admin.chapitres.create');
    Route::post('/chapter', [ChapitreAdminController::class, 'store'])->name('admin.chapitres.store');
    Route::get('/chapter/{chapitre}/edit', [ChapitreAdminController::class, 'edit'])->name('admin.chapitres.edit');
    Route::put('/chapter/{chapitre}', [ChapitreAdminController::class, 'update'])->name('admin.chapitres.update');
    Route::delete('/chapter/{chapitre}', [ChapitreAdminController::class, 'destroy'])->name('admin.chapitres.destroy');

    // Routes pour les mangas
    Route::resource('mangas', MangaAdminController::class);
    Route::post('/mangas', [MangaAdminController::class, 'store'])->name('admin.mangas.store');
    Route::get('/mangas', [MangaAdminController::class, 'index'])->name('admin.mangas.index');
    Route::get('/mangas/create', [MangaAdminController::class, 'create'])->name('admin.mangas.create');
    Route::get('/mangas/{manga}/edit', [MangaAdminController::class, 'edit'])->name('admin.mangas.edit');
    Route::put('/mangas/{manga}', [MangaAdminController::class, 'update'])->name('admin.mangas.update');
    Route::delete('mangas/{manga}', [MangaAdminController::class, 'destroy'])->name('admin.mangas.destroy');

    // Routes pour les utilisateurs
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/promote', [AdminUserProfileController::class, 'promote'])->name('admin.users.promote');
    Route::post('/users/{user}/demote', [AdminUserProfileController::class, 'demote'])->name('admin.users.demote');
    Route::get('/pending-contributors', [AdminUserProfileController::class, 'pendingContributors'])->name('admin.pending_contributors');
    Route::post('/approve-contributor/{user}', [AdminUserProfileController::class, 'approveContributor'])->name('admin.approve_contributor');
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Personnage routes
Route::resource('personnages', PersonnageController::class);
Route::get('/{idmanga}/characters', [PersonnageController::class, 'index'])->name('personnages.index');
Route::get('/{idmanga}/characters/{idpersonnage}', [PersonnageController::class, 'show'])->name('personnages.show');

Route::get('/{idmanga}/characters/{idpersonnage}/edit', [PersonnageController::class, 'edit'])->name('personnages.edit');
Route::put('/{idmanga}/characters/{idpersonnage}', [PersonnageController::class, 'update'])->name('personnages.update');
