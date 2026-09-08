<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// Connexion : délivre un jeton (badge d'accès)
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    // Vérifie que l'utilisateur existe ET que le mot de passe correspond
    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Identifiants incorrects.'], 401);
    }

    // On délivre un jeton
    $token = $user->createToken('appli-mobile')->plainTextToken;

    return response()->json(['token' => $token]);
});

// Public : lecture
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::get('/articles/{article}/comments', [CommentController::class, 'index']);

// Réservé aux porteurs d'un jeton valide
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{id}', [ArticleController::class, 'update']);
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);

    Route::post('/articles/{article}/comments', [CommentController::class, 'store']);

    // Déconnexion : on détruit le jeton courant (désactive le badge)
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté.']);
    });
});
