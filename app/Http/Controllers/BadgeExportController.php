<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class BadgeExportController extends Controller
{
    public function exportSingle($id, $style, $format)
    {
        $employee = Employee::with('company')->findOrFail($id);
        
        // Helper pour les images en mode PDF (chemins locaux impératifs pour DomPDF)
        $getPath = function($path) {
            if (!$path) return null;
            return public_path($path); 
        };

        $viewData = [
            'employee' => $employee, 
            'isPdf' => true,
            'getPath' => $getPath
        ];

        $pdf = Pdf::loadView('company.badges.styles.style_' . $style, $viewData);
        
        // --- LOGIQUE DE FORMAT ---
        // Styles 4, 5 sont en Portrait (Vertical)
        // Style 6 est en Landscape (Horizontal)
        if ($style == 6) {
            $pdf->setPaper([0, 0, 242.65, 153.07], 'landscape'); // Format CR80 Horizontal
        } else {
            $pdf->setPaper([0, 0, 153.07, 242.65], 'portrait');  // Format CR80 Vertical
        }
        
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true, 
            'defaultFont' => 'sans-serif'
        ]);

        return $pdf->download("badge-{$employee->last_name}-style{$style}.pdf");
    }
}