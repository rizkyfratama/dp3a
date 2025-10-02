<?php

namespace App\Http\Controllers;

use App\Exports\PengaduanExport;
use App\Http\Requests\StorePengaduanRequest;
use App\Models\Pengaduan;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // Tampilkan form pengaduan (public)
    public function create()
    {
        return view('pengaduan.create');
    }

    // Simpan pengaduan dari form web
    public function store(StorePengaduanRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        Pengaduan::create($data);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim!');
    }

    // Daftar pengaduan (admin)
    public function index()
    {
        $pengaduans = Pengaduan::latest()->paginate(15);
        return view('pengaduan.index', compact('pengaduans'));
    }

    // Download Excel hari ini
    public function export()
    {
        $fileName = 'pengaduan-'.date('Y-m-d').'.xlsx';
        return Excel::download(new PengaduanExport, $fileName);
    }

    // Export lalu upload ke Google Drive (dipanggil manual atau oleh command)
    public function exportAndUpload(GoogleDriveService $driveService)
    {
        $fileName = 'pengaduan-'.date('Y-m-d').'.xlsx';
        // simpan temporary di storage/app/
        Excel::store(new PengaduanExport, $fileName, 'local');

        $filePath = storage_path('app/'.$fileName);

        $fileId = $driveService->uploadFile($filePath, $fileName);

        // hapus file sementara
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return redirect()->back()->with('success', "Export selesai & diupload ke Google Drive (fileId: {$fileId})");
    }
}
