<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @php 
        /* LOGIQUE DE CHEMIN D'ACCÈS GLOBALE */
        $is_export = isset($isPdf) && $isPdf;
        $getPath = function($path) use ($is_export) {
            if (empty($path)) return '';
            $cleanPath = str_replace('storage/', '', $path);
            return $is_export ? public_path('storage/' . $cleanPath) : asset('storage/' . $cleanPath);
        };

        // On récupère le style choisi par l'entreprise (ex: style_1, style_2...)
        // Si c'est vide pour une raison X, on met style_1 par défaut
        $selectedStyle = $employee->badge_style ?? 'style_1';
        $styleNumber = (int) filter_var($selectedStyle, FILTER_SANITIZE_NUMBER_INT);
    @endphp

    <style>
        .badge-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
            transition: all 0.3s ease;
        }

        /* Tailles réelles pour l'impression */
        .portrait-card { width: 85mm; height: 125mm; }
        .landscape-card { width: 125mm; height: 80mm; padding: 0; }

        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
            .badge-card { box-shadow: none; border: none; margin: 0; }
        }
    </style>
</head>
<body class="bg-slate-50 p-4 md:p-12">

    <div class="max-w-2xl mx-auto no-print text-center mb-8">
        <h1 class="text-2xl font-black uppercase text-slate-800">Félicitations !</h1>
        <p class="text-slate-500">Votre badge pour <strong>{{ $employee->company->name }}</strong> est prêt.</p>
    </div>

    <div class="flex flex-col items-center">
        {{-- Affichage unique du badge sélectionné --}}
        <div id="badge-final" 
             class="badge-card {{ in_array($styleNumber, [4, 6]) ? 'landscape-card' : 'portrait-card' }}">
            
            @include('company.badges.styles.' . $selectedStyle, [
                'employee' => $employee,
                'getPath' => $getPath
            ])
        </div>

        {{-- Actions --}}
        <div class="mt-10 flex flex-col sm:flex-row gap-4 no-print">
            <button onclick="window.print()" class="bg-emerald-600 text-white px-8 py-3 rounded-2xl font-bold hover:bg-emerald-700 transition shadow-xl shadow-emerald-100 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Imprimer mon badge
            </button>
            
            <a href="{{ route('badge.export.single', ['id' => $employee->id, 'style' => $styleNumber, 'format' => 'pdf']) }}" 
               class="bg-white border-2 border-slate-200 px-8 py-3 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Télécharger en PDF
            </a>
        </div>

        <p class="mt-6 text-slate-400 text-xs no-print italic">
            Note : Pour un résultat optimal, activez "Graphiques d'arrière-plan" dans les options d'impression.
        </p>
    </div>

</body>
</html>