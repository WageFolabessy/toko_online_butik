<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'courier' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'tracking_number' => 'nullable|string|max:255',
            'status' => [
                'required',
                'string',
                Rule::in(['pending', 'shipped', 'delivered']),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'courier.required' => 'Nama kurir wajib diisi.',
            'service.required' => 'Jenis layanan wajib diisi.',
            'tracking_number.string' => 'Nomor resi harus berupa teks.',
            'status.required' => 'Status pengiriman wajib dipilih.',
            'status.in' => 'Status pengiriman tidak valid.',
        ];
    }
}
