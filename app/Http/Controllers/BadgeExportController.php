<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BadgeExportController extends Controller
{
    public function exportSingle($id, $style, $format)
    {
        $employee = Employee::with('company')->findOrFail($id);
        $data = ['employee' => $employee, 'isPdf' => true];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('company.badges.styles.style_' . $style, $data);
            
            // On utilise le format A6 en paysage pour donner de l'espace.
            // Cela évite que le moteur de rendu ne tronque le badge si un élément dépasse.
            $pdf->setPaper('a6', 'landscape'); 
            
            $pdf->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'sans-serif',
            ]);

            return $pdf->download("badge-{$employee->last_name}.pdf");
        }

        return view('company.badges.styles.style_' . $style, array_merge($data, ['isPdf' => false]));
    }
}