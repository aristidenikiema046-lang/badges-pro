<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Entreprise - {{ $company->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-6 font-sans">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('companies.index') }}" class="text-indigo-600 font-bold hover:underline flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Retour à la liste
            </a>
        </div>

        {{-- Affichage des erreurs de validation --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 p-4 text-red-700 shadow-sm rounded-r-lg">
                <p class="font-bold uppercase text-xs mb-2">Erreurs détectées :</p>
                <ul class="list-disc ml-5 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-xl border-t-8 border-indigo-500 p-8">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Modifier l'entreprise</h2>
                    <p class="text-gray-500 text-sm italic">Mise à jour des paramètres et de l'identité visuelle</p>
                </div>
                
                @if($company->logo)
                    <div class="text-right">
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="w-16 h-16 rounded-lg object-contain border bg-gray-50 p-1 shadow-sm">
                        <p class="text-[10px] text-gray-400 mt-1 font-bold uppercase tracking-widest text-center">Logo Actuel</p>
                    </div>
                @endif
            </div>
            
            <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nom --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 italic">Nom de l'entreprise *</label>
                        <input type="text" name="name" value="{{ old('name', $company->name) }}" required class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 outline-none border transition-all">
                    </div>
                    
                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 italic">Email Professionnel *</label>
                        <input type="email" name="email" value="{{ old('email', $company->email) }}" required class="w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 outline-none border transition-all">
                    </div>

                    {{-- Manager --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 italic">Responsable / Gérant</label>
                        <input type="text" name="manager_name" value="{{ old('manager_name', $company->manager_name) }}" class="w-full border-gray-300 rounded-lg p-3 outline-none border focus:border-indigo-400 transition-all">
                    </div>

                    {{-- Téléphone --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 italic">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="w-full border-gray-300 rounded-lg p-3 outline-none border focus:border-indigo-400 transition-all">
                    </div>
                </div>

                {{-- Logo --}}
                <div class="bg-indigo-50/50 p-4 rounded-lg border border-indigo-100">
                    <label class="block text-sm font-bold text-indigo-900 mb-2">Changer le Logo</label>
                    <input type="file" name="logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                    <p class="text-[11px] text-indigo-400 mt-2">Format suggéré : PNG ou JPG (Max 2MB). Laissez vide pour conserver le logo actuel.</p>
                </div>

                {{-- SECTION DESIGN DES BADGES --}}
                <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-indigo-200 mt-8">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="p-1.5 bg-indigo-100 rounded text-indigo-600 italic">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <h3 class="text-indigo-600 font-black uppercase text-sm tracking-widest">Identité Visuelle des Badges</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Style --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Modèle de Badge par défaut</label>
                            <select name="badge_style" required class="w-full border-gray-300 rounded-lg p-3 focus:ring-indigo-500 outline-none border bg-white shadow-sm">
                                @foreach([
                                    'style_1' => 'Style 1 - Classique Vertical',
                                    'style_2' => 'Style 2 - Moderne & Épuré',
                                    'style_3' => 'Style 3 - Minimaliste',
                                    'style_4' => 'Style 4 - Portrait Pro',
                                    'style_5' => 'Style 5 - Corporate Dark',
                                    'style_6' => 'Style 6 - Format Horizontal'
                                ] as $value => $label)
                                    <option value="{{ $value }}" {{ old('badge_style', $company->badge_style) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Couleur --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Couleur Thématique</label>
                            <div class="flex items-center gap-4">
                                <input type="color" name="badge_color" value="{{ old('badge_color', $company->badge_color) }}" required class="h-12 w-24 p-1 rounded-lg border-gray-300 cursor-pointer shadow-sm bg-white">
                                <div class="leading-tight text-[11px] text-gray-500">
                                    <p class="font-bold text-indigo-600 uppercase mb-1">Aperçu direct</p>
                                    <p class="italic">Cette couleur sera utilisée pour les bordures et les titres des badges employés.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Boutons d'action --}}
                <div class="flex flex-col md:flex-row gap-4 pt-4">
                    <button type="submit" class="flex-grow bg-indigo-600 text-white font-black py-4 rounded-lg hover:bg-indigo-700 shadow-lg transition-all uppercase tracking-widest text-sm flex items-center justify-center gap-2">
                        Sauvegarder les modifications
                    </button>
                    <a href="{{ route('companies.index') }}" class="bg-white text-gray-500 border border-gray-200 font-bold py-4 px-8 rounded-lg hover:bg-gray-50 transition uppercase text-sm text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
        
        <p class="text-center text-gray-400 text-xs mt-8 uppercase tracking-widest font-medium">Système de gestion de badges - YA Consulting</p>
    </div>
</body>
</html>