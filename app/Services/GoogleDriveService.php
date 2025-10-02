<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    protected Google_Client $client;
    protected Google_Service_Drive $service;

    public function __construct()
    {
        $this->client = new Google_Client();

        // Jika credential diberikan via env base64
        if (env('GOOGLE_CREDENTIALS')) {
            try {
                $credentials = base64_decode(env('GOOGLE_CREDENTIALS'));
                $path = storage_path('app/google/credentials.json');
                if (!is_dir(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }
                file_put_contents($path, $credentials);
                $this->client->setAuthConfig($path);
            } catch (\Throwable $e) {
                Log::error('GoogleDriveService: gagal menulis credentials dari env - '.$e->getMessage());
            }
        } else {
            // fallback ke file yang ada di storage/app/google/credentials.json
            $path = storage_path('app/google/credentials.json');
            if (!file_exists($path)) {
                throw new \Exception('Google credentials tidak ditemukan. Masukkan GOOGLE_CREDENTIALS (base64) atau upload credentials.json ke storage/app/google/');
            }
            $this->client->setAuthConfig($path);
        }

        $this->client->addScope(Google_Service_Drive::DRIVE_FILE);

        // Opsi: set access type offline jika menggunakan refresh token, dsb.
        $this->service = new Google_Service_Drive($this->client);
    }

    /**
     * Upload file ke Google Drive. Mengembalikan fileId
     * @param string $filePath absolute path file di server
     * @param string $fileName nama file di Drive
     * @param string|null $mimeType
     * @return string fileId
     */
    public function uploadFile(string $filePath, string $fileName, ?string $mimeType = null): string
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File tidak ditemukan: {$filePath}");
        }

        $mimeType = $mimeType ?? 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName
        ]);

        $content = file_get_contents($filePath);

        $file = $this->service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart'
        ]);

        // return ID file
        return $file->id;
    }
}
