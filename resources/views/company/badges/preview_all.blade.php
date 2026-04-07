<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélecteur de Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <style>
        @media print {
            @page { size: auto; margin: 0; }
            body { background: white; }
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            .badge-selected { 
                display: flex; justify-content: center; align-items: center;
                height: 100vh; width: 100vw;
            }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }

        /* TAILLES D'AFFICHAGE AGRANDIES POUR ÉVITER LES CHEVAUCHEMENTS */
        .badge-card {
            cursor: pointer;
            transition: transform 0.2s ease;
            background: white;
            border-radius: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Format Portrait standard (agrandi à l'écran) */
        .portrait-card {
            width: 70mm; /* Augmenté de 54mm */
            height: 105mm; /* Augmenté de 86mm */
        }

        /* Format Paysage (Style #04) */
        .landscape-card {
            width: 110mm; 
            height: 75mm;
        }

        .badge-card:hover {
            transform: translateY(-8px);
        }

        /* Sécurité pour les QR codes dans la prévisualisation */
        .qr-code-container img {
            max-width: 60px !important;
            height: auto !important;
            display: block;
        }
    </style>
</head>
<body class="bg-slate-50 p-4 md:p-10">

    <div class="max-w-[1400px] mx-auto no-print">
        <header class="mb-12 text-center">
            <h1 class="text-4xl font-black text-slate-800 uppercase italic">Générateur de Badges</h1>
            <p class="text-slate-500 font-medium">Employé : <span class="text-slate-900 underline">{{ $employee->first_name }} {{ $employee->last_name }}</span></p>
            
            <div class="flex justify-center gap-4 mt-6">
                <a href="{{ url('/company/dashboard') }}" class="bg-white border px-6 py-2 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 transition">← Dashboard</a>
                <button onclick="window.print()" class="bg-slate-900 text-white px-8 py-2 rounded-xl text-sm font-bold shadow-lg hover:bg-black transition">Imprimer tout</button>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16 justify-items-center">
            @foreach(range(1, 6) as $styleIndex)
                <div class="flex flex-col items-center group">
                    <span class="mb-4 text-xs font-black text-slate-300 uppercase tracking-widest group-hover:text-emerald-500 transition">Style #0{{ $styleIndex }}</span>
                    
                    <div id="badge-capture-{{ $styleIndex }}" 
                         class="badge-card {{ $styleIndex == 4 ? 'landscape-card' : 'portrait-card' }}">
                        @include('company.badges.styles.style_' . $styleIndex, ['employee' => $employee])
                    </div>

                    <div class="mt-8 flex flex-col gap-3 w-full px-4">
                        <button onclick="printThisStyle({{ $styleIndex }})" 
                                class="w-full bg-emerald-500 text-white py-3 rounded-2xl font-bold text-sm shadow-md hover:bg-emerald-600 transition">
                            Imprimer ce style
                        </button>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('badge.export.single', ['id' => $employee->id, 'style' => $styleIndex, 'format' => 'pdf']) }}" 
                               class="flex-1 bg-white border border-slate-200 text-center py-2 rounded-xl text-xs font-bold text-slate-600 hover:border-emerald-300 transition">
                                PDF
                            </a>
                            <button onclick="downloadPNG({{ $styleIndex }}, '{{ addslashes($employee->last_name) }}')" 
                                    class="flex-1 bg-white border border-slate-200 text-center py-2 rounded-xl text-xs font-bold text-slate-600 hover:border-emerald-300 transition">
                                PNG
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="print-zone" class="hidden print-only"></div>

    <script>
        function printThisStyle(index) {
            const printZone = document.getElementById('print-zone');
            printZone.innerHTML = `<div class="badge-selected">${document.querySelector('#badge-capture-' + index).innerHTML}</div>`;
            window.print();
        }

        function downloadPNG(index, name) {
            const element = document.querySelector('#badge-capture-' + index + ' .badge-fixed-container');
            if(!element) return alert("Erreur de capture");

            html2canvas(element, {
                scale: 4, // Très haute qualité pour les QR codes
                useCORS: true,
                backgroundColor: null
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `badge-${name}-style${index}.png`;
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        }
    </script>
</body>
</html>