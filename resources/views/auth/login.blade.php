<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login - SIKUTA BKAD Kabupaten Tapin
    </title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome 6.5.2 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        /* =============================================================
           CSS VARIABLES (Design System)
        ============================================================= */

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
            --color-danger-border: #FECACA;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --shadow-sm: 0 1px 3px rgba(16, 63, 60, 0.06);
            --shadow-md: 0 4px 12px rgba(16, 63, 60, 0.08);
            --shadow-lg: 0 8px 24px rgba(16, 63, 60, 0.10);
            --font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }


        /* =============================================================
           RESET & BASE
        ============================================================= */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: var(--font-family);
            background: var(--color-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--color-text);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }


        /* =============================================================
           CONTAINER
        ============================================================= */

        .login-wrapper {
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: var(--color-surface);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(16, 63, 60, 0.12);
            display: grid;
            grid-template-columns: 1fr 1fr;
        }


        /* =============================================================
           LEFT PANEL — Branding
        ============================================================= */

        .login-left {
            position: relative;
            background: var(--color-primary-dark);
            color: #ffffff;
            padding: 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
        }

        /* Decorative circles */
        .login-left::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            right: -120px;
            top: -100px;
        }

        .login-left::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.03);
            left: -100px;
            bottom: -100px;
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        /* Logo badge */
        .logo-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            margin-bottom: 24px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .logo-badge i {
            font-size: 22px;
            color: #ffffff;
        }

        .brand-name {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 1.5px;
            line-height: 1;
            margin-bottom: 6px;
        }

        .brand-subtitle {
            font-size: 13px;
            font-weight: 400;
            line-height: 1.6;
            opacity: 0.85;
        }

        .brand-divider {
            width: 48px;
            height: 3px;
            margin: 32px 0 28px 0;
            background: var(--color-primary);
            border-radius: 10px;
        }

        .brand-slogan {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.3;
            max-width: 380px;
        }

        .brand-description {
            max-width: 380px;
            margin-top: 18px;
            font-size: 13.5px;
            line-height: 1.75;
            opacity: 0.8;
        }

        .security-note {
            margin-top: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            opacity: 0.7;
        }

        .security-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .security-icon i {
            font-size: 12px;
        }


        /* =============================================================
           RIGHT PANEL — Login Form
        ============================================================= */

        .login-right {
            padding: 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-heading {
            margin-bottom: 32px;
        }

        .login-heading h1 {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.3;
            color: var(--color-text);
            margin-bottom: 8px;
        }

        .login-heading .subtitle {
            color: var(--color-text-secondary);
            font-size: 14px;
            line-height: 1.6;
        }


        /* =============================================================
           ERROR ALERT
        ============================================================= */

        .alert-error {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 24px;
            padding: 14px 16px;
            background: var(--color-danger-bg);
            border: 1px solid var(--color-danger-border);
            color: var(--color-danger);
            border-radius: var(--radius-md);
            font-size: 13px;
            line-height: 1.5;
        }

        .alert-error i {
            flex-shrink: 0;
            margin-top: 2px;
            font-size: 14px;
        }


        /* =============================================================
           FORM
        ============================================================= */

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--color-text);
            font-size: 13px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-secondary);
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-group input {
            width: 100%;
            padding: 13px 16px 13px 42px;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            background: var(--color-surface);
            color: var(--color-text);
            font-family: var(--font-family);
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-group input::placeholder {
            color: #A0B5B2;
        }

        .form-group input:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(7, 133, 119, 0.15);
        }

        .form-group input:focus ~ .input-icon {
            color: var(--color-primary);
        }


        /* =============================================================
           PASSWORD TOGGLE
        ============================================================= */

        .password-toggle {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--color-text-secondary);
            font-family: var(--font-family);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--color-primary);
            background: var(--color-primary-light);
        }

        .password-input {
            padding-right: 120px !important;
        }


        /* =============================================================
           LOGIN BUTTON
        ============================================================= */

        .login-button {
            width: 100%;
            padding: 14px 20px;
            margin-top: 8px;
            border: none;
            border-radius: var(--radius-md);
            background: var(--color-primary);
            color: #ffffff;
            font-family: var(--font-family);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .login-button:hover {
            background: var(--color-primary-hover);
            box-shadow: 0 4px 14px rgba(7, 133, 119, 0.25);
        }

        .login-button:active {
            transform: translateY(1px);
            box-shadow: none;
        }


        /* =============================================================
           FOOTER
        ============================================================= */

        .login-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--color-border);
            text-align: center;
            color: var(--color-text-secondary);
            font-size: 12px;
            line-height: 1.7;
        }


        /* =============================================================
           PREFERS REDUCED MOTION
        ============================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
            }

        }


        /* =============================================================
           RESPONSIVE — Tablet
        ============================================================= */

        @media (max-width: 768px) {

            body {
                padding: 16px;
            }

            .login-wrapper {
                grid-template-columns: 1fr;
                min-height: auto;
                border-radius: var(--radius-lg);
            }

            .login-left {
                padding: 36px 32px;
            }

            .brand-slogan {
                font-size: 22px;
            }

            .brand-description {
                font-size: 13px;
            }

            .security-note {
                margin-top: 28px;
            }

            .login-right {
                padding: 36px 32px;
            }

            .login-heading h1 {
                font-size: 24px;
            }

        }


        /* =============================================================
           RESPONSIVE — Small Mobile
        ============================================================= */

        @media (max-width: 420px) {

            body {
                padding: 12px;
            }

            .login-left {
                padding: 28px 24px;
            }

            .login-right {
                padding: 28px 24px;
            }

            .logo-badge {
                width: 44px;
                height: 44px;
            }

            .logo-badge i {
                font-size: 18px;
            }

            .brand-name {
                font-size: 22px;
            }

            .brand-slogan {
                font-size: 20px;
            }

            .login-heading h1 {
                font-size: 22px;
            }

            .password-input {
                padding-right: 100px !important;
            }

        }

    </style>

