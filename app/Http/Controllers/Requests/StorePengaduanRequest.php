<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengaduanRequest extends FormRequest
{
    public function authorize()
    {
        // Jika ada auth admin, ubah sesuai aturan. Untuk publik return true.
        return true;
    }

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'isi_pengaduan' => 'required|string',
            'lampiran' => 'nullable|file|max:2048', // 2MB
        ];
    }

    public function messages()
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi',
            'nama.required' => 'Nama wajib diisi',
            'isi_pengaduan.required' => 'Isi pengaduan wajib diisi',
        ];
    }
}
