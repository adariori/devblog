<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuteurController;

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

Route::get('/auteurs', [AuteurController::class, 'index'])->name('auteurs.index');

Route::get('/auteurs/{id}', [AuteurController::class, 'show'])->name('auteurs.show');

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
