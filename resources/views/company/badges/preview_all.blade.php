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

        // On récupère le style de l'entreprise
        $selectedStyle = $employee->company->badge_style ?? 'style_1';
        
        // Style 6 est horizontal. Ajoutez d'autres styles ici si nécessaire.
        $landscapeStyles = ['style_6']; 
        $isLandscape = in_array($selectedStyle, $landscapeStyles);
    @endphp

    <style>
        /* Base du badge */
        .badge-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
            transition: all 0.3s ease;
            border: 2px solid {{ $employee->company->badge_color }}20; 
            box-sizing: border-box; /* Crucial pour que la bordure ne rajoute pas de largeur */
        }

        /* Tailles strictes pour éviter le rognage */
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

        /* Ajustements pour l'impression */
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
                border: 1px solid #eee; /* Bordure très fine pour la découpe */
                margin: 0; 
                border-radius: 0; /* Souvent mieux pour la découpe réelle */
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
            Le badge de <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong> pour <strong>{{ $employee->company->name }}</strong> est prêt.
        </p>
    </div>

    <div class="flex flex-col items-center">
        <!-- Zone du Badge -->
        <div id="badge-final" 
             class="badge-card {{ $isLandscape ? 'landscape-card' : 'portrait-card' }}">
            
            <!-- Inclusion dynamique du style -->
            @include('company.badges.styles.' . $selectedStyle, [
                'employee' => $employee,
                'getPath' => $getPath
            ])
        </div>

        <!-- Barre d'actions -->
        <div class="mt-10 flex flex-col sm:flex-row gap-4 no-print">
            <button onclick="window.print()" 
                    class="text-white px-10 py-4 rounded-2xl font-bold hover:opacity-90 transition shadow-xl flex items-center gap-3 text-lg" 
                    style="background-color: {{ $employee->company->badge_color }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Imprimer le badge
            </button>
            
            <a href="{{ route('badge.export.single', ['id' => $employee->id, 'style' => $selectedStyle, 'format' => 'pdf']) }}" 
               class="bg-white border-2 px-10 py-4 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition flex items-center gap-3 text-lg"
               style="border-color: {{ $employee->company->badge_color }}60">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Télécharger (PDF)
            </a>
        </div>

        <p class="mt-8 text-slate-400 text-sm no-print italic bg-white px-4 py-2 rounded-full border border-slate-200 shadow-sm">
            💡 Conseil : Activez "Graphiques d'arrière-plan" dans vos paramètres d'impression.
        </p>
    </div>

</body>
</html>