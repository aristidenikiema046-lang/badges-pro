<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Entreprise - {{ $company->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-4 md:p-6 font-sans">
    
    <div class="max-w-3xl mx-auto w-full">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('companies.index') }}" class="text-blue-600 font-bold hover:underline">← Retour à la liste</a>
        </div>

        {{-- BLOC ERREURS --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 p-4 text-red-700 shadow-sm rounded-r-lg">
                <p class="font-bold uppercase text-xs mb-1">Erreurs de validation :</p>
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULAIRE DE MODIFICATION --}}
        <div class="bg-white rounded-xl shadow-xl border-t-8 border-blue-500 p-6 md:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 uppercase tracking-tight">Modifier l'entreprise</h2>
                    <p class="text-gray-500 text-sm italic">{{ $company->name }}</p>
                </div>
                @if($company->logo)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $company->logo) }}" class="w-16 h-16 md:w-20 md:h-20 rounded-lg object-contain border-2 border-gray-100 shadow-sm bg-gray-50 mx-auto">
                        <span class="text-[10px] text-gray-400 font-bold uppercase block mt-1">Logo actuel</span>
                    </div>
                @endif
            </div>
            
            <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Informations générales --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nom de l'entreprise *</label>
                        <input type="text" name="name" value="{{ old('name', $company->name) }}" required class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none border transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email Professionnel *</label>
                        <input type="email" name="email" value="{{ old('email', $company->email) }}" required class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none border transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Responsable</label>
                        <input type="text" name="manager_name" value="{{ old('manager_name', $company->manager_name) }}" class="w-full border-gray-300 rounded-lg p-2.5 outline-none border focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="w-full border-gray-300 rounded-lg p-2.5 outline-none border focus:border-blue-400">
                    </div>
                </div>

                {{-- Upload Logo --}}
                <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
                    <label class="block text-sm font-bold text-blue-900 mb-1">Changer le Logo</label>
                    <input type="file" name="logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                    <p class="text-[11px] text-blue-400 mt-2 font-medium italic">Laissez vide pour conserver le logo actuel.</p>
                </div>

                {{-- SECTION DESIGN --}}
                <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-blue-200">
                    <h3 class="text-blue-600 font-bold uppercase text-sm mb-4 tracking-wider">Identité Visuelle des Badges</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Modèle de Badge *</label>
                            <select name="badge_style" required class="w-full border-gray-300 rounded-lg p-3 focus:ring-blue-500 outline-none border bg-white">
                                @foreach([
                                    'style_1' => 'Style 1 - Classique Vertical',
                                    'style_2' => 'Style 2 - Moderne',
                                    'style_3' => 'Style 3 - Épuré',
                                    'style_4' => 'Style 4 - Portrait Pro',
                                    'style_5' => 'Style 5 - Corporate Dark',
                                    'style_6' => 'Style 6 - Horizontal'
                                ] as $value => $label)
                                    <option value="{{ $value }}" {{ old('badge_style', $company->badge_style) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Couleur Thématique *</label>
                            <div class="flex items-center gap-4">
                                <input type="color" name="badge_color" value="{{ old('badge_color', $company->badge_color ?? '#3b82f6') }}" required class="h-12 w-20 p-1 rounded-lg border-gray-300 cursor-pointer shadow-sm bg-white">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="w-full sm:flex-grow bg-blue-600 text-white font-black py-4 rounded-lg hover:bg-blue-700 shadow-lg transition-all uppercase tracking-widest text-lg">
                        Enregistrer
                    </button>
                    <a href="{{ route('companies.index') }}" class="w-full sm:w-auto bg-gray-200 text-gray-700 font-bold py-4 px-8 rounded-lg hover:bg-gray-300 transition shadow-sm uppercase text-sm flex items-center justify-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>