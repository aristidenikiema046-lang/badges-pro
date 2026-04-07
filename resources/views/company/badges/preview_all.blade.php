<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélecteur de Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <style>
        /* CONFIGURATION IMPRESSION VERTICALE CR80 */
        @media print {
            @page { 
                size: 54mm 85.6mm; 
                margin: 0; 
            }
            body { background: white; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            
            .badge-selected { 
                width: 54mm !important; 
                height: 85.6mm !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden;
            }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }

        /* STYLE DES CARTES DE PRÉVISUALISATION (PORTRAIT) */
        .badge-card {
            width: 54mm;
            height: 85.6mm;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            background: white;
            border-radius: 1rem;
        }

        .badge-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        /* Scrollbar pour la grille si nécessaire */
        .grid-container {
            perspective: 1000px;
        }
    </style>
</head>
<body class="bg-slate-50 p-4 md:p-8">

    <div class="max-w-7xl mx-auto no-print">
        <header class="mb-12 text-center">
            <h1 class="text-4xl font-black text-slate-800 tracking-tight italic uppercase">Générateur de Badges</h1>
            <p class="text-slate-500 mt-2 text-lg">
                Employé : <span class="font-bold text-slate-900">{{ $employee->first_name }} {{ $employee->last_name }}</span>
            </p>
            
            <div class="flex justify-center gap-4 mt-8">
                <a href="{{ url('/company/dashboard') }}" class="bg-white text-slate-600 px-6 py-3 rounded-2xl font-bold shadow-sm hover:bg-slate-50 transition border">
                    ← Retour Dashboard
                </a>
                <button onclick="window.print()" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition flex items-center gap-2">
                    🖨️ Imprimer tous les modèles
                </button>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 justify-items-center grid-container">
            @foreach(range(1, 3) as $styleIndex)
                <div class="flex flex-col items-center w-full">
                    <div class="flex justify-between w-[54mm] mb-4 px-2">
                        <span class="font-black text-slate-400 uppercase text-xs tracking-[0.2em]">Style #0{{ $styleIndex }}</span>
                    </div>
                    
                    <div id="badge-capture-{{ $styleIndex }}" 
                         class="badge-card shadow-xl overflow-hidden"
                         onclick="printThisStyle({{ $styleIndex }})">
                        @include('company.badges.styles.style_' . $styleIndex, ['employee' => $employee])
                    </div>

                    <div class="mt-6 flex flex-col gap-3 w-[54mm]">
                        <button onclick="printThisStyle({{ $styleIndex }})" 
                                class="w-full bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl font-bold text-sm shadow-md transition">
                            Imprimer ce style
                        </button>
                        
                        <div class="flex w-full bg-white rounded-xl shadow-sm border overflow-hidden">
                            <a href="{{ route('badge.export.single', ['id' => $employee->id, 'style' => $styleIndex, 'format' => 'pdf']) }}" 
                               class="flex-1 px-4 py-2 hover:bg-slate-50 border-r text-center text-sm font-bold text-slate-600 transition">
                                PDF
                            </a>
                            <button onclick="downloadPNG({{ $styleIndex }}, '{{ addslashes($employee->last_name) }}')" 
                                    class="flex-1 px-4 py-2 hover:bg-slate-50 text-center text-sm font-bold text-slate-600 transition">
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
            // On récupère le contenu HTML du badge spécifique
            const badgeContent = document.querySelector('#badge-capture-' + index).innerHTML;
            printZone.innerHTML = `<div class="badge-selected">${badgeContent}</div>`;
            window.print();
        }

        function downloadPNG(index, lastName) {
            // Ciblage du conteneur fixe défini dans les fichiers styles
            const element = document.querySelector('#badge-capture-' + index + ' .badge-fixed-container');
            
            if(!element) {
                alert("Erreur: Contenu du badge introuvable.");
                return;
            }

            html2canvas(element, {
                scale: 4, // Haute résolution
                useCORS: true,
                backgroundColor: null,
                // Dimensions en pixels pour du 54mm x 85.6mm (environ)
                width: 204, 
                height: 323
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