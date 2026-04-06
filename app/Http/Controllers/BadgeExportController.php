<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BadgeExportController extends Controller
{
    /**
     * Exportation d'un badge unique (PDF ou affichage)
     */
    public function exportSingle($id, $style, $format)
    {
        // 1. Récupérer l'employé avec sa compagnie
        $employee = Employee::with('company')->findOrFail($id);

        // 2. Préparer les données pour la vue
        // On passe 'isPdf' => true pour que le style utilise les chemins physiques (public_path)
        $data = [
            'employee' => $employee,
            'isPdf'    => true 
        ];

        // 3. Définir le format de papier CR80 (85.6mm x 54mm) converti en points
        // [x, y, largeur, hauteur]
        $customPaper = [0, 0, 242.64, 153.07];

        if ($format === 'pdf') {
            // Charger la vue spécifique au style choisi
            $pdf = Pdf::loadView('company.badges.styles.style_' . $style, $data)
                ->setPaper($customPaper, 'portrait')
                ->setOptions([
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'defaultFont' => 'sans-serif',
                    'logOutputFile' => storage_path('logs/pdf.log'),
                ]);

            // Télécharger le fichier avec un nom propre
            return $pdf->download("badge-{$employee->last_name}-style-{$style}.pdf");
        }

        // Si le format n'est pas PDF, on retourne simplement la vue (pour test)
        return view('company.badges.styles.style_' . $style, array_merge($data, ['isPdf' => false]));
    }

    /**
     * Optionnel : Générer une planche de tous les styles en un seul PDF
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