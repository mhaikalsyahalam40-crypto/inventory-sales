<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna | Nexora Tech</title>

    <style>
        :root {
            --navy: #1e3a8a;
            --blue: #2563eb;
            --bg: #f5f7fb;
            --text: #172554;
            --muted: #64748b;
            --border: #e8edf5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 7px;
            font-size: 27px;
        }

        .subtitle {
            color: var(--muted);
            font-size: 13px;
        }

        .button {
            display: inline-block;
            padding: 11px 15px;
            border: none;
            border-radius: 8px;
            background: var(--blue);
            color: white;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .button.secondary {
            background: #e2e8f0;
            color: var(--text);
        }

        .button.edit {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .button.delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .panel {
            padding: 23px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: white;
        }

        .alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 9px;
            font-size: 13px;
        }

        .alert.success {
            background: #dcfce7;
            color: #166534;
        }

        .alert.error {
            background: #fee2e2;
            color: #991b1b;
        }

        .filters {
            display: grid;
            grid-template-columns: minmax(200px, 1fr) 180px auto auto;
            gap: 10px;
            margin-bottom: 20px;
        }

        input,
        select {
            width: 100%;
            min-width: 0;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
            color: var(--text);
            font: inherit;
            font-size: 13px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 720px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-size: 12px;
        }

        th {
            background: #f8fafc;
            color: var(--muted);
            font-size: 11px;
        }

        .user-name {
            font-weight: 750;
        }

        .user-email {
            margin-top: 4px;
            color: var(--muted);
        }

        .role {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 10px;
            font-weight: 750;
        }

        .role.staff {
            background: #f1f5f9;
            color: #475569;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .actions form {
            margin: 0;
        }

        .pagination {
            margin-top: 20px;
        }

        .empty {
            padding: 30px 10px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }

        @media (max-width: 760px) {
            body {
                padding: 15px;
            }

            .panel {
                padding: 15px;
            }

            .filters {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 450px) {
            .filters {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Manajemen Pengguna</h1>
            <div class="subtitle">
                Kelola akun dan hak akses pengguna sistem.
            </div>
        </div>

        <a href="{{ route('users.create') }}" class="button">
            + Tambah Pengguna
        </a>
    </div>

    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="panel">

        <form method="GET" action="{{ route('users.index') }}" class="filters">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau email..."
            >

            <select name="role">
                <option value="">Semua peran</option>

                <option
                    value="admin"
                    @selected(request('role') === 'admin')
                >
                    Admin
                </option>

                <option
                    value="staff"
                    @selected(request('role') === 'staff')
                >
                    Staff
                </option>
            </select>

            <button class="button" type="submit">
                Cari
            </button>

            <a class="button secondary" href="{{ route('users.index') }}">
                Reset
            </a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pengguna</th>
                        <th>Peran</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="user-name">
                                    {{ $user->name }}
                                </div>

                                <div class="user-email">
                                    {{ $user->email }}
                                </div>

                                @if ($user->id === auth()->id())
                                    <small style="color:#2563eb">
                                        Akun Anda
                                    </small>
                                @endif
                            </td>

                            <td>
                                <span class="role {{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td>
                                {{ $user->created_at?->format('d/m/Y') ?? '-' }}
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        class="button edit"
                                    >
                                        Edit
                                    </a>

                                    @if ($user->id !== auth()->id())
                                        <form
                                            action="{{ route('users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="button delete"
                                                type="submit"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada pengguna yang cocok dengan pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $users->links() }}
        </div>

    </div>

    <p style="margin-top:20px">
        <a
            href="{{ route('dashboard') }}"
            style="color:#2563eb;text-decoration:none"
        >
            ← Kembali ke Dashboard
        </a>
    </p>

</div>
</body>
</html>