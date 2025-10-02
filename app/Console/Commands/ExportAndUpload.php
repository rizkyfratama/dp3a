<?php

namespace App\Console\Commands;

use App\Exports\PengaduanExport;
use App\Services\GoogleDriveService;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportAndUpload extends Command
{
    protected $signature = 'app:export-and-upload';
    protected $description = 'Export pengaduan harian ke Excel dan upload ke Google Drive';

    public function handle(GoogleDriveService $driveService)
    {
        $this->info('Mulai export pengaduan hari ini...');
        $fileName = 'pengaduan-'.date('Y-m-d').'.xlsx';

        // simpan di storage/app/
        Excel::store(new PengaduanExport, $fileName, 'local');

        $filePath = storage_path('app/'.$fileName);

        try {
            $fileId = $driveService->uploadFile($filePath, $fileName);
            $this->info("Berhasil upload ke Google Drive. fileId: {$fileId}");
        } catch (\Throwable $e) {
            $this->error('Gagal upload ke Google Drive: ' . $e->getMessage());
            return 1;
        } finally {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return 0;
    }
}
