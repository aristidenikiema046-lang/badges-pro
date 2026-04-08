<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class BadgeExportController extends Controller
{
    /**
     * Exporte le badge en PDF en utilisant les réglages stockés en BDD.
     */
    public function exportSingle($id)
    {
        // 1. On récupère l'employé avec son entreprise
        $employee = Employee::with('company')->findOrFail($id);
        
        // 2. On récupère le style et la couleur depuis l'enregistrement de l'employé
        $style = $employee->badge_style ?? '1'; // Style par défaut si vide
        $color = $employee->badge_color ?? '#f97316';

        // 3. Helper pour les images (DomPDF préfère les chemins absolus locaux)
        $getPath = function($path) {
            if (!$path) return null;
            // Vérifie si le chemin contient déjà 'storage/', sinon l'ajoute
            $fullPath = str_starts_with($path, 'storage/') ? $path : 'storage/' . $path;
            return public_path($fullPath);
        };

        $viewData = [
            'employee' => $employee, 
            'isPdf'    => true,
            'getPath'  => $getPath,
            'color'    => $color // On passe la couleur à la vue
        ];

        // 4. Chargement de la vue dynamique selon le style
        // Chemin : resources/views/company/badges/styles/style_1.blade.php
        $pdf = Pdf::loadView('company.badges.styles.style_' . $style, $viewData);
        
        // 5. Configuration du format de papier (CR80 : 86mm x 54mm environ)
        // Style 6 est configuré en Horizontal (Paysage)
        if ($style == '6') {
            $pdf->setPaper([0, 0, 242.65, 153.07], 'landscape'); 
        } else {
            $pdf->setPaper([0, 0, 153.07, 242.65], 'portrait');
        }
        
        // 6. Options de rendu
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true, 
            'defaultFont'          => 'sans-serif'
        ]);

        // 7. Téléchargement du fichier
        $fileName = "badge-" . strtolower($employee->last_name) . ".pdf";
        return $pdf->download($fileName);
    }
}