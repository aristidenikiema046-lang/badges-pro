<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Badge - {{ $company->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-4 md:p-8 font-sans">

    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-emerald-600 p-8 text-center relative">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-20 mx-auto mb-4 bg-white p-2 rounded-lg shadow-sm">
            @endif
            <h1 class="text-white text-2xl font-black uppercase tracking-widest">Demande de Badge Pro</h1>
            <p class="text-emerald-100 font-medium">Entreprise : {{ $company->name }}</p>
            <div class="absolute bottom-0 right-0 w-24 h-2 bg-orange-500"></div>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                    <p class="font-bold">Oups ! Veuillez corriger les erreurs suivantes :</p>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nom *</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Prénom *</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Fonction / Poste *</label>
                    <input type="text" name="function" value="{{ old('function') }}" required placeholder="Ex: Développeur" class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Département</label>
                    <input type="text" name="department" value="{{ old('department') }}" placeholder="Ex: IT, RH, Logistique" class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Couleur personnalisée du badge</label>
                <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-xl border border-gray-200">
                    <input type="color" name="badge_color" value="#059669" class="h-10 w-20 cursor-pointer rounded border-0">
                    <span class="text-xs text-gray-500">Cette couleur sera utilisée pour les éléments graphiques du style choisi.</span>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-bold text-gray-700">Choisissez le design de votre badge *</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @for ($i = 1; $i <= 6; $i++)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="badge_style" value="style_{{ $i }}" {{ $i == 1 ? 'checked' : '' }} class="peer sr-only">
                            <div class="border-2 border-gray-200 rounded-xl p-2 peer-checked:border-emerald-600 peer-checked:bg-emerald-50 transition-all hover:border-emerald-300">
                                <div class="h-20 bg-gray-100 rounded-lg mb-2 flex items-center justify-center overflow-hidden border border-gray-50">
                                    <div class="text-center">
                                        <div class="w-8 h-1 bg-emerald-500 mx-auto mb-1 rounded-full opacity-40"></div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Style {{ $i }}</span>
                                    </div>
                                </div>
                                <p class="text-center text-[10px] font-bold uppercase text-gray-600 peer-checked:text-emerald-700">Modèle {{ $i }}</p>
                            </div>
                            <div class="absolute top-2 right-2 hidden peer-checked:block text-emerald-600">
                                <svg class="w-5 h-5 shadow-sm bg-white rounded-full" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293l-4 4a1 1 0 01-1.414 0l-2-2a1 1 0 111.414-1.414L9 10.586l3.293-3.293a1 1 0 111.414 1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </label>
                    @endfor
                </div>
            </div>

            <div class="bg-orange-50 p-6 rounded-2xl border-2 border-dashed border-orange-200">
                <label class="block text-sm font-bold text-orange-800 mb-2">Photo d'identité (Fond blanc recommandé) *</label>
                <input type="file" name="photo" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-orange-500 file:text-white hover:file:bg-orange-600 cursor-pointer">
            </div>

            <p class="text-xs text-gray-400 italic text-center">* Le numéro de badge, le QR Code et le Matricule sont générés automatiquement.</p>

            <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 rounded-xl hover:bg-emerald-700 shadow-xl transition-all uppercase tracking-widest text-lg transform hover:-translate-y-1 active:scale-95">
                Soumettre ma demande
            </button>
        </form>
    </div>

</body>
</html>