@php 
    $mainColor = $employee->badge_color ?? '#16a34a'; 
    
    // Conversion systématique en Base64 pour le PDF et le PNG
    $getPath = function($path) {
        if (!$path) return '';
        $fullPath = public_path('storage/' . $path);
        if (!file_exists($fullPath)) return '';
        $type = pathinfo($fullPath, PATHINFO_EXTENSION);
        $data = file_get_contents($fullPath);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    };

    $photo = $getPath($employee->photo);
    $logo = $getPath($employee->company->logo ?? '');
    $qr = $getPath($employee->qr_code);
@endphp

<style>
    /* Dimensions CR80 strictes */
    .badge-fixed-container {
        width: 85.6mm;
        height: 54mm;
        position: relative;
        background-color: white;
        margin: 0;
        padding: 0;
        overflow: hidden;
        font-family: 'Helvetica', 'Arial', sans-serif;
        box-sizing: border-box;
    }

    /* Barre décorative verte à gauche */
    .side-bar {
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3mm;
        background-color: {{ $mainColor }};
        z-index: 5;
    }

    /* Cadre photo */
    .photo-frame {
        position: absolute;
        left: 8mm;
        top: 9mm;
        width: 30mm;
        height: 36mm;
        border: 0.5mm solid #eee;
        border-radius: 2mm;
        overflow: hidden;
        background: #fafafa;
    }
    .photo-frame img { width: 100%; height: 100%; object-fit: cover; }

    /* Section informations à droite */
    .info-section {
        position: absolute;
        left: 42mm;
        top: 0;
        right: 0;
        bottom: 0;
        padding: 5mm;
    }

    .comp-logo { height: 7mm; width: auto; max-width: 30mm; margin-bottom: 3mm; object-fit: contain; }
    
    .emp-name { font-size: 14pt; font-weight: 900; color: #111; text-transform: uppercase; margin: 0; line-height: 1.1; }
    .emp-fn { font-size: 11pt; color: #444; text-transform: uppercase; margin: 0; margin-bottom: 2mm; }
    
    .role-label { font-size: 5pt; color: #aaa; text-transform: uppercase; font-weight: bold; margin: 0; }
    .emp-role { font-size: 9pt; font-weight: bold; color: {{ $mainColor }}; text-transform: uppercase; margin: 0; }
    
    /* Zone QR Code */
    .qr-zone {
        position: absolute;
        bottom: 4mm;
        right: 5mm;
        text-align: center;
    }
    .qr-zone img { width: 13mm; height: 13mm; }
    .matricule-text { font-size: 5.5pt; font-family: monospace; margin-top: 1mm; color: #333; font-weight: bold; }
</style>

<div class="badge-fixed-container">
    <div class="side-bar"></div>
    
    <div class="photo-frame">
        @if($photo) <img src="{{ $photo }}"> @endif
    </div>

    <div class="info-section">
        @if($logo)
            <img src="{{ $logo }}" class="comp-logo">
        @else
            <div style="height: 7mm;"></div>
        @endif
        
        <div style="margin-top: 2mm;">
            <p class="emp-name">{{ $employee->last_name }}</p>
            <p class="emp-fn">{{ $employee->first_name }}</p>
            
            <p class="role-label">Fonction</p>
            <p class="emp-role">{{ $employee->function }}</p>
            <p style="font-size: 7pt; color: #666; margin: 0;">{{ $employee->department ?? 'SERVICE INFORMATIQUE' }}</p>
        </div>

        <div class="qr-zone">
            @if($qr) <img src="{{ $qr }}"> @endif
            <div class="matricule-text">{{ $employee->badge_number }}</div>
        </div>
    </div>
</div>