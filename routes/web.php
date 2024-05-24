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
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{comment}/like', [CommentLikeController::class, 'like'])->name('comments.like');
Route::post('/comments/{comment}/dislike', [CommentLikeController::class, 'dislike'])->name('comments.dislike');
Route::post('/comments/{comment}/toggle-like', [CommentLikeController::class, 'toggleLike'])->name('comments.toggle-like');
Route::get('/mangas/{idmanga}', [MangaController::class, 'show'])->name('mangas.show');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return redirect('/account');
});

Auth::routes();

Route::middleware(['auth', 'is.contrib'])->group(function () {
    Route::get('/chapter', [ChapitreController::class, 'index'])->name('chapitres.index');
    Route::get('/chapter/create', [ChapitreController::class, 'create'])->name('chapitres.create');
    Route::post('/chapter', [ChapitreController::class, 'store'])->name('chapitres.store');
    Route::post('/mangas', [MangaController::class, 'store'])->name('mangas.store');
    Route::get('/mangas/contrib/add', [MangaController::class, 'create'])->name('mangas.add');

});



Route::middleware(['auth'])->group(function () {
    Route::get('/account', [UserProfileController::class, 'show'])->name('account');
    Route::get('/account/edit', [UserProfileController::class, 'edit'])->name('account.edit');
    Route::put('/account/update', [UserProfileController::class, 'update'])->name('account.update');  // Route PUT ajoutée
    Route::get('/access/request', [UserProfileController::class, 'requestAccess'])->name('access.request');
    Route::post('/access/request', [UserProfileController::class, 'submitAccessRequest'])->name('access.submit');
    Route::put('/account/update-profile-photo', [UserProfileController::class, 'updateProfilePhoto'])->name('account.updateProfilePhoto');
});

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    // Routes pour la gestion de chapitres
    Route::get('/chapter', [ChapitreAdminController::class, 'index'])->name('admin.chapitres.index');
    Route::get('/chapter/create', [ChapitreAdminController::class, 'create'])->name('admin.chapitres.create');
    Route::post('/chapter', [ChapitreAdminController::class, 'store'])->name('admin.chapitres.store');
    Route::get('/chapter/{chapitre}/edit', [ChapitreAdminController::class, 'edit'])->name('admin.chapitres.edit');
    Route::put('/chapter/{chapitre}', [ChapitreAdminController::class, 'update'])->name('admin.chapitres.update');
    Route::delete('/chapter/{chapitre}', [ChapitreAdminController::class, 'destroy'])->name('admin.chapitres.destroy');
});

Route::post('/logout', function () {request()->session()->invalidate();return redirect('/');})->name('logout');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/chapitre/{idchap}', [ChapitreController::class, 'show'])->name('chapitre.show');
Route::get('/', [MangaController::class, 'index'])->name('home');
Route::get('/mangas/{idmanga}', [MangaController::class, 'show'])->name('manga.show');
Route::post('/logout', function () {Auth::logout();request()->session()->invalidate();request()->session()->regenerateToken();return redirect('/');})->name('logout');

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

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'showMangasByCategory'])->name('categories.show');
Route::get('/admin/dashboard', function () {return view('admin.dashboard');})->middleware('auth', 'is_admin')->name('admin.dashboard');  // Assurez-vous que le middleware 'is_admin' est bien défini.
Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about.index');
Route::get('/cgu', [App\Http\Controllers\CguController::class, 'index'])->name('cgu');
Route::get('/account/edit', [UserProfileController::class, 'edit'])->name('account.edit');
Route::post('/account/update', [UserProfileController::class, 'update'])->name('account.update');
Route::get('/access/request', [UserProfileController::class, 'requestAccess'])->name('access.request');
Route::post('/access/submit', [UserProfileController::class, 'submitAccessRequest'])->name('access.submit');
Route::get('/contact', function () {return view('contact');})->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

