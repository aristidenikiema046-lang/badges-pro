<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BadgeExportController extends Controller
{
    /**
     * Exportation d'un badge unique (PDF)
     */
    public function exportSingle($id, $style, $format)
    {
        // 1. Récupérer l'employé avec sa compagnie
        $employee = Employee::with('company')->findOrFail($id);

        // 2. Préparer les données pour la vue
        $data = [
            'employee' => $employee,
            'isPdf'    => true 
        ];

        // 3. Définir le format de papier CR80 exact en points (72 DPI)
        // [x, y, largeur, hauteur] -> 85.6mm x 54mm
        $customPaper = [0, 0, 242.65, 153.07]; 

        if ($format === 'pdf') {
            // Charger la vue spécifique
            $pdf = Pdf::loadView('company.badges.styles.style_' . $style, $data);
            
            // Configuration du papier en mode paysage (Landscape) pour un badge horizontal
            $pdf->setPaper($customPaper, 'landscape');
            
            $pdf->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'sans-serif',
                'enable_php' => true,
            ]);

            return $pdf->download("badge-{$employee->last_name}-style-{$style}.pdf");
        }

        // Retour pour test ou aperçu navigateur
        return view('company.badges.styles.style_' . $style, array_merge($data, ['isPdf' => false]));
    }

    /**
     * Optionnel : Générer une planche A4
     */
    public function exportAllStyles($id)
    {
        $employee = Employee::with('company')->findOrFail($id);
        
        $pdf = Pdf::loadView('company.badges.all_styles_pdf', [
            'employee' => $employee,
            'isPdf' => true
        ])->setPaper('a4', 'portrait');

        return $pdf->download("tous-les-styles-{$employee->last_name}.pdf");
    }
}