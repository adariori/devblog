<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuteurController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

// Le formulaire de création (GET)
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');

// L'enregistrement (POST)
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');

// La liste et le détail (déjà vus au Module 4)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Afficher le formulaire d'édition (GET)
Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

// Enregistrer les modifications (PUT)
Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');

Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');

Route::get('/auteurs', [AuteurController::class, 'index'])->name('auteurs.index');

Route::get('/auteurs/{id}', [AuteurController::class, 'show'])->name('auteurs.show');

//Category
Route::resource('categories', CategoryController::class)->except(['show']);

//Commentaires 
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');




// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/articles', function () {
//     return 'Voici bientôt la liste de tous les articles.';
// });

// Route::get('/articles/{id}', function ($id) {
//     return 'Vous consultez l\'article numéro : ' . $id;
// });

// Route::get('/contact', function () {
//     return 'Page de contact de DevBlog.';
// })->name('contact');
