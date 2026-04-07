@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100">
    {{-- Header Vue Noire --}}
    <div class="bg-black text-white p-6 shadow-xl">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold uppercase tracking-widest text-orange-500">Super-Admin</h1>
                <p class="text-gray-400 text-xs italic">Plateforme YA CONSULTING</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('companies.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded font-bold text-sm transition shadow-lg">
                    + Nouvelle Entreprise
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white text-sm border border-gray-700 px-4 py-2 rounded hover:bg-gray-900">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500 text-white font-bold rounded shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4 font-bold uppercase text-[10px]">Logo</th>
                        <th class="p-4 font-bold uppercase text-[10px]">Entreprise</th>
                        <th class="p-4 font-bold uppercase text-[10px]">Manager / Email</th>
                        <th class="p-4 font-bold uppercase text-[10px]">Lien d'inscription</th>
                        <th class="p-4 font-bold uppercase text-[10px] text-center">Statut</th>
                        <th class="p-4 font-bold uppercase text-[10px] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($companies as $company)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            @if($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-[10px] text-gray-500 border border-dashed border-gray-400">N/A</div>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-gray-900">{{ $company->name }}</div>
                            <div class="text-gray-400 text-[9px] uppercase tracking-tighter">ID: #{{ $company->id }}</div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm text-gray-700 font-medium">{{ $company->manager_name }}</div>
                            <div class="text-xs text-gray-500">{{ $company->email }}</div>
                        </td>
                        <td class="p-4">
                            <span class="text-[10px] bg-gray-100 p-2 rounded border border-gray-200 text-orange-600 font-mono font-bold">
                                /register/{{ $company->slug }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            @if($company->is_active)
                                <span class="px-2 py-1 rounded-full text-[9px] font-black bg-green-100 text-green-700 border border-green-200 uppercase">Actif</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-[9px] font-black bg-red-100 text-red-700 border border-red-200 uppercase">Suspendu</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('companies.edit', $company->id) }}" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition shadow" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <form action="{{ route('companies.toggle', $company->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="bg-gray-800 text-white p-2 rounded hover:bg-black transition shadow" title="Activer/Désactiver">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-gray-400 italic font-medium">
                            Aucune entreprise enregistrée pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection