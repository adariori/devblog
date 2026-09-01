<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur n'est pas connecté OU n'est pas l'admin : on bloque
        if (! $request->user() || $request->user()->email !== 'admin@devblog.test') {
            abort(403); // Interdit
        }

        // Sinon, on laisse la requête continuer son chemin
        return $next($request);
    }
}
