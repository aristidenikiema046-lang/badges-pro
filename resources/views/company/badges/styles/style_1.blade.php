@php 
    // Bleu profond et sombre par défaut
    $mainColor = $employee->company->badge_color ?? '#1e3a8a'; 
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}";
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Taille fixe pour éviter le rendu miniature */
        .badge-card {
            width: 650px;
            height: 400px;
            position: relative;
            background-color: white;
            border-radius: 30px;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            display: flex;
            overflow: hidden;
            border: 1px solid #f3f4f6;
        }

        /* NOUVEAU Motif de circuits densifié (zone verte), ressemble à l'image 2 */
        .circuit-pattern {
            position: absolute;
            left: 0;
            top: 0;
            width: 40%; /* Légèrement élargi pour accueillir la densité */
            height: 100%;
            opacity: 0.6; /* Un peu plus opaque pour mieux voir les détails */
            z-index: 1;
            /* SVG direct pour un tracé précis et complexe */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='250' height='400' viewBox='0 0 120 200'%3E%3Cg fill='none' stroke='%23{{ str_replace('#', '', $mainColor) }}' stroke-width='0.8'%3E%3C!-- Lignes principales denses --%3E%3Cpath d='M0 15h30l10 10v40l10 10h40'/%3E%3Cpath d='M0 50h20l15 15v50l10 10h50'/%3E%3Cpath d='M0 90h15l20 20v60l15 15h30'/%3E%3Cpath d='M0 130h10l25 25v45'/%3E%3Cpath d='M0 170h5l30 30'/%3E%3Cpath d='M20 0v20l10 10'/%3E%3Cpath d='M45 0v10l10 10'/%3E%3C!-- Points de connexion --%3E%3Ccircle cx='30' cy='25' r='1.5' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='50' cy='75' r='1.5' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='70' cy='125' r='2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='90' cy='165' r='1.5' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='55' cy='15' r='1' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: cover;
        }

        @media print {
            .no-print { display: none; }
            body { background: white; }
            .badge-card { box-shadow: none; border: 1px solid #ddd; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-slate-50 flex flex-col items-center justify-center min-h-screen p-4">

    <button onclick="window.print()" class="no-print mb-8 bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
        IMPRIMER LE BADGE
    </button>

    <div class="badge-card">
        <div class="circuit-pattern"></div>

        <div class="w-[45%] flex items-center justify-center p-8 z-10">
            <div class="w-full h-full rounded-[2.5rem] overflow-hidden shadow-2xl bg-white border-4 border-white">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">Photo</div>
                @endif
            </div>
        </div>

        <div class="w-[55%] flex flex-col p-10 justify-between text-right z-10">
            
            <div class="flex items-center justify-end gap-3">
                <span class="text-2xl font-bold text-slate-800 tracking-tighter">
                    {{ $employee->company->name ?? 'PAYMETRUST' }}
                </span>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto">
                @else
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">P</div>
                @endif
            </div>

            <div class="mt-4">
                <h1 class="text-4xl font-black text-slate-900 uppercase leading-none">
                    {{ $employee->last_name }}
                </h1>
                <h1 class="text-3xl font-bold text-slate-900 uppercase">
                    {{ $employee->first_name }}
                </h1>
                <p class="text-xl font-semibold mt-2" style="color: {{ $mainColor }}">
                    {{ $employee->function ?? 'Analyste Financier' }}
                </p>
                <p class="text-sm font-bold text-slate-400 mt-4">
                    Matricule : <span class="text-slate-600 font-mono">{{ $employee->matricule }}</span>
                </p>
            </div>

            <div class="flex justify-end mt-4">
                <div class="p-2 bg-white rounded-2xl shadow-sm border border-gray-50">
                    {!! QrCode::size(90)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>