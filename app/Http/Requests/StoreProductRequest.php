<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isPenjual() && $this->user()->hasStore();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1000'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['nullable', 'integer', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'images' => ['required', 'array', 'min:1', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,png,webp', 'max:2048'],
            'primary_image' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'price.min' => 'Harga minimum Rp 1.000.',
            'images.required' => 'Minimal upload 1 gambar produk.',
            'images.min' => 'Minimal upload 1 gambar produk.',
            'images.max' => 'Maksimal 5 gambar per produk.',
            'images.*.mimes' => 'Format gambar harus JPEG, PNG, atau WebP.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
            'category_id.exists' => 'Kategori tidak valid.',
        ];
    }
}
