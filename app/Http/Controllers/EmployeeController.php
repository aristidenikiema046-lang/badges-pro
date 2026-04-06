<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * MODULE ENTREPRISE : Liste des employés
     */
    public function index()
    {
        $companyId = auth()->user()->company_id;

        if (!$companyId) {
            return redirect('/')->with('error', "Votre compte n'est lié à aucune entreprise.");
        }

        $employees = Employee::where('company_id', $companyId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('company.employees.index', compact('employees'));
    }

    /**
     * MODULE ENTREPRISE / PUBLIC : Enregistrement
     * Gère la création, le QR code et la REDIRECTION vers la prévisualisation.
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'function'     => 'required|string|max:255',
            'department'   => 'nullable|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'photo'        => 'required|image|max:2048',
            'badge_color'  => 'nullable|string|max:7',
        ]);

        // 2. Gestion de l'upload de la photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos_employes', 'public');
            $validated['photo'] = $path;
        }

        // 3. Génération automatique des identifiants techniques
        $validated['matricule'] = 'MAT-' . date('Y') . '-' . strtoupper(Str::random(6));
        $validated['badge_number'] = 'BP-' . date('Y') . '-' . strtoupper(Str::random(5));
        $validated['is_validated'] = true; 
        $validated['badge_color'] = $request->badge_color ?? '#059669';

        // 4. Création de l'employé
        $employee = Employee::create($validated);

        // 5. Génération du QR CODE
        $companyName = $employee->company->name ?? 'Entreprise';
        $qrData = "NOM: {$employee->last_name} | ID: {$employee->badge_number} | ENT: {$companyName}";
        
        $qrFolder = 'qrcodes';
        if (!Storage::disk('public')->exists($qrFolder)) {
            Storage::disk('public')->makeDirectory($qrFolder);
        }

        $qrPath = $qrFolder . '/qr-' . $employee->id . '.svg';
        
        $qrImage = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->generate($qrData);

        Storage::disk('public')->put($qrPath, $qrImage);

        // 6. Mise à jour avec le chemin du QR Code
        $employee->update(['qr_code' => $qrPath]);

        // 7. REDIRECTION VERS LA ROUTE PUBLIQUE DU BADGE
        // On utilise redirect()->route() pour déclencher le changement de page côté navigateur
        return redirect()->route('badge.preview', ['employee' => $employee->id])
                        ->with('success', 'Informations enregistrées ! Voici vos modèles de badges.');
    }

    /**
     * Suppression d'un employé (Sécurisé par entreprise)
     */
    public function destroy(Employee $employee)
    {
        if ($employee->company_id !== auth()->user()->company_id) {
            abort(403, "Action non autorisée.");
        }

        if ($employee->photo) Storage::disk('public')->delete($employee->photo);
        if ($employee->qr_code) Storage::disk('public')->delete($employee->qr_code);

        $employee->delete();

        return back()->with('success', 'Employé supprimé avec succès.');
    }
}