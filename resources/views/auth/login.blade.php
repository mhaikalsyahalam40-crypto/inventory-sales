<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Inventory & Sales</title>

    <style>
        :root {
            --navy: #1e3a8a;
            --blue: #2563eb;
            --accent: #3b82f6;
            --sky: #eff6ff;
            --text: #0f172a;
            --muted: #64748b;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
            background: #f8fafc;
        }

        .page {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            min-height: 100vh;
        }

        .brand-panel {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            color: white;
            background: linear-gradient(145deg, #1e3a8a, #2563eb 72%, #3b82f6);
        }

        .brand-panel::before,
        .brand-panel::after {
            position: absolute;
            content: "";
            border: 1px solid rgba(255,255,255,.13);
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-panel::before {
            width: 430px;
            height: 430px;
            right: -160px;
            top: -100px;
        }

        .brand-panel::after {
            width: 520px;
            height: 520px;
            right: -220px;
            bottom: -240px;
        }

        .brand, .hero, .brand-footer {
            position: relative;
            z-index: 1;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            font-size: 18px;
            font-weight: 750;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(255,255,255,.17);
            font-size: 25px;
        }

        .hero { max-width: 520px; }

        .eyebrow {
            display: inline-block;
            padding: 8px 13px;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 30px;
            background: rgba(255,255,255,.10);
            font-size: 12px;
            letter-spacing: 1.4px;
            font-weight: 700;
        }

        .hero h1 {
            margin: 25px 0 18px;
            font-size: clamp(34px, 4vw, 52px);
            line-height: 1.13;
            letter-spacing: -1.5px;
        }

        .hero p {
            max-width: 430px;
            color: #dbeafe;
            line-height: 1.8;
            font-size: 15px;
        }

        .features {
            display: grid;
            gap: 15px;
            margin-top: 30px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .check {
            display: grid;
            place-items: center;
            width: 28px;
            height: 28px;
            border-radius: 9px;
            background: rgba(255,255,255,.17);
            color: white;
        }

        .brand-footer {
            color: #dbeafe;
            font-size: 12px;
        }

        .login-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 28px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }

        .mobile-brand {
            display: none;
            align-items: center;
            gap: 10px;
            margin-bottom: 35px;
            color: var(--navy);
            font-weight: 800;
        }

        .welcome {
            margin-bottom: 32px;
        }

        .welcome h2 {
            margin: 0 0 10px;
            font-size: 30px;
            letter-spacing: -.8px;
        }

        .welcome p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
            font-size: 14px;
        }

        .alert {
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 13px;
        }

        .alert.success {
            background: #dcfce7;
            color: #166534;
        }

        .field { margin-bottom: 20px; }

        label {
            display: block;
            margin-bottom: 9px;
            font-size: 13px;
            font-weight: 700;
        }

        .input-wrap { position: relative; }

        .input-wrap span {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 14px 14px 43px;
            border: 1px solid #dbe3ef;
            border-radius: 10px;
            background: white;
            color: var(--text);
            font-size: 14px;
            outline: none;
            transition: .2s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px #3b82f61c;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 2px 0 25px;
        }

        .remember input { accent-color: var(--blue); }

        .remember label {
            margin: 0;
            color: var(--muted);
            font-weight: 500;
        }

        .submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: var(--blue);
            color: white;
            font-size: 14px;
            font-weight: 750;
            cursor: pointer;
            box-shadow: 0 7px 16px #2563eb30;
            transition: .2s;
        }

        .submit:hover {
            background: var(--navy);
            transform: translateY(-1px);
        }

        .login-footer {
            margin-top: 28px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.8;
        }

        @media (max-width: 800px) {
            .page { grid-template-columns: 1fr; }
            .brand-panel { display: none; }
            .login-panel { min-height: 100vh; padding: 30px 22px; }
            .mobile-brand { display: flex; }
            .welcome h2 { font-size: 27px; }
        }
    </style>
</head>
<body>
<div class="page">
    <section class="brand-panel">
        <div class="brand">
            <div class="brand-icon">▦</div>
            <div>Inventory<span style="color:#bfdbfe"> &amp; Sales</span></div>
        </div>

        <div class="hero">
            <span class="eyebrow">BUSINESS MANAGEMENT SYSTEM</span>
            <h1>Kelola stok.<br>Optimalkan bisnis.</h1>
            <p>
                Satu platform untuk mengelola persediaan, pembelian,
                pemasok, dan penjualan bisnis dengan lebih mudah.
            </p>

            <div class="features">
                <div class="feature">
                    <span class="check">✓</span>
                    Pengelolaan produk dan persediaan
                </div>
                <div class="feature">
                    <span class="check">✓</span>
                    Pencatatan pembelian dan penjualan
                </div>
                <div class="feature">
                    <span class="check">✓</span>
                    Akses sesuai peran pengguna
                </div>
            </div>
        </div>

        <div class="brand-footer">
            Inventory &amp; Sales Management System · 2026
        </div>
    </section>

    <main class="login-panel">
        <div class="login-card">
            <div class="mobile-brand">
                <div class="brand-icon" style="background:#dbeafe">▦</div>
                Inventory &amp; Sales
            </div>

            <div class="welcome">
                <h2>Selamat datang 👋</h2>
                <p>Masuk ke akun Anda untuk melanjutkan ke dashboard.</p>
            </div>

            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="field">
                    <label for="email">Alamat email</label>
                    <div class="input-wrap">
                        <span>✉</span>
                        <input id="email" type="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@perusahaan.com"
                            autocomplete="username" required autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span>♙</span>
                        <input id="password" type="password" name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password" required>
                    </div>
                </div>

                <div class="remember">
                    <input id="remember" type="checkbox" name="remember" value="1">
                    <label for="remember">Ingat saya</label>
                </div>

                <button class="submit" type="submit">Masuk ke Dashboard →</button>
            </form>

            <div class="login-footer">
                © 2026 Inventory &amp; Sales Management System<br>
                Sistem manajemen persediaan dan penjualan
            </div>
        </div>
    </main>
</div>
</body>
</html>
