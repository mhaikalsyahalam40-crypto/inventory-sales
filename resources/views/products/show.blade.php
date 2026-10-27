@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- Header halaman --}}
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Detail Produk
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Informasi lengkap produk dalam sistem inventaris.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('products.index') }}"
               class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                ← Kembali
            </a>

            <a href="{{ route('products.edit', $product) }}"
               class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                Edit Produk
            </a>
        </div>
    </div>

    {{-- Informasi utama produk --}}
    <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="bg-slate-800 px-6 py-5 text-white">
            <p class="text-sm text-slate-300">Nama produk</p>

            <h2 class="mt-1 text-2xl font-bold">
                {{ $product->name }}
            </h2>

            <p class="mt-2 text-sm text-slate-300">
                SKU: {{ $product->sku }}
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Kategori --}}
            <div>
                <p class="text-sm text-gray-500">Kategori</p>
                <p class="mt-2 font-semibold text-gray-800">
                    {{ $product->category?->name ?? 'Tidak ada kategori' }}
                </p>
            </div>

            {{-- Harga beli --}}
            <div>
                <p class="text-sm text-gray-500">Harga Beli</p>
                <p class="mt-2 font-semibold text-gray-800">
                    Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
                </p>
            </div>

            {{-- Harga jual --}}
            <div>
                <p class="text-sm text-gray-500">Harga Jual</p>
                <p class="mt-2 font-semibold text-gray-800">
                    Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                </p>
            </div>

            {{-- Stok saat ini --}}
            <div>
                <p class="text-sm text-gray-500">Stok Saat Ini</p>
                <p class="mt-2 text-2xl font-bold text-gray-800">
                    {{ number_format($product->stock) }}
                </p>
            </div>

            {{-- Stok minimum --}}
            <div>
                <p class="text-sm text-gray-500">Stok Minimum</p>
                <p class="mt-2 font-semibold text-gray-800">
                    {{ number_format($product->minimum_stock) }}
                </p>
            </div>

            {{-- Status stok --}}
            <div>
                <p class="text-sm text-gray-500">Status Stok</p>

                <div class="mt-2">
                    @if ($product->stock <= $product->minimum_stock)
                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                            Stok Menipis
                        </span>
                    @else
                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                            Stok Aman
                        </span>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Deskripsi produk --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="mb-3 text-lg font-bold text-gray-800">
            Deskripsi Produk
        </h3>

        @if ($product->description)
            <p class="whitespace-pre-line leading-7 text-gray-600">{{ $product->description }}</p>
        @else
            <p class="text-sm italic text-gray-400">
                Belum ada deskripsi untuk produk ini.
            </p>
        @endif
    </div>

</div>
@endsection
