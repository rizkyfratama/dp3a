<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Services\GoogleDriveService; // tambahkan service
use Illuminate\Http\Request;



class PengaduanController extends Controller
{
    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request, GoogleDriveService $driveService)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'isi_pengaduan' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx|max:4096',
        ]);

        $lampiranPath = null;
        $lampiranDriveId = null;

        if ($request->hasFile('lampiran')) {
            // 1. Simpan ke lokal (storage/app/public/lampiran)
            $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');

            // 2. Upload ke Google Drive
            $filePath = storage_path('app/public/'.$lampiranPath);
            $lampiranDriveId = $driveService->uploadFile(
                $filePath,
                $request->file('lampiran')->getClientOriginalName(),
                $request->file('lampiran')->getMimeType()
            );
        }

        // Simpan data ke database
        Pengaduan::create([
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'kategori' => $request->kategori,
            'isi_pengaduan' => $request->isi_pengaduan,
            'lampiran' => $lampiranPath,          // path file lokal
            'lampiran_drive_id' => $lampiranDriveId, // ID file di Google Drive
        ]);

        return redirect('/pengaduan')->with('success', 'Pengaduan berhasil dikirim! File tersimpan lokal & Google Drive.');
    }

    public function index()
    {
        $pengaduans = Pengaduan::latest()->get();
        return view('pengaduan.index', compact('pengaduans'));
    }
}
