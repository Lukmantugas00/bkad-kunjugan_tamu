<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Notifikasi - SIKUTA BKAD Kabupaten Tapin</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --color-primary-dark: #103F3C;
            --color-primary-active: #17534E;
            --color-primary: #078577;
            --color-primary-hover: #066b60;
            --color-primary-light: #E0F5EF;
            --color-bg: #F3F7F6;
            --color-surface: #FFFFFF;
            --color-text: #183532;
            --color-text-secondary: #718784;
            --color-border: #D8E4E1;
            --color-danger: #DC2626;
            --color-danger-bg: #FEF2F2;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --shadow-sm: 0 1px 3px rgba(16, 63, 60, 0.05);
            --shadow-md: 0 4px 14px rgba(16, 63, 60, 0.08);
            --font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background: var(--color-bg);
            color: var(--color-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* HEADER */
        .header {
            background: var(--color-primary-dark);
            color: #ffffff;
            padding: 18px 32px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
        }

        .header-inner {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
        }

        .brand-sub {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* CONTAINER */
        .container {
            max-width: 960px;
            width: 100%;
            margin: 32px auto 60px;
            padding: 0 20px;
            flex: 1;
        }

        .back-nav {
            margin-bottom: 22px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text);
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
            background: var(--color-primary-light);
        }

        /* CARD */
        .settings-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-xl);
            padding: 36px;
            box-shadow: var(--shadow-md);
        }

        .card-head {
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--color-border);
        }

        .card-head h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--color-primary-dark);
            margin-bottom: 6px;
        }

        .card-head p {
            font-size: 13px;
            color: var(--color-text-secondary);
            line-height: 1.5;
        }

        /* Alerts */
        .alert-box {
            padding: 13px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-box.success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-box.danger {
            background: var(--color-danger-bg);
            color: var(--color-danger);
            border: 1px solid #fecaca;
        }

        /* Toggle Row */
        .toggle-box {
            background: #fafcfb;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
        }

        .toggle-info h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 3px;
        }

        .toggle-info p {
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        /* Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 26px;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .track {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1;
            transition: .25s;
            border-radius: 34px;
        }

        .track:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .25s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        input:checked + .track {
            background-color: var(--color-primary);
        }

        input:checked + .track:before {
            transform: translateX(22px);
        }

        /* Field Section */
        .field-group {
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--color-border);
        }

        .field-group:last-of-type {
            margin-bottom: 24px;
            padding-bottom: 0;
            border-bottom: none;
        }

        .field-label-styled {
            font-size: 14px;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 12px;
            display: block;
        }

        /* Radio Options */
        .sound-options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .sound-option-card {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 16px;
            cursor: pointer;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .sound-option-card:hover {
            border-color: var(--color-primary);
            background: #fbfdfd;
        }

        .sound-option-card input[type="radio"] {
            margin-top: 3px;
            accent-color: var(--color-primary);
        }

        .sound-option-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-text);
            display: block;
            margin-bottom: 2px;
        }

        .sound-option-desc {
            font-size: 11px;
            color: var(--color-text-secondary);
            line-height: 1.4;
            display: block;
        }

        /* File Upload Box */
        .file-upload-card {
            background: #fafcfb;
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-md);
            padding: 20px;
            margin-top: 16px;
        }

        .current-audio-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border: 1px solid var(--color-border);
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            margin-top: 12px;
            font-size: 12px;
        }

        /* Range Volume */
        .volume-box {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 10px;
        }

        .volume-range {
            flex: 1;
            height: 6px;
            border-radius: 5px;
            background: #e2e8f0;
            outline: none;
            accent-color: var(--color-primary);
        }

        .volume-val-badge {
            font-size: 13px;
            font-weight: 700;
            color: var(--color-primary);
            background: var(--color-primary-light);
            padding: 4px 10px;
            border-radius: 999px;
            min-width: 50px;
            text-align: center;
        }

        /* Actions */
        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--color-border);
        }

        .btn-test {
            background: transparent;
            border: 1px solid var(--color-border);
            color: var(--color-text);
            padding: 11px 20px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-test:hover:not(:disabled) {
            border-color: var(--color-primary);
            color: var(--color-primary);
            background: var(--color-primary-light);
        }

        .btn-submit {
            background: var(--color-primary);
            color: #ffffff;
            border: none;
            padding: 12px 26px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
            box-shadow: 0 4px 12px rgba(7, 133, 119, 0.25);
        }

        .btn-submit:hover {
            background: var(--color-primary-hover);
        }

        @media (max-width: 768px) {
            .header { padding: 14px 20px; }
            .container { padding: 0 16px; margin: 20px auto 40px; }
            .settings-card { padding: 22px; }
            .sound-options-grid { grid-template-columns: 1fr; }
            .toggle-box { flex-direction: column; align-items: flex-start; }
            .form-actions { flex-direction: column-reverse; }
            .form-actions button { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="header-inner">
            <a href="{{ route('kunjungan.inbox', $bidang->kode) }}" class="brand-link">
                <div class="brand-logo">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div>
                    <div class="brand-title">SIKUTA BKAD</div>
                    <div class="brand-sub">Sistem Kunjungan Tamu &bull; BKAD Kabupaten Tapin</div>
                </div>
            </a>
            <div style="font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.85);">
                {{ $bidang->nama }}
            </div>
        </div>
    </header>

    <main class="container">
        <div class="back-nav">
            <a href="{{ route('kunjungan.inbox', $bidang->kode) }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Kotak Masuk</span>
            </a>
        </div>

        <div class="settings-card">
            <div class="card-head">
                <h1>Pengaturan Notifikasi Suara</h1>
                <p>Sesuaikan nada dering dan volume pemberitahuan agar petugas segera mengetahui ketika terdapat kunjungan tamu baru yang ditujukan ke Bidang {{ $bidang->nama }}.</p>
            </div>

            @if(session('success'))
                <div class="alert-box success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-box danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>
                        <ul style="margin: 0 0 0 16px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('pengaturan-bidang.notifikasi.update') }}" enctype="multipart/form-data" id="notificationForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="notifikasi_aktif" value="0">

                {{-- Toggle on/off --}}
                <div class="toggle-box">
                    <div class="toggle-info">
                        <h3>Pemberitahuan Suara Otomatis</h3>
                        <p>Bunyikan nada peringatan saat pengunjung baru mendaftar di meja piket.</p>
                    </div>

                    <label class="switch" aria-label="Aktifkan notifikasi suara">
                        <input type="checkbox" name="notifikasi_aktif" value="1" id="notificationEnabled"
                               @checked((bool) old('notifikasi_aktif', $bidang->notifikasi_aktif))>
                        <span class="track"></span>
                    </label>
                </div>

                {{-- Radio Sound Type --}}
                <div class="field-group">
                    <label class="field-label-styled">Pilihan Jenis Suara</label>

                    <div class="sound-options-grid">
                        <label class="sound-option-card">
                            <input type="radio" name="notifikasi_jenis_suara" value="bawaan"
                                   @checked(old('notifikasi_jenis_suara', $bidang->notifikasi_jenis_suara) === 'bawaan')>
                            <div>
                                <span class="sound-option-title">Suara Bawaan</span>
                                <span class="sound-option-desc">Nada lonceng sintesis standar dari browser.</span>
                            </div>
                        </label>

                        <label class="sound-option-card">
                            <input type="radio" name="notifikasi_jenis_suara" value="khusus"
                                   @checked(old('notifikasi_jenis_suara', $bidang->notifikasi_jenis_suara) === 'khusus')>
                            <div>
                                <span class="sound-option-title">Suara Khusus</span>
                                <span class="sound-option-desc">Unggah file nada dering khusus (.mp3 / .wav).</span>
                            </div>
                        </label>

                        <label class="sound-option-card">
                            <input type="radio" name="notifikasi_jenis_suara" value="senyap"
                                   @checked(old('notifikasi_jenis_suara', $bidang->notifikasi_jenis_suara) === 'senyap')>
                            <div>
                                <span class="sound-option-title">Senyap</span>
                                <span class="sound-option-desc">Tanpa suara (hanya notifikasi visual pada layar).</span>
                            </div>
                        </label>
                    </div>

                    {{-- Upload file if custom --}}
                    <div class="file-upload-card" id="customSoundField">
                        <label for="suara_khusus" style="display:block; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                            Unggah File Audio Khusus
                        </label>
                        <input type="file" name="suara_khusus" id="suara_khusus" accept=".mp3,.wav,.ogg,audio/mpeg,audio/wav,audio/ogg" style="font-size: 13px;">
                        <p style="font-size: 11px; color: var(--color-text-secondary); margin-top: 6px;">
                            Mendukung format MP3, WAV, atau OGG. Ukuran maksimal 5 MB.
                        </p>

                        @if($bidang->notifikasi_suara_path)
                            <div class="current-audio-info">
                                <span><i class="fa-solid fa-music"></i> {{ basename($bidang->notifikasi_suara_path) }}</span>
                                <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; color: var(--color-danger);">
                                    <input type="checkbox" name="hapus_suara" value="1">
                                    <span>Hapus file tersimpan</span>
                                </label>
                            </div>
                        @endif

                        <audio id="soundPreview" style="margin-top: 12px; width: 100%;" controls
                            @if($bidang->notifikasi_suara_path)
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($bidang->notifikasi_suara_path) }}"
                            @endif
                            @if(!$bidang->notifikasi_suara_path) hidden @endif>
                        </audio>
                    </div>
                </div>

                {{-- Volume Slider --}}
                <div class="field-group">
                    <label for="notifikasi_volume" class="field-label-styled">Volume Pemberitahuan</label>
                    <div class="volume-box">
                        <input type="range" min="0" max="100" step="5" id="notifikasi_volume" name="notifikasi_volume"
                               class="volume-range" value="{{ old('notifikasi_volume', $bidang->notifikasi_volume) }}">
                        <span class="volume-val-badge" id="volumeValue">
                            {{ old('notifikasi_volume', $bidang->notifikasi_volume) }}%
                        </span>
                    </div>
                </div>

                {{-- Submit & Test --}}
                <div class="form-actions">
                    <button type="button" class="btn-test" id="testSound">
                        <i class="fa-solid fa-play"></i>
                        <span>Uji Coba Suara</span>
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>

            </form>
        </div>
    </main>

    {{-- Script for Audio Test and Dynamic Form --}}
    <script>
    (() => {
        const enabled = document.getElementById('notificationEnabled');
        const volume = document.getElementById('notifikasi_volume');
        const volumeValue = document.getElementById('volumeValue');
        const fileInput = document.getElementById('suara_khusus');
        const preview = document.getElementById('soundPreview');
        const customField = document.getElementById('customSoundField');
        const testButton = document.getElementById('testSound');

        let localAudioUrl = null;

        function selectedType() {
            return document.querySelector('input[name="notifikasi_jenis_suara"]:checked')?.value || 'khusus';
        }

        function updateUI() {
            const isEnabled = enabled.checked;
            const type = selectedType();

            volume.disabled = !isEnabled || type === 'senyap';
            testButton.disabled = !isEnabled || type === 'senyap';
            customField.hidden = type !== 'khusus';
            volumeValue.textContent = volume.value + '%';
        }

        function playDefaultSound() {
            const AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) {
                alert('Browser ini tidak mendukung pemutaran suara bawaan.');
                return;
            }
            const context = new AudioContextClass();
            const oscillator = context.createOscillator();
            const gain = context.createGain();
            oscillator.type = 'sine';
            oscillator.frequency.value = 880;
            gain.gain.value = Number(volume.value) / 100 * 0.2;
            oscillator.connect(gain);
            gain.connect(context.destination);
            oscillator.start();
            oscillator.stop(context.currentTime + 0.3);
            oscillator.onended = () => context.close();
        }

        async function playSound() {
            if (!enabled.checked) {
                alert('Silakan aktifkan notifikasi suara terlebih dahulu.');
                return;
            }

            const type = selectedType();
            if (type === 'senyap') {
                alert('Pengaturan saat ini adalah mode senyap.');
                return;
            }

            if (type === 'bawaan') {
                playDefaultSound();
                return;
            }

            if (fileInput.files.length) {
                if (localAudioUrl) URL.revokeObjectURL(localAudioUrl);
                localAudioUrl = URL.createObjectURL(fileInput.files[0]);
                preview.src = localAudioUrl;
                preview.hidden = false;
            }

            if (!preview.src) {
                alert('Pilih file audio terlebih dahulu untuk diuji coba.');
                return;
            }

            try {
                preview.volume = Number(volume.value) / 100;
                preview.currentTime = 0;
                await preview.play();
            } catch (err) {
                alert('Suara tidak dapat diputar. Klik tombol uji coba lagi.');
            }
        }

        enabled.addEventListener('change', updateUI);
        volume.addEventListener('input', updateUI);
        document.querySelectorAll('input[name="notifikasi_jenis_suara"]').forEach(r => r.addEventListener('change', updateUI));

        if (fileInput) {
            fileInput.addEventListener('change', () => {
                if (!fileInput.files.length) return;
                if (localAudioUrl) URL.revokeObjectURL(localAudioUrl);
                localAudioUrl = URL.createObjectURL(fileInput.files[0]);
                preview.src = localAudioUrl;
                preview.hidden = false;
                preview.load();
            });
        }

        testButton.addEventListener('click', playSound);
        updateUI();
    })();
    </script>
</body>
</html>
