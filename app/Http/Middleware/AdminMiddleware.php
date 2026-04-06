<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Gère une requête entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérifie si l'utilisateur est connecté
        // 2. Vérifie si son rôle est bien 'admin' (ajouté via la migration précédente)
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Si l'utilisateur n'est pas admin, on le redirige avec un message d'erreur
        return redirect('/')->with('error', 'Accès réservé à l\'administrateur.');
    }
}