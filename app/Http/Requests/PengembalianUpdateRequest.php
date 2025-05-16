<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengembalianUpdateRequest extends FormRequest
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
            'peminjaman_id' => ['required', 'integer', 'exists:Peminjaman,id'],
            'tanggal_pengembalian' => ['required', 'date'],
            'kondisi_barang' => ['required', 'in:baik,rusak,hilang'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
