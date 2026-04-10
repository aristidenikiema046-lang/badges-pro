<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la vue de connexion.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gère une demande d'authentification entrante.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentifier l'utilisateur via les règles définies dans LoginRequest
        $request->authenticate();

        // Régénérer la session pour éviter les fixations de session
        $request->session()->regenerate();

        $user = Auth::user();

        /**
         * LOGIQUE DE REDIRECTION DYNAMIQUE
         * On redirige l'utilisateur selon son rôle défini en base de données.
         */
        
        // 1. Si c'est un Administrateur YA Consulting
        if ($user->role === 'admin') {
            return redirect()->intended(route('companies.index'));
        } 
        
        // 2. Si c'est une Entreprise partenaire (Client)
        // On vérifie qu'il a bien une entreprise liée pour éviter les erreurs sur le slug
        if ($user->role === 'client' && $user->company) {
            return redirect()->intended(route('company.employees', ['slug' => $user->company->slug]));
        }

        // 3. Redirection par défaut (Accueil) si le rôle n'est pas reconnu
        return redirect()->intended('/');
    }

    /**
     * Détruit une session authentifiée (Déconnexion).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}