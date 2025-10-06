<?php

namespace App\Services;

use Google\Client as Google_Client;
use Google\Service\Drive as Google_Service_Drive;
use Google\Service\Drive\DriveFile as Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Session;

class GoogleDriveService
{
    private function getClient()
    {
        $client = new Google_Client();

        // Lokasi file kredensial Google
        $client->setAuthConfig(storage_path('app/google/credentials_oauth.json'));

        // Scope akses Google Drive (hanya file yang dibuat oleh aplikasi ini)
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // URL callback setelah login
        $client->setRedirectUri(route('google.callback'));

        // Gunakan token dari session jika sudah login
        if (Session::has('google_drive_token')) {
            $client->setAccessToken(Session::get('google_drive_token'));

            // Jika token kadaluarsa, coba refresh
            if ($client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    Session::put('google_drive_token', $newToken);
                    $client->setAccessToken($newToken);
                } else {
                    throw new \Exception("Google Drive token expired. Silakan login ulang.");
                }
            }
        }

        return $client;
    }

    /**
     * Upload file ke folder Google Drive “Pengaduan DP3A”
     */
    public function uploadFile($filePath, $fileName, $mimeType)
    {
        $client = $this->getClient();
        $service = new Google_Service_Drive($client);

        // 📁 ID folder Google Drive tujuan
        $folderId = '1w4-gTdLpK0zSr6x3SWCVFAZOMozINvum';

        // Metadata file
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [$folderId],
        ]);

        // Isi file
        $content = file_get_contents($filePath);

        // Upload file ke Drive
        $file = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink',
        ]);

        // Kembalikan ID dan link file Drive
        return [
            'id' => $file->id,
            'link' => $file->webViewLink
        ];
    }
}
