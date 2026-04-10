<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Employé - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        
        <div class="bg-green-700 p-6 sm:p-8 text-center">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="h-14 sm:h-16 mx-auto mb-4 bg-white p-2 rounded-lg shadow-sm">
            @endif
            <h2 class="text-white text-lg sm:text-xl font-black uppercase italic tracking-tight">Demande de Badge</h2>
            <p class="text-green-100 text-[10px] uppercase tracking-widest mt-1">{{ $company->name }}</p>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-4">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded-xl text-xs">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Prénom</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required 
                           class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Nom</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required 
                           class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition text-sm">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Email Professionnel</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Poste occupé</label>
                    <input type="text" name="function" value="{{ old('function') }}" required placeholder="Ex: Analyste"
                           class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Matricule Interne</label>
                    <input type="text" name="matricule" value="{{ old('matricule') }}" required 
                           class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition text-sm font-mono uppercase">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Photo d'identité (JPG, PNG)</label>
                <input type="file" name="photo" required 
                       class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-orange-600 file:text-white hover:file:bg-orange-700 cursor-pointer">
            </div>

            <button type="submit" class="w-full bg-orange-600 text-white font-black py-4 rounded-2xl shadow-lg hover:bg-orange-700 hover:scale-[1.01] transition-all uppercase tracking-widest text-sm mt-4">
                Générer mon badge
            </button>
        </form>

        <p class="text-center pb-6 text-[9px] text-gray-300 uppercase font-bold tracking-tighter">
            Système de gestion des badges - {{ date('Y') }}
        </p>
    </div>
</body>
</html>