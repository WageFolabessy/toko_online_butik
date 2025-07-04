<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|min:0',
            'weight' => 'required|integer|min:1',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants' => 'required|array',
            'variants.name' => 'required|array',
            'variants.stock' => 'required|array',
            'variants.name.*' => 'required|string',
            'variants.stock.*' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'category_id.required' => 'Anda harus memilih kategori produk.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.integer' => 'Harga harus berupa angka.',
            'weight.required' => 'Berat produk wajib diisi (dalam gram).',
            'weight.min' => 'Berat produk minimal adalah 1 gram.',

            'images.*.image' => 'File yang diunggah harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max' => 'Ukuran maksimal setiap gambar adalah 2MB.',

            'variants.name.*.required' => 'Nama varian wajib diisi.',
            'variants.stock.*.required' => 'Stok untuk setiap varian wajib diisi.',
            'variants.stock.*.integer' => 'Stok harus berupa angka.',
            'variants.stock.*.min' => 'Stok tidak boleh kurang dari 0.',
        ];
    }
    
}