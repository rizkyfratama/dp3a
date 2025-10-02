@extends('layout')

@section('content')
<h2>Form Pengaduan</h2>
<form action="{{ url('/pengaduan') }}" method="POST" enctype="multipart/form-data" class="mt-3">
    @csrf

    <div class="mb-3">
        <label class="form-label">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="form-control" required>
        @error('tanggal') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
        @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control" required>
        @error('no_hp') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori') }}" class="form-control" required placeholder="contoh: Kekerasan, Bullying">
        @error('kategori') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Isi Pengaduan</label>
        <textarea name="isi_pengaduan" rows="5" class="form-control" required>{{ old('isi_pengaduan') }}</textarea>
        @error('isi_pengaduan') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Lampiran (opsional)</label>
        <input type="file" name="lampiran" class="form-control">
        @error('lampiran') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <button class="btn btn-primary">Kirim Pengaduan</button>
</form>
@endsection
