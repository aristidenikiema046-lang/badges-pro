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
        <!-- Header dynamique -->
        <div class="p-8 text-center relative" style="background-color: {{ $company->badge_color ?? '#059669' }}">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-20 mx-auto mb-4 bg-white p-2 rounded-lg shadow-sm">
            @endif
            <h1 class="text-white text-2xl font-black uppercase tracking-widest">Demande de Badge Pro</h1>
            <p class="text-white opacity-90 font-medium italic">{{ $company->name }}</p>
        </div>

        <!-- Correction de l'action ici -->
        <form action="{{ route('employee.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            {{-- Affichage des erreurs --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                    <p class="font-bold">Attention :</p>
                    <ul class="list-disc ml-5 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nom *</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 border" style="--tw-ring-color: {{ $company->badge_color }}">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Prénom *</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 border" style="--tw-ring-color: {{ $company->badge_color }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email Professionnel *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 border" style="--tw-ring-color: {{ $company->badge_color }}">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Matricule Interne *</label>
                    <input type="text" name="matricule" value="{{ old('matricule') }}" required class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 border" style="--tw-ring-color: {{ $company->badge_color }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Fonction / Poste *</label>
                <input type="text" name="function" value="{{ old('function') }}" required class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 border" style="--tw-ring-color: {{ $company->badge_color }}">
            </div>

            <div class="bg-blue-50 p-4 rounded-xl flex items-start gap-3 border border-blue-100">
                <p class="text-xs text-blue-800">
                    ℹ️ Votre badge sera généré selon le modèle <strong>{{ strtoupper(str_replace('_', ' ', $company->badge_style)) }}</strong>.
                </p>
            </div>

            <button type="submit" class="w-full text-white font-black py-4 rounded-xl shadow-xl transition-all uppercase tracking-widest text-lg transform hover:-translate-y-1 active:scale-95" style="background-color: {{ $company->badge_color ?? '#059669' }}">
                Générer mon badge
            </button>
        </form>
    </div>
</body>
</html>