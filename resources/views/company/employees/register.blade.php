<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Employé - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="bg-green-700 p-8 text-center">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="h-16 mx-auto mb-4 bg-white p-2 rounded-lg">
            @endif
            <h2 class="text-white text-xl font-black uppercase italic">Demande de Badge</h2>
            <p class="text-green-100 text-xs uppercase tracking-widest mt-1">{{ $company->name }}</p>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-4">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg text-sm font-bold text-center mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Prénom</label>
                    <input type="text" name="first_name" required class="w-full border-2 border-gray-50 p-2 rounded-xl focus:border-orange-500 outline-none transition text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Nom</label>
                    <input type="text" name="last_name" required class="w-full border-2 border-gray-50 p-2 rounded-xl focus:border-orange-500 outline-none transition text-sm">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Email</label>
                <input type="email" name="email" required class="w-full border-2 border-gray-50 p-2 rounded-xl focus:border-orange-500 outline-none transition text-sm">
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Matricule</label>
                <input type="text" name="matricule" required class="w-full border-2 border-gray-50 p-2 rounded-xl focus:border-orange-500 outline-none transition text-sm">
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Photo d'identité</label>
                <input type="file" name="photo" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-orange-600 file:text-white hover:file:bg-orange-700 cursor-pointer">
            </div>

            <button type="submit" class="w-full bg-orange-600 text-white font-black py-4 rounded-2xl shadow-lg hover:bg-orange-700 transition uppercase tracking-widest text-sm mt-4">
                Envoyer ma demande
            </button>
        </form>
    </div>
</body>
</html>