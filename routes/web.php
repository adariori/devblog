<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuteurController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Visibles par tout le monde : voir la liste
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Réservées aux connectés : créer, modifier, supprimer
// (déclarées AVANT /articles/{id} pour que "create" ne soit pas pris pour un id)
Route::middleware('auth')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// Détail d'un article (public) — en dernier car {id} est un joker
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Auteurs
Route::get('/auteurs', [AuteurController::class, 'index'])->name('auteurs.index');
Route::get('/auteurs/{id}', [AuteurController::class, 'show'])->name('auteurs.show');

// Catégories
Route::resource('categories', CategoryController::class)->except(['show']);

// Commentaires
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/admin/tableau-de-bord', [AdminController::class, 'index'])
    ->middleware('admin');
