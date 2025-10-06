<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengaduan</title>
</head>
<body>
    <h1>Daftar Pengaduan</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Kategori</th>
                <th>Isi Pengaduan</th>
                <th>Lampiran (Lokal)</th>
                <th>Lampiran (Google Drive)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengaduans as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->tanggal }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->no_hp }}</td>
                    <td>{{ $p->kategori }}</td>
                    <td>{{ $p->isi_pengaduan }}</td>
                    <td>
                        @if($p->lampiran)
                            <a href="{{ asset('storage/'.$p->lampiran) }}" target="_blank">Lihat Lokal</a>
                        @else
                            Tidak ada
                        @endif
                    </td>
                    <td>
                        @if($p->lampiran_drive_id)
                            <a href="https://drive.google.com/file/d/{{ $p->lampiran_drive_id }}/view" target="_blank">Lihat Drive</a>
                        @else
                            Tidak ada
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Belum ada data pengaduan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
