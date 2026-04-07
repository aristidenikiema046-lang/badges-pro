@php 
    $mainColor = $employee->badge_color ?? '#1e293b'; 
    $is_export = isset($isPdf) && $isPdf;
    
    $getPath = function($path) use ($is_export) {
        if (!$path) return null;
        // Correction domPDF : chemin physique absolu
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="relative bg-white flex flex-col font-sans" 
     style="width: 85.6mm; height: 54mm; border: 4mm solid {{ $mainColor }}; box-sizing: border-box; overflow: hidden; margin: 0; padding: 0;">
    
    <div style="height: 12mm; width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 0 4mm; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" style="height: 7mm; width: auto; object-fit: contain;">
        @endif
        <p style="font-size: 7pt; font-weight: 900; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">
            Badge Professionnel
        </p>
    </div>

    <div style="flex: 1; display: flex; padding: 4mm; gap: 4mm; align-items: center;">
        <div style="width: 28mm; height: 35mm; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 1mm; overflow: hidden;">
            <img src="{{ $getPath($employee->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        
        <div style="flex: 1;">
            <h1 style="font-size: 16pt; font-weight: 900; color: #111827; text-transform: uppercase; line-height: 1; margin: 0;">
                {{ $employee->last_name }}
            </h1>
            <h2 style="font-size: 12pt; font-weight: 500; color: #4b5563; text-transform: uppercase; margin: 0;">
                {{ $employee->first_name }}
            </h2>
            
            <div style="margin-top: 2mm;">
                <p style="font-size: 6pt; font-weight: 700; color: #9ca3af; text-transform: uppercase; margin: 0;">Fonction</p>
                <p style="font-size: 10pt; font-weight: 700; text-transform: uppercase; color: {{ $mainColor }}; margin: 0;">
                    {{ $employee->function }}
                </p>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="{{ $getPath($employee->qr_code) }}" style="width: 15mm; height: 15mm; border: 1px solid #e5e7eb; padding: 1mm;">
            <span style="font-size: 6pt; font-family: monospace; font-weight: 700; margin-top: 1mm;">
                {{ $employee->badge_number }}
            </span>
        </div>
    </div>
</div>