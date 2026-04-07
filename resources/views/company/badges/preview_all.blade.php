<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélecteur de Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @php 
        /* LOGIQUE DE CHEMIN D'ACCÈS GLOBALE */
        $is_export = isset($isPdf) && $isPdf;
        $getPath = function($path) use ($is_export) {
            if (empty($path)) return '';
            // Nettoyage du chemin pour éviter les doublons de /storage/
            $cleanPath = str_replace('storage/', '', $path);
            return $is_export ? public_path('storage/' . $cleanPath) : asset('storage/' . $cleanPath);
        };
    @endphp

    <style>
        /* TAILLES ÉLARGIES POUR UN RENDER COMPLET */
        .badge-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
            transition: all 0.3s ease;
        }

        /* Format Paysage Agrandi */
        .landscape-card {
            width: 120mm; 
            height: 75mm;
            padding: 0;
        }

        /* Format Portrait Agrandi */
        .portrait-card {
            width: 85mm;
            height: 125mm;
        }

        .badge-card:hover {
            transform: scale(1.02);
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white; p: 0; }
            .badge-card { box-shadow: none; border: 1px solid #eee; margin: 0; }
        }
    </style>
</head>
<body class="bg-slate-50 p-8">

    <div class="max-w-7xl mx-auto no-print text-center mb-12">
        <h1 class="text-3xl font-black uppercase text-slate-800">Interface de Prévisualisation</h1>
        <p class="text-slate-500">Choisissez votre modèle parmi les 6 designs disponibles</p>
        <div class="mt-2 inline-block px-4 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-bold">
            Couleur choisie : {{ $employee->badge_color }}
        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-12">
        @foreach(range(1, 6) as $styleIndex)
            <div class="flex flex-col items-center">
                <span class="mb-4 font-bold text-slate-400 uppercase tracking-tighter">Modèle Dynamique #0{{ $styleIndex }}</span>
                
                <div id="badge-{{ $styleIndex }}" 
                     class="badge-card {{ in_array($styleIndex, [4, 6]) ? 'landscape-card' : 'portrait-card' }}">
                    
                    {{-- On passe le $getPath explicitement pour être sûr --}}
                    @include('company.badges.styles.style_' . $styleIndex, [
                        'employee' => $employee, 
                        'getPath' => $getPath
                    ])
                </div>

                <div class="mt-6 flex gap-3 no-print">
                    <button onclick="window.print()" class="bg-emerald-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-emerald-600 transition shadow-lg shadow-emerald-200">
                        Imprimer ce style
                    </button>
                    {{-- Note: Pour l'export PNG, il faudra lier cela à votre contrôleur backend --}}
                    <a href="{{ route('employee.download.png', ['id' => $employee->id, 'style' => $styleIndex]) }}" 
                       class="bg-white border border-slate-200 px-6 py-2 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">
                       Exporter PNG
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>