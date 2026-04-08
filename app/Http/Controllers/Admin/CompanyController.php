<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    // ... autres méthodes (index, create, store, etc.) ...

    /**
     * Mettre à jour l'entreprise dans la base de données.
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email,' . $id,
            'phone'        => 'nullable|string|max:20',
            'manager_name' => 'nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'badge_style'  => 'required|string',
            'badge_color'  => 'required|string|max:7',
        ]);

        // Gestion du logo
        if ($request->hasFile('logo')) {
            // Suppression de l'ancien logo du disque s'il existe
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            // Stockage du nouveau logo
            $validated['logo'] = $request->file('logo')->store('logos_entreprises', 'public');
        } else {
            // On garde l'ancien logo si aucun nouveau n'est téléchargé
            $validated['logo'] = $company->logo;
        }

        // Mise à jour globale
        $company->update($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Entreprise mise à jour avec succès !');
    }
}