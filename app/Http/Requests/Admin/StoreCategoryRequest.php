<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:categories,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique'   => 'Nama kategori ini sudah ada. Silakan gunakan nama lain.',
        ];
    }
}
