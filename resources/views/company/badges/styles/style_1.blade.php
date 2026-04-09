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

        /* Motif de circuits ultra-dense et resserré */
        .circuit-pattern {
            position: absolute;
            left: 0;
            top: 0;
            width: 35%; 
            height: 100%;
            opacity: 0.85; /* Encore un peu plus opaque pour la visibilité */
            z-index: 1;
        /* SVG avec espacements réduits pour densifier le rendu */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 150'%3E%3Cg fill='none' stroke='%23{{ str_replace('#', '', $mainColor) }}' stroke-width='0.8'%3E%3C!-- Groupe de lignes resserrées haut --%3E%3Cpath d='M-10 5 L10 5 L20 15 L20 30 L35 45 L100 45'/%3E%3Cpath d='M-10 12 L8 12 L18 22 L18 35 L33 50 L100 50'/%3E%3Cpath d='M-10 25 L5 25 L15 35 L15 50 L30 65 L100 65'/%3E%3C!-- Groupe de lignes resserrées milieu --%3E%3Cpath d='M-10 45 L0 45 L10 55 L10 75 L25 90 L100 90'/%3E%3Cpath d='M-10 52 L-2 52 L8 62 L8 80 L23 95 L100 95'/%3E%3Cpath d='M-10 70 L-5 70 L5 80 L5 105 L20 120 L100 120'/%3E%3C!-- Groupe de lignes resserrées bas --%3E%3Cpath d='M-10 95 L-5 95 L5 105 L5 130 L15 140'/%3E%3Cpath d='M-10 102 L-7 102 L3 112 L3 135 L13 145'/%3E%3C!-- Points de connexion rapprochés --%3E%3Ccircle cx='20' cy='15' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='18' cy='22' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='15' cy='35' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='10' cy='55' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='8' cy='62' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='25' cy='90' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3Ccircle cx='23' cy='95' r='1.2' fill='%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: cover;
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