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

        /* Motif style Circuit Intégré remplissant toute la hauteur */
        .circuit-pattern {
            position: absolute;
            left: 0;
            top: 0;
            width: 38%; 
            height: 100%; /* Remplit toute la hauteur du conteneur parent */
            opacity: 0.9;
            z-index: 1;
        /* Utilisation de background-size: cover et un SVG optimisé pour la répétition verticale */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 200'%3E%3Cg fill='none' stroke='%23{{ str_replace('#', '', $mainColor) }}' stroke-width='0.7'%3E%3C!-- Bloc Haut --%3E%3Cpath d='M-5 10 h15 l10 10 v15 l10 10 h70'/%3E%3Cpath d='M-5 14 h14 l10 10 v15 l10 10 h71'/%3E%3Ccircle cx='10' cy='10' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C!-- Bloc Milieu Haut --%3E%3Cpath d='M-5 60 h25 l5 5 v20 l5 5 h65'/%3E%3Cpath d='M-5 65 h23 l5 5 v20 l5 5 h67'/%3E%3Crect x='15' y='58' width='2' height='2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C!-- Bloc Milieu Bas --%3E%3Cpath d='M-5 110 h15 l15 15 v25 l5 5 h60'/%3E%3Cpath d='M-5 114 h14 l15 15 v25 l5 5 h61'/%3E%3Ccircle cx='30' cy='125' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C!-- Bloc Bas --%3E%3Cpath d='M-5 160 h20 l10 10 v20 l10 10 h60'/%3E%3Cpath d='M-5 165 h18 l10 10 v20 l10 10 h62'/%3E%3Crect x='25' y='168' width='2' height='2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C!-- Interconnexions Verticales --%3E%3Cpath d='M12 0 v200' stroke-dasharray='4 2' opacity='0.3'/%3E%3Cpath d='M28 0 v200' stroke-dasharray='4 2' opacity='0.3'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: 100% 100%; /* Force le SVG à s'étirer sur toute la hauteur */
            background-position: left center;
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

        <div class="w-[40%] flex items-center justify-center p-10 z-10">
            <div class="w-full aspect-square rounded-[2rem] overflow-hidden shadow-xl bg-white border-4 border-white">
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