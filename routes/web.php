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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return redirect('/account');
});

Auth::routes();

Route::get('/account', [App\Http\Controllers\HomeController::class, 'index'])->name('account');

Route::post('/logout', function () {
    request()->session()->invalidate();
    return redirect('/');
})->name('logout');

Route::post('/mangas', 'MangaController@store')->name('mangas.store')->middleware('role:contrib,admin');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/chapitre/{idchap}', [ChapitreController::class, 'show'])->name('chapitre.show');

Route::get('/', [MangaController::class, 'index'])->name('home');

Route::get('/mangas/{idmanga}', [MangaController::class, 'show'])->name('manga.show');

Route::get('/mangas/{idmanga}', [MangaController::class, 'show'])->name('mangas.show');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Routes pour l'administration avec middleware pour vérifier l'accès admin
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
    Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/pending-contributors', [AdminUserController::class, 'pendingContributors'])->name('admin.pending_contributors');
    Route::post('/admin/approve-contributor/{user}', [AdminUserController::class, 'approveContributor'])->name('admin.approve_contributor');
});

// Ajout d'un middleware dans web.php
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth', 'is_admin')->name('admin.dashboard');  // Assurez-vous que le middleware 'is_admin' est bien défini.

// web.php
Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about.index');

Route::get('/account/edit', [UserProfileController::class, 'edit'])->name('account.edit');

Route::post('/account/update', [UserProfileController::class, 'update'])->name('account.update');

// Route pour la demande d'accès contributeur
Route::get('/access/request', [UserProfileController::class, 'requestAccess'])->name('access.request');
Route::post('/access/submit', [UserProfileController::class, 'submitAccessRequest'])->name('access.submit');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
