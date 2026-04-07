<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélecteur de Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
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

        /* Format Paysage Agrandi (Recommandé pour tout faire rentrer) */
        .landscape-card {
            width: 120mm; 
            height: 75mm;
            padding: 0;
        }

        /* Format Portrait Agrandi */
        .portrait-card {
            width: 80mm;
            height: 125mm;
        }

        .badge-card:hover {
            transform: scale(1.02);
        }

        @media print {
            .no-print { display: none !important; }
            .badge-card { box-shadow: none; border: 1px solid #eee; }
        }
    </style>
</head>
<body class="bg-slate-50 p-8">

    <div class="max-w-7xl mx-auto no-print text-center mb-12">
        <h1 class="text-3xl font-black uppercase text-slate-800">Interface de Prévisualisation</h1>
        <p class="text-slate-500">Ajustement automatique pour : {{ $employee->first_name }} {{ $employee->last_name }}</p>
    </div>

    <div class="flex flex-wrap justify-center gap-12">
        @foreach(range(1, 6) as $styleIndex)
            <div class="flex flex-col items-center">
                <span class="mb-4 font-bold text-slate-400 uppercase tracking-tighter">Modèle Dynamique #0{{ $styleIndex }}</span>
                
                <div id="badge-{{ $styleIndex }}" 
                     class="badge-card {{ in_array($styleIndex, [4, 6]) ? 'landscape-card' : 'portrait-card' }}">
                    @include('company.badges.styles.style_' . $styleIndex, ['employee' => $employee])
                </div>

                <div class="mt-6 flex gap-3">
                    <button onclick="window.print()" class="bg-emerald-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-emerald-600 transition">Imprimer</button>
                    <button class="bg-white border px-6 py-2 rounded-xl font-bold text-slate-600 hover:bg-slate-50 transition">Exporter PNG</button>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>