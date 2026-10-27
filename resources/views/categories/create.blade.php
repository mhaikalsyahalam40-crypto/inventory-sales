<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kategori | Nexora Tech</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        header { background: #1e3a8a; color: white; padding: 20px 5%; }
        header a { color: white; text-decoration: none; }
        main { max-width: 650px; margin: 35px auto; padding: 0 20px; }
        h1 { margin-bottom: 8px; font-size: 25px; }
        .muted { color: #64748b; margin-bottom: 24px; }
        .panel { background: white; padding: 28px; border-radius: 12px; box-shadow: 0 4px 16px #1e3a8a0a; }
        label { display: block; font-weight: 600; font-size: 14px; margin: 18px 0 8px; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font: inherit; }
        input:focus, textarea:focus { outline: 2px solid #93c5fd; border-color: #2563eb; }
        textarea { min-height: 120px; resize: vertical; }
        .error { color: #b91c1c; font-size: 13px; margin-top: 6px; }
        .alert { background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 15px; }
        .actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px; }
        .btn { display: inline-block; padding: 12px 17px; border: 0; border-radius: 8px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .primary { background: #2563eb; color: white; }
        .secondary { background: #e2e8f0; color: #334155; }
    </style>
</head>
<body>
<header><a href="{{ route('dashboard') }}"><strong>▦ Inventory &amp; Sales</strong></a></header>

<main>
    <h1>Tambah Kategori</h1>
    <p class="muted">Masukkan informasi kategori produk baru.</p>

    @if($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    <section class="panel">
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <label for="name">Nama Kategori *</label>
            <input id="name" name="name" value="{{ old('name') }}" maxlength="255" required>
            @error('name') <div class="error">{{ $message }}</div> @enderror

            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" maxlength="1000" placeholder="Deskripsi kategori (opsional)">{{ old('description') }}</textarea>
            @error('description') <div class="error">{{ $message }}</div> @enderror

            <div class="actions">
                <a class="btn secondary" href="{{ route('categories.index') }}">Batal</a>
                <button class="btn primary" type="submit">Simpan Kategori</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
