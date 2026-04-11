<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protocol Access - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .grid-bg {
            background-image: radial-gradient(circle, {{ $company->badge_color }} 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .border-glow { border: 1px solid rgba(255, 255, 255, 0.1); }
        .input-tech { 
            background: rgba(0, 0, 0, 0.6); 
            border: 1px solid #333;
        }
    </style>
</head>
<body class="bg-black min-h-screen flex items-center justify-center p-6 grid-bg">

    <div class="w-full max-w-2xl bg-[#0d0d0d] border border-slate-800 rounded-sm shadow-[0_0_80px_-20px_rgba(0,0,0,0.5)] overflow-hidden">
        
        <div class="border-b border-slate-800 p-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" class="h-12 w-12 object-contain bg-white p-1 rounded-sm">
                @endif
                <div>
                    <h1 class="text-white text-sm font-bold tracking-[0.3em] uppercase">{{ $company->name }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-2 h-2 rounded-full animate-pulse" style="background-color: {{ $company->badge_color }}"></div>
                        <span class="text-[9px] text-slate-500 font-mono tracking-widest uppercase">ID_SYSTEM_ONLINE</span>
                    </div>
                </div>
            </div>
            <div class="text-[10px] text-slate-700 font-mono uppercase text-right">
                Auth: {{ date('H:i:s') }}<br>Secure Channel
            </div>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if ($errors->any())
                <div class="bg-red-950/30 border border-red-900 p-4 text-red-500 text-[10px] font-mono uppercase">
                    @foreach ($errors->all() as $error) [ERROR] {{ $error }}<br> @endforeach
                </div>
            @endif

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-[9px] text-slate-500 font-mono uppercase ml-1">Last Name</label>
                    <input type="text" name="last_name" required class="w-full input-tech p-3 mt-1 text-white text-sm focus:border-[{{ $company->badge_color }}] outline-none">
                </div>
                <div>
                    <label class="text-[9px] text-slate-500 font-mono uppercase ml-1">First Name</label>
                    <input type="text" name="first_name" required class="w-full input-tech p-3 mt-1 text-white text-sm focus:border-[{{ $company->badge_color }}] outline-none">
                </div>
            </div>

            <div>
                <label class="text-[9px] text-slate-500 font-mono uppercase ml-1">Corporate Email</label>
                <input type="email" name="email" required class="w-full input-tech p-3 mt-1 text-white text-sm focus:border-[{{ $company->badge_color }}] outline-none">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-[9px] text-slate-500 font-mono uppercase ml-1">Function</label>
                    <input type="text" name="function" required class="w-full input-tech p-3 mt-1 text-white text-sm focus:border-[{{ $company->badge_color }}] outline-none">
                </div>
                <div>
                    <label class="text-[9px] text-slate-500 font-mono uppercase ml-1">Serial ID</label>
                    <input type="text" name="matricule" required class="w-full input-tech p-3 mt-1 text-white text-sm font-mono focus:border-[{{ $company->badge_color }}] outline-none">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-900">
                <label class="text-[9px] text-slate-500 font-mono uppercase ml-1 mb-2 block">Upload Identity Assets</label>
                <input type="file" name="photo" required class="w-full text-slate-400 text-[10px] file:bg-slate-800 file:text-white file:border-0 file:px-4 file:py-2 file:cursor-pointer hover:file:bg-slate-700">
            </div>

            <button type="submit" class="w-full border py-4 text-xs font-black uppercase tracking-[0.2em] transition-all hover:text-black" 
                    style="border-color: {{ $company->badge_color }}; color: {{ $company->badge_color }}; hover:background-color: {{ $company->badge_color }}">
                Execute Registration
            </button>
        </form>

        <div class="bg-[#080808] p-4 text-center border-t border-slate-800">
            <span class="text-[8px] font-mono text-slate-600 uppercase tracking-widest">YaConsulting // Access Granted Mode</span>
        </div>
    </div>
</body>
</html>