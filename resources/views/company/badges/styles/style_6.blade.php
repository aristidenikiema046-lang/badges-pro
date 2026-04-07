@php 
    // Utilisation des couleurs préférées si définies, sinon couleur par défaut
    $mainColor = $employee->badge_color ?? '#1e293b'; 
    
    // Fonction de conversion en Base64 pour garantir l'affichage dans domPDF
    $getPath = function($path) {
        if (!$path) return null;
        
        $fullPath = public_path('storage/' . $path);
        
        if (!file_exists($fullPath)) return null;

        $type = pathinfo($fullPath, PATHINFO_EXTENSION);
        $data = file_get_contents($fullPath);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    };

    $photoUrl = $getPath($employee->photo);
    $logoUrl = $getPath($employee->company->logo ?? null);
    $qrCodeUrl = $getPath($employee->qr_code);
@endphp

<div class="badge-container" 
     style="width: 85.6mm; height: 54mm; background-color: white; position: relative; font-family: sans-serif; overflow: hidden; box-sizing: border-box; border: 1px solid #e5e7eb;">
    
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 3mm; background-color: {{ $mainColor }};"></div>
    
    <div style="position: absolute; top: 5mm; left: 5mm; right: 5mm; height: 10mm; display: flex; align-items: center; justify-content: space-between;">
        @if($logoUrl)
            <img src="{{ $logoUrl }}" style="height: 8mm; width: auto; max-width: 25mm; object-fit: contain;">
        @else
            <div style="width: 10mm;"></div>
        @endif
        
        <p style="font-size: 8pt; font-weight: 900; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.15em; margin: 0;">
            Badge Professionnel
        </p>
    </div>

    <div style="position: absolute; top: 16mm; left: 5mm; right: 5mm; height: 0.5pt; background-color: #e5e7eb;"></div>

    <div style="position: absolute; top: 20mm; left: 5mm; width: 30mm; height: 30mm; border: 0.5pt solid #d1d5db; border-radius: 2mm; overflow: hidden; background-color: #f3f4f6;">
        @if($photoUrl)
            <img src="{{ $photoUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
        @endif
    </div>

    <div style="position: absolute; top: 22mm; left: 38mm; right: 25mm;">
        <h1 style="font-size: 18pt; font-weight: 900; color: #111827; text-transform: uppercase; line-height: 1; margin: 0;">
            {{ $employee->last_name }}
        </h1>
        <h2 style="font-size: 13pt; font-weight: 500; color: #4b5563; text-transform: uppercase; margin: 2pt 0 0 0;">
            {{ $employee->first_name }}
        </h2>

        <div style="margin-top: 4mm;">
            <p style="font-size: 6pt; font-weight: 700; color: #9ca3af; text-transform: uppercase; margin: 0; letter-spacing: 0.05em;">Fonction</p>
            <p style="font-size: 11pt; font-weight: 800; text-transform: uppercase; color: {{ $mainColor }}; margin: 0;">
                {{ $employee->function }}
            </p>
            <p style="font-size: 8pt; font-weight: 600; color: #6b7280; text-transform: uppercase; margin: 0;">
                {{ $employee->department ?? 'Informatique' }}
            </p>
        </div>
    </div>

    <div style="position: absolute; bottom: 4mm; right: 5mm; text-align: center; width: 18mm;">
        @if($qrCodeUrl)
            <img src="{{ $qrCodeUrl }}" style="width: 15mm; height: 15mm; display: block; margin: 0 auto;">
        @endif
        <p style="font-size: 5pt; font-family: monospace; font-weight: 700; color: #111827; margin: 1mm 0 0 0;">
            {{ $employee->badge_number }}
        </p>
    </div>

    <div style="position: absolute; bottom: 0; left: 0; width: 3mm; height: 35mm; background-color: {{ $mainColor }}; border-top-right-radius: 2mm;"></div>
</div>