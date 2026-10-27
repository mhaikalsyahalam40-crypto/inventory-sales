<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Pemasok | Nexora Tech</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: "Segoe UI", Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        header { background: #1e3a8a; color: white; padding: 20px 5%; }
        header a { color: white; text-decoration: none; }
        main { max-width: 750px; margin: 32px auto; padding: 0 20px; }
        h1 { margin: 0 0 8px; font-size: 26px; }
        .muted { color: #64748b; margin-bottom: 25px; }
        .panel { padding: 27px; background: white; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 5px 18px #1e3a8a08; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px; }
        .field { margin-bottom: 17px; }
        label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font: inherit; font-size: 14px; }
        input:focus, textarea:focus { outline: 2px solid #bfdbfe; border-color: #2563eb; }
        textarea { min-height: 100px; resize: vertical; }
        .error { color: #b91c1c; font-size: 12px; margin-top: 6px; }
        .alert { background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 18px; }
        .actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; }
        .btn { padding: 12px 17px; border: 0; border-radius: 8px; cursor: pointer; text-decoration: none; font-size: 13px; }
        .primary { background: #2563eb; color: white; }
        .secondary { background: #e2e8f0; color: #334155; }
        @media(max-width: 600px) { .grid { grid-template-columns: 1fr; } .panel { padding: 20px; } }
    </style>
</head>
<body>
<header><a href="{{ route('dashboard') }}"><strong>▦ Nexora Tech</strong></a></header>

<main>
    <h1>Edit Pemasok</h1>
    <p class="muted">Perbarui informasi {{ $supplier->name }}.</p>

    @if($errors->any())
        <div class="alert">Periksa kembali formulir. {{ $errors->first() }}</div>
    @endif

    <section class="panel">
        <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
            @csrf
            @method('PUT')

            <div class="grid">
                <div class="field">
                    <label for="name">Nama Pemasok *</label>
                    <input id="name" name="name" value="{{ old('name', $supplier->name) }}" maxlength="255" required>
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="phone">Nomor Telepon</label>
                    <input id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" maxlength="30">
                    @error('phone') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $supplier->email) }}" maxlength="255">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="field">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" maxlength="1000">{{ old('address', $supplier->address) }}</textarea>
                @error('address') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="actions">
                <a href="{{ route('suppliers.index') }}" class="btn secondary">Batal</a>
                <button type="submit" class="btn primary">Simpan Perubahan</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
