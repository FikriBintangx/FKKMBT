<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panic Button - FKKMBT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #111827; color: white; height: 100vh; overflow: hidden; }
        .panic-container {
            height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; position: relative; z-index: 10;
        }
        
        .panic-btn-wrapper {
            position: relative; width: 250px; height: 250px; margin-bottom: 40px;
        }
        
        .panic-btn {
            width: 100%; height: 100%; border-radius: 50%; border: none;
            background: radial-gradient(circle, #ef4444 0%, #991b1b 100%);
            box-shadow: 0 0 50px rgba(239, 68, 68, 0.5), inset 0 5px 20px rgba(255,255,255,0.2);
            color: white; font-weight: 800; font-size: 32px; text-transform: uppercase;
            letter-spacing: 2px; position: relative; z-index: 20;
            transition: transform 0.1s; cursor: pointer;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        
        .panic-btn:active { transform: scale(0.95); background: #7f1d1d; }
        
        /* Ripple Animation */
        .ripple {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 100%; height: 100%; border-radius: 50%; border: 2px solid #ef4444;
            animation: ripple-anim 2s infinite linear; opacity: 0; z-index: 1;
        }
        .ripple:nth-child(1) { animation-delay: 0s; }
        .ripple:nth-child(2) { animation-delay: 0.6s; }
        .ripple:nth-child(3) { animation-delay: 1.2s; }
        
        @keyframes ripple-anim {
            0% { width: 100%; height: 100%; opacity: 0.8; }
            100% { width: 300%; height: 300%; opacity: 0; }
        }

        .emergency-type-grid {
            display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; width: 100%; max-width: 400px; padding: 0 20px;
        }
        .type-btn {
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 15px 10px; color: white; transition: 0.3s;
            display: flex; flex-direction: column; align-items: center; gap: 5px;
            cursor: pointer;
        }
        .type-btn.active { background: #ef4444; border-color: #ef4444; }
        .type-btn:hover { background: rgba(255,255,255,0.2); }
        .type-icon { font-size: 24px; }
        .type-label { font-size: 12px; font-weight: 600; }

        .close-btn {
            position: absolute; top: 20px; right: 20px; color: white; font-size: 24px; opacity: 0.7;
        }
        
        .countdown-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9);
            z-index: 100; display: none; align-items: center; justify-content: center; flex-direction: column;
        }
        .countdown-num { font-size: 120px; font-weight: 800; color: #ef4444; }
    </style>
</head>
<body>

    <a href="<?= base_url('user/dashboard') ?>" class="close-btn"><i class="bi bi-x-lg"></i></a>

    <div class="panic-container">
        <h4 class="fw-bold mb-4 opacity-75">EMERGENCY BUTTON</h4>
        
        <div class="panic-btn-wrapper" id="btnWrapper">
            <button class="panic-btn" onclick="startPanic()">
                <i class="bi bi-broadcast fs-1 mb-2"></i>
                SOS
            </button>
            <div class="ripple"></div>
            <div class="ripple"></div>
            <div class="ripple"></div>
        </div>

        <p class="small text-muted mb-4">Pilih jenis darurat (Opsional):</p>

        <div class="emergency-type-grid">
            <div class="type-btn active" onclick="selectType(this, 'MEDIS')">
                <i class="bi bi-hospital type-icon"></i>
                <span class="type-label">MEDIS</span>
            </div>
            <div class="type-btn" onclick="selectType(this, 'KEBAKARAN')">
                <i class="bi bi-fire type-icon"></i>
                <span class="type-label">KEBAKARAN</span>
            </div>
            <div class="type-btn" onclick="selectType(this, 'MALING')">
                <i class="bi bi-shield-exclamation type-icon"></i>
                <span class="type-label">KEAMANAN</span>
            </div>
        </div>
        
        <div class="mt-4 small text-danger fw-bold opacity-0" id="statusMsg">
            <i class="bi bi-geo-alt-fill me-1"></i> Lokasi terdeteksi... Mengirim sinyal...
        </div>
    </div>

    <!-- Countdown Overlay -->
    <div class="countdown-overlay" id="countdownBox">
        <h3 class="text-white mb-4">MENGIRIM SINYAL DARURAT</h3>
        <div class="countdown-num" id="countDisplay">3</div>
        <button class="btn btn-outline-light rounded-pill px-4 mt-5" onclick="cancelPanic()">BATALKAN</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let selectedType = 'MEDIS';
        let countdownInterval;
        let isPanicActive = false;

        function selectType(el, type) {
            $('.type-btn').removeClass('active');
            $(el).addClass('active');
            selectedType = type;
        }

        function startPanic() {
            $('#countdownBox').css('display', 'flex');
            let count = 3;
            $('#countDisplay').text(count);
            
            countdownInterval = setInterval(() => {
                count--;
                $('#countDisplay').text(count);
                if(count <= 0) {
                    clearInterval(countdownInterval);
                    triggerSignal();
                }
            }, 1000);
        }

        function cancelPanic() {
            clearInterval(countdownInterval);
            $('#countdownBox').hide();
        }

        function triggerSignal() {
            $('#countdownBox').html('<h2 class="text-success fw-bold">SINYAL TERKIRIM!</h2><p class="text-white mt-2">Bantuan sedang menuju lokasi anda.</p><a href="<?= base_url('user/dashboard') ?>" class="btn btn-primary mt-4 rounded-pill">Kembali ke Dashboard</a>');
            
            // Get Geo
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendData, showError);
            } else {
                sendData({ coords: { latitude: 0, longitude: 0 } });
            }
        }

        function sendData(position) {
            $.post('<?= base_url('user/panic/trigger') ?>', {
                jenis: selectedType,
                lat: position.coords.latitude,
                long: position.coords.longitude
            }, function(resp) {
                console.log('Signal Sent');
            }, 'json');
        }

        function showError(error) {
            // Still send data even if gps fails
            sendData({ coords: { latitude: 0, longitude: 0 } });
        }
    </script>
</body>
</html>