</head>


<body>


<div class="login-wrapper">


    <!-- =====================================================
         LEFT PANEL — Branding
    ====================================================== -->

    <section class="login-left">

        <div class="left-content">

            <div class="logo-badge">
                <i class="fa-solid fa-building-columns"></i>
            </div>

            <div class="brand-name">SIKUTA</div>

            <div class="brand-subtitle">
                Sistem Informasi Kunjungan Tamu
                <br>
                BKAD Kabupaten Tapin
            </div>

            <div class="brand-divider"></div>

            <div class="brand-slogan">
                Pelayanan tamu yang tertib, cepat, dan terukur.
            </div>

            <div class="brand-description">
                Sistem informasi kunjungan tamu terintegrasi
                antar bidang untuk mendukung pelayanan yang
                lebih cepat dan terdokumentasi.
            </div>

            <div class="security-note">
                <span class="security-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
                <span>Sistem terenkripsi &amp; terlindungi</span>
            </div>

        </div>

    </section>


    <!-- =====================================================
         RIGHT PANEL — Login Form
    ====================================================== -->

    <section class="login-right">

        <div class="login-heading">

            <h1>Selamat Datang</h1>

            <div class="subtitle">
                Silakan masuk untuk mengakses
                Sistem Kunjungan Tamu.
            </div>

        </div>


        @if ($errors->any())

            <div class="alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <span>
                    {{ $errors->first() }}
                </span>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('login.process') }}"
        >

            @csrf


            <!-- NIP -->

            <div class="form-group">

                <label for="nip">
                    NIP
                </label>

                <div class="input-wrapper">

                    <input
                        type="text"
                        id="nip"
                        name="nip"
                        placeholder="Masukkan NIP"
                        maxlength="18"
                        inputmode="numeric"
                        autocomplete="username"
                        value="{{ old('nip') }}"
                        required
                        autofocus
                    >

                    <span class="input-icon">
                        <i class="fa-solid fa-user"></i>
                    </span>

                </div>

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="input-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="password-input"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <span class="input-icon">
                        <i class="fa-solid fa-lock"></i>
                    </span>

                    <button
                        type="button"
                        class="password-toggle"
                        id="password-toggle"
                    >
                        <i class="fa-solid fa-eye" id="toggle-icon"></i>
                        <span id="toggle-text">Tampilkan</span>
                    </button>

                </div>

            </div>


            <button
                type="submit"
                class="login-button"
            >
                <i class="fa-solid fa-right-to-bracket"></i>
                Masuk ke Sistem
            </button>

        </form>


        <div class="login-footer">
            &copy; {{ date('Y') }} SIKUTA &mdash; BKAD Kabupaten Tapin
        </div>


    </section>


</div>


<script>

    const passwordInput =
        document.getElementById('password');

    const passwordToggle =
        document.getElementById('password-toggle');

    const toggleIcon =
        document.getElementById('toggle-icon');

    const toggleText =
        document.getElementById('toggle-text');

    if (passwordInput && passwordToggle) {

        passwordToggle.addEventListener(
            'click',
            function () {

                if (passwordInput.type === 'password') {

                    passwordInput.type = 'text';

                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');

                    toggleText.textContent = 'Sembunyikan';

                } else {

                    passwordInput.type = 'password';

                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');

                    toggleText.textContent = 'Tampilkan';

                }

            }
        );

    }

</script>


</body>

</html>
