<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // boleh dipakai tanpa auth
    }

    public function rules(): array
    {
        return [
            'tanggal'    => 'required|date',
            'nama'       => 'required|string|max:255',
            'no_hp'      => 'required|string|max:20',
            'kategori'   => 'required|string|max:100',
            'isi'        => 'required|string',
            'lampiran'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
