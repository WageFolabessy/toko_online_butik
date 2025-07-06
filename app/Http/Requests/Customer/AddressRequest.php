<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'full_address' => 'required|string',
            'postal_code' => 'required|string|max:10|digits:5',
        ];
    }

    public function messages(): array
    {
        return [
            'label.required' => 'Label alamat wajib diisi (Contoh: Rumah, Kantor).',
            'recipient_name.required' => 'Nama penerima wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'full_address.required' => 'Alamat lengkap wajib diisi.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'postal_code.digits' => 'Kode pos harus terdiri dari 5 digit angka.',
        ];
    }
}
