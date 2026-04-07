<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;

class BadgeExportController extends Controller
{
    public function exportSingle($id, $style, $format)
    {
        $employee = Employee::with('company')->findOrFail($id);
        
        // On passe 'isPdf' pour forcer le CSS spécifique si besoin
        $pdf = Pdf::loadView('company.badges.styles.style_' . $style, [
            'employee' => $employee, 
            'isPdf' => true
        ]);
        
        // Taille CR80 exacte (85.6mm x 54mm) convertie en points
        // On utilise 'landscape' car le badge est horizontal
        $pdf->setPaper([0, 0, 242.65, 153.07], 'landscape'); 
        
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true, // Important pour charger les ressources si besoin
        ]);

        return $pdf->download("badge-{$employee->last_name}.pdf");
    }
}