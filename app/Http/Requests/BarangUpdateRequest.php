<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama_barang' => ['required', 'string', 'max:150'],
            'kode_barang' => ['required', 'string', 'max:100', 'unique:barangs,kode_barang'],
            'kategori_id' => ['required', 'integer', 'exists:KategoriBarang,id'],
            'jumlah' => ['required', 'integer'],
            'satuan' => ['required', 'string', 'max:50'],
            'kondisi' => ['required', 'in:baik,rusak,hilang'],
            'lokasi' => ['required', 'string', 'max:100'],
        ];
    }
}
