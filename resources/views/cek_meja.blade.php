@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-3">Cek Ketersediaan Meja</h3>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ url('/cek-meja') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal_reservasi" class="form-control" value="{{ request('tanggal_reservasi', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Waktu</label>
                <input type="time" name="waktu_reservasi" class="form-control" value="{{ request('waktu_reservasi', '19:00') }}" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-dark w-100">Cek Ketersediaan</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3">
    @forelse($mejas as $meja)
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $meja->nomor_meja }}</h5>
                    <p class="text-muted mb-2">Kapasitas: {{ $meja->kapasitas }} Orang</p>
                    <span class="badge bg-success">Tersedia</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning">Semua meja penuh pada jadwal tersebut.</div>
        </div>
    @endforelse
</div>
@endsection