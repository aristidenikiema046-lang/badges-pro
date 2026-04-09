@php 
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#000000'); 
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Force les dimensions du badge pour la preview et l'impression */
        .badge-container {
            width: 600px;
            height: 350px;
            font-family: 'sans-serif';
        }
        .sidebar-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="badge-container bg-white shadow-2xl overflow-hidden flex relative border-2 mx-auto rounded-[1.5rem]" 
         style="border-color: {{ $mainColor }}">
        
        <div class="w-2/5 relative flex items-center justify-center" style="background-color: {{ $mainColor }}">
            <div class="absolute inset-0 opacity-20 sidebar-pattern"></div>

            <div class="z-10 relative">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" 
                         class="w-44 h-56 rounded-full object-cover shadow-2xl border-4 border-white">
                @else
                    <div class="w-44 h-56 rounded-full bg-white flex items-center justify-center text-gray-400 font-bold border-2 border-dashed border-gray-200">
                        SANS PHOTO
                    </div>
                @endif
            </div>
            
            <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full opacity-30 bg-white"></div>
        </div>

        <div class="w-3/5 flex flex-col p-8 justify-between bg-white relative">
            
            <div class="flex items-center gap-4 justify-end border-b pb-4">
                <div class="text-right">
                    <p class="font-black text-2xl uppercase leading-none" style="color: {{ $mainColor }}">
                        {{ $employee->company->name ?? 'YA CONSULTING' }}
                    </p>
                    <p class="text-[10px] text-gray-400 font-bold tracking-[0.2em] mt-1">CARTE PROFESSIONNELLE</p>
                </div>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-14 w-14 object-contain">
                @endif
            </div>

            <div class="flex-grow flex flex-col justify-center py-4">
                <div class="mb-4">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Nom & Prénoms</p>
                    <p class="text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $employee->first_name }} <br> {{ $employee->last_name }}
                    </p>
                </div>
                
                <div class="flex gap-6">
                    <div>
                        <p class="text-gray-400 text-[9px] font-black uppercase">Fonction</p>
                        <p class="text-sm font-bold uppercase" style="color: {{ $mainColor }}">
                            {{ $employee->function ?? 'Collaborateur' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[9px] font-black uppercase">Matricule</p>
                        <p class="text-sm font-mono font-bold text-slate-700">{{ $employee->matricule }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-end">
                <div class="p-1 border-2 rounded-lg" style="border-color: {{ $mainColor }}">
                    {!! QrCode::size(70)->margin(0)->generate($employee->matricule ?? '0000') !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>