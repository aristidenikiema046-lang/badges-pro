<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration de l'Entreprise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #style-render-container {
            transform: scale(0.65); 
            transform-origin: center top;
            width: 100%;
            min-width: 450px; 
            display: flex;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .preview-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px 0;
        }

        .preview-wrapper::-webkit-scrollbar { height: 4px; }
        .preview-wrapper::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-8 font-sans">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('home') }}" class="text-orange-600 font-bold hover:underline">← Accueil</a>
            <a href="{{ route('companies.index') }}" class="text-teal-700 font-bold hover:underline">Gérer les entreprises →</a>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-t-8 border-orange-500">
            <div class="p-6 md:p-10">
                <h2 class="text-2xl font-black text-slate-800 uppercase mb-2">Configuration de l'Entreprise</h2>
                <p class="text-slate-500 mb-8">Définissez le style des badges pour vos employés. Une fois validé, vous obtiendrez votre lien de partage dans votre tableau de bord.</p>

                <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nom de l'entreprise *</label>
                            <input type="text" name="name" required placeholder="Ex: YA Consulting" class="w-full border-gray-200 rounded-xl p-3 bg-gray-50 outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Professionnel *</label>
                            <input type="email" name="email" required placeholder="contact@entreprise.com" class="w-full border-gray-200 rounded-xl p-3 bg-gray-50 outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-dashed border-slate-300">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Logo de l'entreprise</label>
                        <input type="file" name="logo" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-orange-100 file:text-orange-700">
                    </div>

                    <div class="border-2 border-orange-100 rounded-2xl p-6 bg-orange-50/30">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                            <div class="lg:col-span-5 space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Modèle de Badge *</label>
                                    <select name="badge_style" id="badge_style" required class="w-full border-gray-200 rounded-xl p-3 bg-white shadow-sm focus:ring-2 focus:ring-orange-500">
                                        <option value="style_1">Style 1 - Classique Vertical</option>
                                        <option value="style_2">Style 2 - Moderne Géométrique</option>
                                        <option value="style_3">Style 3 - Épuré Minimaliste</option>
                                        <option value="style_4">Style 4 - Portrait Focus</option>
                                        <option value="style_5">Style 5 - Corporate Dark</option>
                                        <option value="style_6">Style 6 - Horizontal Pro</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Couleur thématique *</label>
                                    <input type="color" name="badge_color" id="badge_color" value="#f97316" class="h-14 w-full p-1 rounded-lg border-2 border-white shadow-md cursor-pointer">
                                </div>
                            </div>

                            <div class="lg:col-span-7 flex flex-col items-center justify-start bg-white p-4 rounded-xl border border-orange-100 shadow-inner min-h-[450px]">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-4 italic tracking-widest">Aperçu en temps réel</span>
                                <div id="preview-loader" class="hidden animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500 mb-4"></div>
                                <div class="preview-wrapper">
                                    <div id="style-render-container" class="transition-all duration-300">
                                        <p class="text-slate-300 mt-20">Chargement de l'aperçu...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-xl shadow-lg transition-all uppercase tracking-widest text-lg">
                        Finaliser et accéder au Dashboard
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const styleSelect = document.getElementById('badge_style');
        const colorInput = document.getElementById('badge_color');
        const renderContainer = document.getElementById('style-render-container');
        const loader = document.getElementById('preview-loader');

        function updateLivePreview() {
            const style = styleSelect.value;
            const color = encodeURIComponent(colorInput.value);
            
            // On affiche le loader
            loader.classList.remove('hidden');
            renderContainer.style.opacity = '0.3';

            // URL mise à jour vers la route publique /preview-style/
            fetch(`/preview-style/${style}?color=${color}`)
                .then(response => {
                    if (!response.ok) throw new Error('Erreur de chargement');
                    return response.text();
                })
                .then(html => {
                    renderContainer.innerHTML = html;
                    renderContainer.style.opacity = '1';
                    loader.classList.add('hidden');
                })
                .catch(err => {
                    console.error(err);
                    renderContainer.innerHTML = "<p class='text-red-400 mt-20 text-xs text-center font-bold'>Style non disponible ou erreur serveur</p>";
                    loader.classList.add('hidden');
                });
        }

        // Écouteurs pour mettre à jour lors d'un changement
        styleSelect.addEventListener('change', updateLivePreview);
        colorInput.addEventListener('input', updateLivePreview);
        
        // Chargement initial au lancement de la page
        document.addEventListener('DOMContentLoaded', updateLivePreview);
    </script>
</body>
</html>