<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembelian</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #0000000d;
        }

        h1 { color: #1e3a8a; }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: white;
        }

        .form-group { margin-bottom: 18px; }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th { background: #1e3a8a; color: white; }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover { background: #1e40af; }

        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #991b1b; }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .total-box {
            margin-top: 20px;
            padding: 18px;
            background: #eff6ff;
            border-radius: 8px;
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .alert {
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        @media (max-width: 650px) {
            body { padding: 12px; }
            .container { padding: 16px; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="container">

    <h1>Tambah Pembelian Barang</h1>
    <p>Masukkan supplier dan barang yang dibeli.</p>

    @if ($errors->any())
        <div class="alert">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($suppliers->isEmpty())
        <div class="alert">
            Belum ada supplier. Tambahkan supplier terlebih dahulu sebelum membuat pembelian.
        </div>
    @endif

    @if ($products->isEmpty())
        <div class="alert">
            Belum ada produk. Tambahkan produk terlebih dahulu sebelum membuat pembelian.
        </div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
        @csrf

        <div class="grid">
            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select name="supplier_id" id="supplier_id" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}"
                            @selected(old('supplier_id') == $supplier->id)>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="purchased_at">Tanggal Pembelian</label>
                <input
                    type="datetime-local"
                    name="purchased_at"
                    id="purchased_at"
                    value="{{ old('purchased_at', now()->format('Y-m-d\TH:i')) }}"
                    required
                >
            </div>
        </div>

        <h3>Daftar Barang</h3>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width: 30%">Produk</th>
                        <th style="width: 15%">Jumlah</th>
                        <th style="width: 20%">Harga Beli (Rp)</th>
                        <th style="width: 20%">Subtotal (Rp)</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="itemsBody"></tbody>
            </table>
        </div>

        <button type="button" class="btn" id="addItemBtn" style="margin-top: 15px;">
            + Tambah Barang
        </button>

        <div class="total-box">
            Total Pembelian: <span id="grandTotal">Rp 0</span>
        </div>

        <div class="actions">
            <button
                type="submit"
                class="btn"
                id="submitBtn"
                @disabled($suppliers->isEmpty() || $products->isEmpty())
            >
                Simpan Pembelian
            </button>

            <a href="{{ route('purchases.index') }}" class="btn"
               style="background:#64748b;">
                Kembali
            </a>
        </div>
    </form>
</div>

<script>
    const products = {{ Illuminate\Support\Js::from(
    $products->map(fn ($product) => [
        'id' => $product->id,
        'name' => $product->name,
        'sku' => $product->sku,
        'purchase_price' => (float) $product->purchase_price,
    ])->values()
) }};

    const oldItems = @json(old('items', []));
    const itemsBody = document.getElementById('itemsBody');
    const addItemBtn = document.getElementById('addItemBtn');

    function formatRupiah(value) {
        return 'Rp ' + Number(value).toLocaleString('id-ID', {
            maximumFractionDigits: 2
        });
    }

    function createProductOptions(selectedId = '') {
        let html = '<option value="">-- Pilih Produk --</option>';

        products.forEach(product => {
            const selected = String(product.id) === String(selectedId)
                ? 'selected'
                : '';

            html += `
                <option value="${product.id}" ${selected}>
                    ${escapeHtml(product.sku)} - ${escapeHtml(product.name)}
                </option>
            `;
        });

        return html;
    }

    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, character => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[character]);
    }

    function addRow(item = {}) {
        const row = document.createElement('tr');
        const index = itemsBody.querySelectorAll('tr').length;

        row.innerHTML = `
            <td>
                <select class="product-select"
                        name="items[${index}][product_id]" required>
                    ${createProductOptions(item.product_id ?? '')}
                </select>
            </td>
            <td>
                <input type="number"
                       class="quantity-input"
                       name="items[${index}][quantity]"
                       min="1" step="1"
                       value="${Number(item.quantity ?? 1)}"
                       required>
            </td>
            <td>
                <input type="number"
                       class="price-input"
                       name="items[${index}][unit_cost]"
                       min="0" step="0.01"
                       value="${item.unit_cost ?? ''}"
                       required>
            </td>
            <td class="subtotal-cell">Rp 0</td>
            <td>
                <button type="button" class="btn btn-danger remove-btn">
                    Hapus
                </button>
            </td>
        `;

        itemsBody.appendChild(row);

        const productSelect = row.querySelector('.product-select');
        const priceInput = row.querySelector('.price-input');

        productSelect.addEventListener('change', () => {
            const product = products.find(
                p => String(p.id) === productSelect.value
            );

            if (product) {
                priceInput.value = product.purchase_price;
            }

            calculateTotal();
        });

        row.querySelector('.quantity-input')
            .addEventListener('input', calculateTotal);

        priceInput.addEventListener('input', calculateTotal);

        row.querySelector('.remove-btn').addEventListener('click', () => {
            row.remove();
            renumberRows();
            calculateTotal();
        });

        calculateTotal();
    }

    function renumberRows() {
        itemsBody.querySelectorAll('tr').forEach((row, index) => {
            row.querySelector('.product-select')
                .name = `items[${index}][product_id]`;

            row.querySelector('.quantity-input')
                .name = `items[${index}][quantity]`;

            row.querySelector('.price-input')
                .name = `items[${index}][unit_cost]`;
        });
    }

    function calculateTotal() {
        let grandTotal = 0;

        itemsBody.querySelectorAll('tr').forEach(row => {
            const quantity = Number(
                row.querySelector('.quantity-input').value
            ) || 0;

            const price = Number(
                row.querySelector('.price-input').value
            ) || 0;

            const subtotal = quantity * price;
            grandTotal += subtotal;

            row.querySelector('.subtotal-cell').textContent =
                formatRupiah(subtotal);
        });

        document.getElementById('grandTotal').textContent =
            formatRupiah(grandTotal);
    }

    addItemBtn.addEventListener('click', () => addRow());

    if (Array.isArray(oldItems) && oldItems.length > 0) {
        oldItems.forEach(item => addRow(item));
    } else {
        addRow();
    }

    document.getElementById('purchaseForm').addEventListener('submit', event => {
        if (itemsBody.querySelectorAll('tr').length === 0) {
            event.preventDefault();
            alert('Tambahkan minimal satu barang.');
        }
    });
</script>
</body>
</html>
