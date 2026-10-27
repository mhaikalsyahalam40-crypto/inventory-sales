<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Penjualan | Nexora Tech</title>

    <style>
        :root {
            --navy: #1e3a8a;
            --blue: #2563eb;
            --bg: #f5f7fb;
            --text: #172554;
            --muted: #64748b;
            --border: #e8edf5;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .container { max-width: 1100px; margin: auto; }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        h1 { margin: 0 0 7px; font-size: 26px; }
        .subtitle { color: var(--muted); font-size: 13px; }

        .panel {
            padding: 24px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: white;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        input, select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
            color: var(--text);
            font: inherit;
            font-size: 13px;
        }

        input:focus, select:focus {
            outline: 2px solid #bfdbfe;
            border-color: var(--blue);
        }

        .button {
            display: inline-block;
            padding: 11px 16px;
            border: 0;
            border-radius: 9px;
            background: var(--blue);
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .button.secondary { background: #e2e8f0; color: var(--text); }
        .button.danger { background: #fee2e2; color: #991b1b; }
        .button:disabled { opacity: .6; cursor: not-allowed; }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .section-heading h2 { margin: 0; font-size: 16px; }

        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; min-width: 720px; }

        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-size: 12px;
            vertical-align: middle;
        }

        th { background: #f8fafc; color: var(--muted); }

        td input, td select { min-width: 95px; }

        .stock-info {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;
        }

        .total-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
            padding: 20px;
            border-radius: 12px;
            background: #eff6ff;
        }

        .total-label { color: var(--muted); font-size: 12px; }
        .total-value { margin-top: 5px; color: var(--navy); font-size: 26px; font-weight: 800; }

        .alert {
            margin-bottom: 18px;
            padding: 14px;
            border-radius: 9px;
            background: #fee2e2;
            color: #991b1b;
            font-size: 13px;
        }

        .footer-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .empty-products {
            padding: 20px;
            border-radius: 9px;
            background: #fff7ed;
            color: #9a3412;
            font-size: 13px;
        }

        @media (max-width: 650px) {
            body { padding: 15px; }
            .form-grid { grid-template-columns: 1fr; }
            .panel { padding: 16px; }
            .total-value { font-size: 22px; }
        }
    </style>
</head>

<body>
<div class="container">
    <div class="header">
        <div>
            <h1>Buat Transaksi Penjualan</h1>
            <div class="subtitle">Pilih produk dan jumlah yang dibeli pelanggan.</div>
        </div>

        <a href="{{ route('sales.index') }}" class="button secondary">
            ← Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert">
            <strong>Transaksi belum dapat disimpan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($products->isEmpty())
        <div class="empty-products">
            Belum ada produk. Tambahkan produk terlebih dahulu sebelum membuat penjualan.
            <p>
                <a href="{{ route('products.create') }}">Tambah produk sekarang</a>
            </p>
        </div>
    @else
        <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
            @csrf

            <div class="panel">
                <div class="form-grid">
                    <div>
                        <label for="sold_at">Tanggal dan Waktu Penjualan</label>
                        <input
                            type="datetime-local"
                            id="sold_at"
                            name="sold_at"
                            value="{{ old('sold_at', now()->format('Y-m-d\TH:i')) }}"
                            required
                        >
                    </div>
                    <div>
                        <label>Kasir</label>
                        <input value="{{ auth()->user()->name }}" readonly>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="section-heading">
                    <h2>Daftar Barang</h2>
                    <button type="button" class="button" id="addItem">
                        + Tambah Barang
                    </button>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                        <tr>
                            <th style="width:34%">Produk</th>
                            <th>Stok</th>
                            <th>Harga Jual</th>
                            <th style="width:110px">Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody id="itemsBody"></tbody>
                    </table>
                </div>

                <div class="total-box">
                    <div>
                        <div class="total-label">Total Penjualan</div>
                        <div class="total-value" id="grandTotal">Rp 0</div>
                    </div>
                    <div class="total-label" id="itemCount">0 jenis barang</div>
                </div>
            </div>

            <div class="footer-actions">
                <a href="{{ route('sales.index') }}" class="button secondary">
                    Batal
                </a>
                <button type="submit" class="button" id="submitButton">
                    Simpan Penjualan
                </button>
            </div>
        </form>
    @endif
</div>

<script>
    const products = {{ Illuminate\Support\Js::from(
        $products->map(fn ($product) => [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'stock' => (int) $product->stock,
            'selling_price' => (float) $product->selling_price,
        ])->values()
    ) }};

    const itemsBody = document.getElementById('itemsBody');
    const addItemButton = document.getElementById('addItem');
    const grandTotalElement = document.getElementById('grandTotal');
    const itemCountElement = document.getElementById('itemCount');
    const saleForm = document.getElementById('saleForm');

    let rowCounter = 0;

    function rupiah(value) {
        return 'Rp ' + Number(value).toLocaleString('id-ID', {
            maximumFractionDigits: 0
        });
    }

    function addRow(selectedProductId = '', quantity = 1) {
        const rowId = rowCounter++;

        const row = document.createElement('tr');
        row.dataset.rowId = rowId;

        const productOptions = products.map(product => `
            <option value="${product.id}"
                ${String(product.id) === String(selectedProductId) ? 'selected' : ''}>
                ${escapeHtml(product.name)} (${escapeHtml(product.sku)})
            </option>
        `).join('');

        row.innerHTML = `
            <td>
                <select name="items[${rowId}][product_id]"
                        class="product-select" required>
                    <option value="">Pilih produk</option>
                    ${productOptions}
                </select>
            </td>
            <td>
                <span class="stock-value">-</span>
            </td>
            <td>
                <span class="price-value">Rp 0</span>
            </td>
            <td>
                <input type="number"
                    name="items[${rowId}][quantity]"
                    class="quantity-input"
                    value="${quantity}"
                    min="1"
                    step="1"
                    required>
            </td>
            <td><strong class="subtotal-value">Rp 0</strong></td>
            <td>
                <button type="button" class="button danger remove-row">
                    Hapus
                </button>
            </td>
        `;

        itemsBody.appendChild(row);

        row.querySelector('.product-select').addEventListener('change', () => {
            updateRow(row);
            updateTotal();
        });

        row.querySelector('.quantity-input').addEventListener('input', () => {
            updateRow(row);
            updateTotal();
        });

        row.querySelector('.remove-row').addEventListener('click', () => {
            row.remove();

            if (itemsBody.children.length === 0) {
                addRow();
            }

            updateTotal();
        });

        updateRow(row);
        updateTotal();
    }

    function updateRow(row) {
        const productId = row.querySelector('.product-select').value;
        const quantityInput = row.querySelector('.quantity-input');
        const quantity = Math.max(1, parseInt(quantityInput.value, 10) || 1);

        const product = products.find(item => String(item.id) === String(productId));

        row.querySelector('.stock-value').textContent =
            product ? product.stock : '-';

        row.querySelector('.price-value').textContent =
            product ? rupiah(product.selling_price) : 'Rp 0';

        row.querySelector('.subtotal-value').textContent =
            product ? rupiah(product.selling_price * quantity) : 'Rp 0';

        quantityInput.max = product ? product.stock : '';

        if (product && product.stock > 0 && quantity > product.stock) {
            quantityInput.setCustomValidity(
                'Jumlah melebihi stok yang tersedia (' + product.stock + ').'
            );
        } else if (product && product.stock === 0) {
            quantityInput.setCustomValidity('Stok produk ini kosong.');
        } else {
            quantityInput.setCustomValidity('');
        }
    }

    function updateTotal() {
        let total = 0;
        let count = 0;

        itemsBody.querySelectorAll('tr').forEach(row => {
            const productId = row.querySelector('.product-select').value;
            const quantity = parseInt(
                row.querySelector('.quantity-input').value,
                10
            ) || 0;

            const product = products.find(
                item => String(item.id) === String(productId)
            );

            if (product && quantity > 0) {
                total += product.selling_price * quantity;
                count++;
            }
        });

        grandTotalElement.textContent = rupiah(total);
        itemCountElement.textContent = count + ' jenis barang';
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

    addItemButton.addEventListener('click', () => addRow());

    saleForm?.addEventListener('submit', event => {
        if (itemsBody.querySelectorAll('tr').length === 0) {
            event.preventDefault();
            alert('Tambahkan minimal satu barang.');
            return;
        }

        const selectedProducts = [];

        for (const row of itemsBody.querySelectorAll('tr')) {
            const productId = row.querySelector('.product-select').value;

            if (!productId) {
                event.preventDefault();
                alert('Pilih produk pada semua baris.');
                return;
            }

            if (selectedProducts.includes(productId)) {
                event.preventDefault();
                alert('Produk yang sama tidak boleh dimasukkan dua kali. Ubah jumlah pada baris yang sama.');
                return;
            }

            selectedProducts.push(productId);

            const quantityInput = row.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value, 10);
            const product = products.find(
                item => String(item.id) === String(productId)
            );

            if (!Number.isInteger(quantity) || quantity < 1) {
                event.preventDefault();
                alert('Jumlah barang harus minimal 1.');
                return;
            }

            if (!product || quantity > product.stock) {
                event.preventDefault();
                alert('Stok tidak mencukupi untuk salah satu produk.');
                return;
            }
        }
    });

    addRow();
</script>
</body>
</html>
