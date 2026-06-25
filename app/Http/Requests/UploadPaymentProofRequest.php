<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadPaymentProofRequest extends FormRequest
{
    public function authorize(): bool
    {
        $order = $this->route('order');
        return $order && $order->buyer_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'payment_proof' => ['required', 'file', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.mimes' => 'Format file harus JPEG atau PNG.',
            'payment_proof.max' => 'Ukuran file maksimal 2MB.',
        ];
    }
}
