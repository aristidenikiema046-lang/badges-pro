<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BadgeExportController extends Controller
{
    /**
     * Exportation d'un badge unique (PDF ou Vue)
     */
    public function exportSingle($id, $style, $format)
    {
        // 1. Récupération des données avec la relation company
        $employee = Employee::with('company')->findOrFail($id);

        $data = [
            'employee' => $employee, 
            'isPdf'    => true
        ];

        // 2. Format CR80 (85.6mm x 54mm) converti en points (72 DPI)
        // [0, 0, largeur, hauteur]
        $customPaper = [0, 0, 242.65, 153.07]; 

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('company.badges.styles.style_' . $style, $data);
            
            // Configuration cruciale : Papier personnalisé + Mode Paysage (Landscape)
            $pdf->setPaper($customPaper, 'landscape');
            
            // Options pour garantir le rendu des images et du HTML5
            $pdf->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'sans-serif',
            ]);

            return $pdf->download("badge-{$employee->last_name}-style-{$style}.pdf");
        }

        // Retour classique pour l'aperçu navigateur (format non PDF)
        return view('company.badges.styles.style_' . $style, array_merge($data, ['isPdf' => false]));
    }
}