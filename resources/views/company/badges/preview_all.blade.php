<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélecteur de Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <style>
        /* CONFIGURATION IMPRESSION PROFESSIONNELLE */
        @media print {
            @page {
                size: 85.6mm 54mm; /* Taille physique CR80 */
                margin: 0;
            }
            body { background: white; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            
            .badge-selected { 
                width: 85.6mm !important; 
                height: 54mm !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden;
            }
            
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* STYLE ÉCRAN */
        .badge-card {
            width: 85.6mm;
            height: 54mm;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            background: white;
            overflow: hidden; /* Important pour html2canvas */
        }

        .badge-card:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="bg-slate-100 p-4 md:p-8">

    <div class="max-w-7xl mx-auto no-print">
        <header class="mb-12 text-center">
            <h1 class="text-4xl font-black text-slate-800 tracking-tight">Générateur de Badges</h1>
            <p class="text-slate-500 mt-2 text-lg">
                Employé : <span class="font-bold text-slate-900">{{ $employee->first_name }} {{ $employee->last_name }}</span>
            </p>
            
            <div class="flex justify-center gap-4 mt-8">
                <button onclick="window.print()" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition flex items-center gap-2">
                    <span>🖨️</span> Imprimer tous les modèles
                </button>
            </div>
        </header>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-16 justify-items-center">
            @foreach(range(1, 6) as $styleIndex)
                <div class="flex flex-col items-center w-full">
                    <div class="flex justify-between w-[85.6mm] mb-4 px-2">
                        <span class="font-black text-slate-400 uppercase text-xs tracking-[0.2em]">Modèle #0{{ $styleIndex }}</span>
                    </div>
                    
                    <div id="badge-capture-{{ $styleIndex }}" 
                         class="badge-card shadow-2xl rounded-xl"
                         onclick="printThisStyle({{ $styleIndex }})">
                        @include('company.badges.styles.style_' . $styleIndex, ['employee' => $employee])
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button onclick="printThisStyle({{ $styleIndex }})" 
                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-full font-bold text-sm shadow-md transition">
                            Imprimer
                        </button>
                        
                        <div class="flex bg-white rounded-full shadow-md border overflow-hidden">
                            <a href="{{ route('badge.export.single', ['id' => $employee->id, 'style' => $styleIndex, 'format' => 'pdf']) }}" 
                               class="px-4 py-2 hover:bg-slate-50 border-r text-sm font-bold text-slate-600 transition">
                                PDF
                            </a>
                            <button onclick="downloadPNG({{ $styleIndex }}, '{{ $employee->last_name }}')" 
                                    class="px-4 py-2 hover:bg-slate-50 text-sm font-bold text-slate-600 transition">
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
            const badgeContent = document.querySelector('#badge-capture-' + index).innerHTML;
            
            printZone.innerHTML = `<div class="badge-selected">${badgeContent}</div>`;
            window.print();
        }

        function downloadPNG(index, lastName) {
            const element = document.querySelector('#badge-capture-' + index + ' > div');
            
            html2canvas(element, {
                scale: 4,
                useCORS: true,
                backgroundColor: null,
                width: 323, // Correspond à 85.6mm
                height: 204  // Correspond à 54mm
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `badge-${lastName}-style${index}.png`;
                link.href = canvas.toDataURL("image/png", 1.0);
                link.click();
            });
        }
    </script>
</body>
</html>