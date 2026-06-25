<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isPenjual() || $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in(array_keys(Order::STATUS_LABELS)),
            ],
        ];
    }
}
