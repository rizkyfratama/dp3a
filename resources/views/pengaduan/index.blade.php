@extends('layout')

@section('content')
<h2>Daftar Pengaduan</h2>

<div class="mb-3">
    <a href="{{ url('/export') }}" class="btn btn-success">Download Excel Hari Ini</a>
    <a href="{{ url('/export-upload') }}" class="btn btn-info">Export & Upload ke Google Drive</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Kategori</th>
            <th>Isi</th>
            <th>Lampiran</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pengaduans as $p)
            <tr>
                <td>{{ $p->tanggal->format('Y-m-d') }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->no_hp }}</td>
                <td>{{ $p->kategori }}</td>
                <td style="max-width:300px; white-space:normal;">{{ $p->isi_pengaduan }}</td>
                <td>
                    @if($p->lampiran)
                        <a href="{{ asset('storage/'.$p->lampiran) }}" target="_blank">Lihat</a>
                    @endif
                </td>
                <td>{{ $p->created_at->format('Y-m-d H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">Belum ada pengaduan</td></tr>
        @endforelse
    </tbody>
</table>

{{ $pengaduans->links() }}
@endsection
