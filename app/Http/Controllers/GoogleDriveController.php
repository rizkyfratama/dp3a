<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Support\Facades\Session;
use App\Services\GoogleDriveService;

class GoogleDriveController extends Controller
{
    private function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google/credentials_oauth.json'));
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setRedirectUri(route('google.callback'));
        return $client;
    }

    public function login()
    {
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
        $client = $this->getClient();

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->code);

            if (isset($token['error'])) {
                return redirect('/pengaduan')->with('error', 'Gagal mendapatkan token Google Drive');
            }

            Session::put('google_drive_token', $token);
            return redirect('/pengaduan')->with('success', 'Google Drive berhasil terkoneksi!');
        }

        return redirect('/pengaduan')->with('error', 'Tidak ada kode otorisasi dari Google');
    }

    public function upload(Request $request)
    {
        $service = new GoogleDriveService();
        $filePath = storage_path('app/public/export.xlsx');
        $service->uploadFile($filePath, 'export.xlsx');

        return redirect('/pengaduan')->with('success', 'File berhasil diupload ke Google Drive!');
    }
}
