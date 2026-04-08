<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @php 
        $is_export = isset($isPdf) && $isPdf;
        $getPath = function($path) use ($is_export) {
            if (empty($path)) return '';
            $cleanPath = str_replace('storage/', '', $path);
            return $is_export ? public_path('storage/' . $cleanPath) : asset('storage/' . $cleanPath);
        };

        $selectedStyle = $employee->company->badge_style ?? 'style_1';
        
        // Liste des styles horizontaux
        $landscapeStyles = ['style_4', 'style_6']; 
        $isLandscape = in_array($selectedStyle, $landscapeStyles);
    @endphp

    <style>
        /* Base du badge - Optimisée pour la visibilité totale */
        .badge-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            display: flex;
            transition: all 0.3s ease;
            border: 2px solid {{ $employee->company->badge_color }}20; 
            box-sizing: border-box;
            position: relative;
            /* On laisse l'overflow visible sur l'écran pour détecter les erreurs de design */
            overflow: visible; 
        }

        /* Tailles ISO Standards (CR80 ajusté) */
        .portrait-card { 
            width: 85mm; 
            height: 125mm; 
            min-width: 85mm; 
            max-width: 85mm;
            min-height: 125mm;
            max-height: 125mm;
        }

        .landscape-card { 
            width: 125mm; 
            height: 85mm; 
            min-width: 125mm; 
            max-width: 125mm;
            min-height: 85mm;
            max-height: 85mm;
        }

        /* Empêche les images à l'intérieur de dépasser si elles n'ont pas de classe Tailwind */
        .badge-card img {
            max-width: 100%;
        }

        @media print {
            .no-print { display: none !important; }
            @page { 
                size: auto; 
                margin: 0mm; 
            }
            body { 
                background: white; 
                padding: 0; 
                margin: 0; 
                display: flex; 
                justify-content: center; 
                align-items: center; 
                height: 100vh; 
            }
            .badge-card { 
                box-shadow: none; 
                border: 1px solid #eee; 
                margin: 0; 
                border-radius: 0;
                overflow: hidden; /* Obligatoire pour une découpe propre à l'impression */
            }
        }
    </style>
</head>
<body class="bg-slate-50 p-4 md:p-12">

    <div class="max-w-2xl mx-auto no-print text-center mb-8">
        <h1 class="text-3xl font-black uppercase tracking-tight" style="color: {{ $employee->company->badge_color }}">
            Félicitations !
        </h1>
        <p class="text-slate-500 mt-2">
            Le badge de <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong> est prêt.
        </p>
    </div>

    <div class="flex flex-col items-center">
        <!-- Conteneur de prévisualisation avec padding pour éviter le rognage visuel -->
        <div class="p-4 bg-transparent">
            <div id="badge-final" 
                 class="badge-card {{ $isLandscape ? 'landscape-card' : 'portrait-card' }}">
                
                <div class="w-full h-full overflow-hidden rounded-[1.4rem]">
                    @include('company.badges.styles.' . $selectedStyle, [
                        'employee' => $employee,
                        'getPath' => $getPath
                    ])
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-10 flex flex-col sm:flex-row gap-4 no-print">
            <button onclick="window.print()" 
                    class="text-white px-10 py-4 rounded-2xl font-bold hover:opacity-90 transition shadow-xl flex items-center gap-3 text-lg" 
                    style="background-color: {{ $employee->company->badge_color }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Imprimer
            </button>
            
            <a href="{{ route('badge.export.single', ['id' => $employee->id, 'style' => $selectedStyle, 'format' => 'pdf']) }}" 
               class="bg-white border-2 px-10 py-4 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition flex items-center gap-3 text-lg"
               style="border-color: {{ $employee->company->badge_color }}60">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                PDF
            </a>
        </div>
    </div>

</body>
</html>