@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">Daftar Menu Restoran Kita</h3>

<div class="row g-3">
    @forelse($menus as $menu)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                @if($menu->gambar)
                    <img src="{{ asset('storage/' . $menu->gambar) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $menu->nama_menu }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-secondary align-self-start mb-2">{{ $menu->kategori }}</span>
                    <h5 class="fw-bold">{{ $menu->nama_menu }}</h5>
                    <p class="text-muted small flex-grow-1">{{ $menu->deskripsi }}</p>
                    <p class="fw-bold text-success fs-5 mb-0">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-secondary">Belum ada data menu tersedia.</div>
        </div>
    @endforelse
</div>
@endsection