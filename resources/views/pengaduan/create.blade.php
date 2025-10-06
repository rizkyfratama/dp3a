<!DOCTYPE html>
<html>
<head>
    <title>Form Pengaduan</title>
</head>
<body>
    <h1>Form Pengaduan</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ url('/pengaduan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Tanggal:</label>
        <input type="date" name="tanggal" required><br><br>

        <label>Nama:</label>
        <input type="text" name="nama" required><br><br>

        <label>No HP:</label>
        <input type="text" name="no_hp" required><br><br>

        <label>Kategori:</label>
        <input type="text" name="kategori" required><br><br>

        <label>Isi Pengaduan:</label><br>
        <textarea name="isi_pengaduan" rows="4" required></textarea><br><br>

        <label>Lampiran (opsional):</label>
        <input type="file" name="lampiran"><br><br>

        <button type="submit">Kirim</button>
    </form>
</body>
</html>
