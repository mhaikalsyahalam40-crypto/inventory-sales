<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna | Nexora Tech</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f5f7fb;
            color: #172554;
        }

        .container { max-width: 760px; margin: auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        h1 { margin: 0 0 7px; font-size: 26px; }
        .muted { color: #64748b; font-size: 13px; }

        .panel {
            padding: 25px;
            border: 1px solid #e8edf5;
            border-radius: 14px;
            background: white;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 750;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font: inherit;
            font-size: 13px;
        }

        .field { margin-bottom: 18px; }

        .button {
            display: inline-block;
            padding: 11px 16px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .secondary { background: #e2e8f0; color: #172554; }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .errors {
            margin-bottom: 18px;
            padding: 14px;
            border-radius: 8px;
            background: #fee2e2;
            color: #991b1b;
            font-size: 13px;
        }

        .hint { margin-top: 6px; color: #64748b; font-size: 11px; }

        @media (max-width: 600px) {
            body { padding: 15px; }
            .panel { padding: 18px; }
            .grid { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Tambah Pengguna</h1>
            <div class="muted">Buat akun untuk mengakses sistem.</div>
        </div>

        <a href="{{ route('users.index') }}" class="button secondary">
            ← Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="errors">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="field">
                <label for="name">Nama Lengkap</label>
                <input
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    maxlength="255"
                    autocomplete="name"
                >
            </div>

            <div class="field">
                <label for="email">Alamat Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    maxlength="255"
                    autocomplete="email"
                >
            </div>

            <div class="field">
                <label for="role">Peran Pengguna</label>
                <select id="role" name="role" required>
                    <option value="">Pilih peran</option>
                    <option value="admin" @selected(old('role') === 'admin')>
                        Admin
                    </option>
                    <option value="staff" @selected(old('role') === 'staff')>
                        Staff
                    </option>
                </select>
                <div class="hint">
                    Admin mengelola sistem, sedangkan Staff menjalankan transaksi sesuai hak aksesnya.
                </div>
            </div>

            <div class="grid">
                <div class="field">
                    <label for="password">Kata Sandi</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    >
                    <div class="hint">Minimal 8 karakter.</div>
                </div>

                <div class="field">
                    <label for="password_confirmation">
                        Konfirmasi Kata Sandi
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('users.index') }}" class="button secondary">
                    Batal
                </a>
                <button type="submit" class="button">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>