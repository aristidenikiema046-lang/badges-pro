@php 
    $mainColor = $employee->badge_color ?? '#16a34a'; 
    
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

<style>
    /* Supprime les marges physiques de la page PDF */
    @page { 
        margin: 0; 
    }
    
    body { 
        margin: 0; 
        padding: 0; 
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        background-color: #ffffff; 
    }

    /* Conteneur du badge : défini pour être propre et centré */
    .badge-card {
        width: 86mm;
        height: 54mm;
        border: 0.2mm solid #dddddd;
        border-radius: 5px;
        background: white;
        position: relative;
        overflow: hidden;
        margin: auto; /* Centre le badge sur la page A6 */
    }

    .header-bar {
        height: 4mm;
        background-color: {{ $mainColor }};
        width: 100%;
    }

    .top-section {
        padding: 10px 15px;
        height: 10mm;
    }

    .logo-img {
        height: 25px;
        float: left;
    }

    .badge-label {
        float: right;
        font-size: 7pt; 
        color: #999; 
        font-weight: bold; 
        text-transform: uppercase;
        margin-top: 5px;
    }

    .content-body {
        padding: 0 15px;
        clear: both;
    }

    .photo-box {
        width: 28mm;
        height: 35mm;
        border-radius: 3px;
        border: 0.1mm solid #eeeeee;
        overflow: hidden;
        float: left;
    }

    .info-box {
        margin-left: 33mm;
        padding-top: 2mm;
    }

    .name-text {
        font-size: 16pt; 
        margin: 0; 
        text-transform: uppercase;
        font-weight: 800;
        color: #1a1a1a;
    }

    .firstname-text {
        font-size: 11pt; 
        margin: 0; 
        color: #444;
        font-weight: 500;
    }

    .job-title {
        margin-top: 4mm;
    }

    .label-small {
        font-size: 5pt; 
        color: #aaaaaa; 
        text-transform: uppercase;
        font-weight: bold;
    }

    .value-bold {
        font-size: 9pt; 
        font-weight: bold; 
        color: {{ $mainColor }};
        text-transform: uppercase;
    }

    .footer-right {
        position: absolute;
        bottom: 8px;
        right: 15px;
        text-align: center;
    }

    .qr-code {
        width: 14mm; 
        height: 14mm;
    }

    .matricule {
        font-size: 5pt; 
        font-family: monospace;
        color: #333;
        margin-top: 2px;
    }
</style>

<div class="badge-card">
    <div class="header-bar"></div>
    
    <div class="top-section">
        @if($logoUrl)
            <img src="{{ $logoUrl }}" class="logo-img">
        @endif
        <span class="badge-label">Badge Professionnel</span>
    </div>

    <div class="content-body">
        <div class="photo-box">
            @if($photoUrl)
                <img src="{{ $photoUrl }}" style="width: 100%; height: 100%; object-fit: cover;">
            @endif
        </div>

        <div class="info-box">
            <h1 class="name-text">{{ $employee->last_name }}</h1>
            <h2 class="firstname-text">{{ $employee->first_name }}</h2>
            
            <div class="job-title">
                <div class="label-small">Fonction</div>
                <div class="value-bold">{{ $employee->function }}</div>
                <div style="font-size: 7pt; color: #666;">{{ $employee->department ?? 'Informatique' }}</div>
            </div>
        </div>
    </div>

    <div class="footer-right">
        @if($qrCodeUrl)
            <img src="{{ $qrCodeUrl }}" class="qr-code">
        @endif
        <div class="matricule">{{ $employee->badge_number }}</div>
    </div>
</div>