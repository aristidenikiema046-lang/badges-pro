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
            // Nettoyage pour éviter les doublons de /storage/ dans l'URL
            $cleanPath = str_replace('storage/', '', $path);
            return $is_export ? public_path('storage/' . $cleanPath) : asset('storage/' . $cleanPath);
        };
    @endphp

    <style>
        /* CONFIGURATION DES FORMATS DE BADGES */
        .badge-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
            transition: all 0.3s ease;
        }

        /* Format Portrait (Styles 1, 2, 3, 5) */
        .portrait-card {
            width: 85mm;
            height: 125mm;
        }

        /* Format Paysage (Styles 4, 6) */
        .landscape-card {
            width: 125mm; 
            height: 80mm;
            padding: 0;
        }

        .badge-card:hover {
            transform: scale(1.02);
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; }
            .badge-card { box-shadow: none; border: 1px solid #eee; margin: 0; }
        }
    </style>
</head>
<body class="bg-slate-50 p-8">

    <div class="max-w-7xl mx-auto no-print text-center mb-12">
        <h1 class="text-3xl font-black uppercase text-slate-800">Interface de Prévisualisation</h1>
        <p class="text-slate-500">Aperçu en temps réel pour <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></p>
        
        <div class="mt-4 flex justify-center gap-4">
            <span class="px-4 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold uppercase">
                Département : {{ $employee->department ?? 'Non défini' }}
            </span>
            <span class="px-4 py-1 bg-slate-200 text-slate-700 rounded-full text-xs font-bold uppercase">
                Couleur : {{ $employee->badge_color }}
            </span>
        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-12">
        @foreach(range(1, 6) as $styleIndex)
            <div class="flex flex-col items-center">
                <span class="mb-4 font-bold text-slate-400 uppercase tracking-widest text-xs">
                    Design Option #0{{ $styleIndex }}
                </span>
                
                <div id="badge-container-{{ $styleIndex }}" 
                     class="badge-card {{ in_array($styleIndex, [4, 6]) ? 'landscape-card' : 'portrait-card' }}">
                    
                    {{-- INCLUSION DU STYLE AVEC INJECTION DE LA FONCTION GETPATH --}}
                    @include('company.badges.styles.style_' . $styleIndex, [
                        'employee' => $employee,
                        'getPath' => $getPath
                    ])
                </div>

                <div class="mt-6 flex gap-3 no-print">
                    <button onclick="window.print()" class="bg-emerald-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-emerald-700 transition shadow-lg shadow-emerald-100">
                        Imprimer
                    </button>
                    
                    <a href="#" class="bg-white border border-slate-200 px-6 py-2 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">
                        Télécharger
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>