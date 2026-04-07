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
            <a href="{{ route('companies.index') }}" class="text-orange-600 font-bold hover:underline">← Retour à la liste</a>
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

        {{-- FORMULAIRE DE MODIFICATION --}}
        <div class="bg-white rounded-xl shadow-xl border-t-8 border-blue-500 p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-tight">Modifier : {{ $company->name }}</h2>
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" class="w-16 h-16 rounded-full object-cover border-2 border-gray-100 shadow-sm">
                @endif
            </div>
            
            <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nom de l'entreprise *</label>
                        <input type="text" name="name" value="{{ old('name', $company->name) }}" required class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email Professionnel *</label>
                        <input type="email" name="email" value="{{ old('email', $company->email) }}" required class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Responsable</label>
                        <input type="text" name="manager_name" value="{{ old('manager_name', $company->manager_name) }}" class="w-full border-gray-300 rounded-lg p-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="w-full border-gray-300 rounded-lg p-2.5">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Changer le Logo (laisser vide pour conserver l'actuel)</label>
                    <input type="file" name="logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" class="flex-grow bg-blue-600 text-white font-black py-4 rounded-lg hover:bg-blue-700 shadow-md transition-all uppercase tracking-widest text-lg">
                        Mettre à jour les informations
                    </button>
                    <a href="{{ route('companies.index') }}" class="bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-lg hover:bg-gray-300 transition shadow-sm uppercase text-sm flex items-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>