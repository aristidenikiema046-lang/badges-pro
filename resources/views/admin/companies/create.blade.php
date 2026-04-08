<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration Entreprise - YA Consulting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-6 font-sans">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-orange-600 font-bold hover:underline">← Retour à l'accueil</a>
            <a href="{{ route('companies.index') }}" class="text-emerald-600 font-bold hover:underline">Gérer les entreprises →</a>
        </div>

        {{-- BLOC ERREURS --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 p-4 text-red-700 shadow-sm">
                <p class="font-bold">Oups ! Il y a des erreurs :</p>
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- BLOC SUCCÈS ET LIEN GÉNÉRÉ --}}
        @if(session('generated_slug'))
            <div class="mb-8 bg-emerald-50 border-2 border-emerald-500 p-6 rounded-xl shadow-lg border-dashed">
                <div class="flex items-center mb-3">
                    <span class="text-2xl mr-2">🎉</span>
                    <h3 class="text-emerald-800 font-bold text-lg uppercase">Lien généré pour {{ session('company_name') }}</h3>
                </div>
                <p class="text-sm text-emerald-700 mb-4 font-medium italic">Partagez ce lien avec les employés pour qu'ils créent leurs badges :</p>
                
                <div class="flex items-center gap-2 bg-white p-4 rounded-lg border border-emerald-200 shadow-inner">
                    <code id="company-link" class="text-emerald-600 font-mono font-bold flex-grow text-sm md:text-base break-all">
                        {{ url('/register/' . session('generated_slug')) }}
                    </code>
                    <button onclick="copyToClipboard()" class="bg-emerald-600 text-white px-5 py-2 rounded-lg hover:bg-emerald-700 transition font-bold uppercase text-xs shrink-0">
                        Copier
                    </button>
                </div>
                <p id="copy-status" class="text-xs text-emerald-600 mt-2 font-bold hidden italic text-center">Lien copié dans le presse-papier !</p>
            </div>
        @endif

        {{-- FORMULAIRE --}}
        <div class="bg-white rounded-xl shadow-xl border-t-8 border-orange-500 p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 uppercase tracking-tight">Configuration de l'Entreprise</h2>
            
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                {{-- Informations de base --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nom de l'entreprise *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ex: AgroNova SA" class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email Professionnel *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="contact@entreprise.com" class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Responsable</label>
                        <input type="text" name="manager_name" value="{{ old('manager_name') }}" placeholder="Nom du gérant" class="w-full border-gray-300 rounded-lg p-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+225..." class="w-full border-gray-300 rounded-lg p-2.5">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Logo de l'entreprise</label>
                    <input type="file" name="logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                </div>

                {{-- SECTION DESIGN --}}
                <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-orange-200 mt-6">
                    <h3 class="text-orange-600 font-bold uppercase text-sm mb-4 tracking-wider">Identité Visuelle des Badges</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Sélection du Style --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Modèle de Badge</label>
                            <select name="badge_style" class="w-full border-gray-300 rounded-lg p-3 focus:ring-orange-500">
                                <option value="1" {{ old('badge_style') == '1' ? 'selected' : '' }}>Style 1 - Classique Vertical</option>
                                <option value="2" {{ old('badge_style') == '2' ? 'selected' : '' }}>Style 2 - Moderne</option>
                                <option value="3" {{ old('badge_style') == '3' ? 'selected' : '' }}>Style 3 - Épuré</option>
                                <option value="4" {{ old('badge_style') == '4' ? 'selected' : '' }}>Style 4 - Portrait Pro</option>
                                <option value="5" {{ old('badge_style') == '5' ? 'selected' : '' }}>Style 5 - Corporate</option>
                                <option value="6" {{ old('badge_style') == '6' ? 'selected' : '' }}>Style 6 - Horizontal (Paysage)</option>
                            </select>
                        </div>

                        {{-- Sélection de la Couleur --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Couleur de l'entreprise</label>
                            <div class="flex items-center gap-4">
                                <input type="color" name="badge_color" value="{{ old('badge_color', '#f97316') }}" class="h-12 w-20 p-1 rounded-lg border-gray-300 cursor-pointer">
                                <span class="text-[11px] text-gray-500 italic leading-tight">Cette couleur sera appliquée aux titres et bordures des badges.</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-orange-500 text-white font-black py-4 rounded-lg hover:bg-orange-600 shadow-md transition-all uppercase tracking-widest text-lg">
                    Enregistrer et générer le lien
                </button>
            </form>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const text = document.getElementById('company-link').innerText;
            navigator.clipboard.writeText(text).then(() => {
                const status = document.getElementById('copy-status');
                status.classList.remove('hidden');
                setTimeout(() => status.classList.add('hidden'), 3000);
            }).catch(err => {
                console.error('Erreur lors de la copie : ', err);
            });
        }
    </script>
</body>
</html>