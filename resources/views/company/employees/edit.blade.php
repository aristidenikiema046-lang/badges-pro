<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Employé - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-green-700 p-6 text-white shadow-lg mb-8">
        <div class="max-w-3xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold uppercase italic">Modifier Collaborateur</h1>
                <p class="text-green-100 text-[10px] tracking-widest uppercase">Fiche de {{ $employee->first_name }} {{ $employee->last_name }}</p>
            </div>
            <a href="{{ route('company.employees') }}" class="bg-white text-green-700 px-4 py-2 rounded font-black text-xs hover:bg-gray-100 transition uppercase">Retour</a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto p-4">
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 p-4 text-red-700 shadow-sm rounded-r-lg">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 mb-2">Prénom</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 mb-2">Nom</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 mb-2">Poste / Fonction</label>
                            <input type="text" name="function" value="{{ old('function', $employee->function) }}" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 mb-2">Service / Département</label>
                            <input type="text" name="department" value="{{ old('department', $employee->department) }}" class="w-full border-2 border-gray-100 p-3 rounded-xl focus:border-orange-500 outline-none transition font-medium">
                        </div>
                    </div>

                    {{-- Gestion de la Photo --}}
                    <div class="bg-orange-50 p-6 rounded-2xl border-2 border-dashed border-orange-200">
                        <label class="block text-xs font-black uppercase text-orange-700 mb-4">Photo d'identité</label>
                        <div class="flex items-center gap-6">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" class="w-24 h-24 rounded-xl object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-xl flex items-center justify-center text-[10px] text-gray-400 text-center p-2 uppercase font-bold">Pas de photo</div>
                            @endif
                            <div class="flex-grow">
                                <input type="file" name="photo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-orange-600 file:text-white hover:file:bg-orange-700 cursor-pointer">
                                <p class="text-[10px] text-orange-400 mt-2 italic font-medium">Laissez vide pour garder la photo actuelle.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="flex-grow bg-orange-600 text-white font-black py-4 rounded-xl shadow-lg hover:bg-orange-700 transition uppercase tracking-widest">
                            Mettre à jour la fiche
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>