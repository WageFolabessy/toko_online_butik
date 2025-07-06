<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'image' => [$this->isMethod('POST') ? 'required' : 'sometimes', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Gambar banner wajib diunggah.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.max' => 'Ukuran gambar banner terlalu besar. Maksimal 2MB.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp.',
        ];
    }
}
