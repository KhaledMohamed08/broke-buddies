<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'shop_id' => '',
            'user_id' => '',
            'ends_at' => '',
            'notes' => '',
            'fees' => '',
            'fees.*.fee_name' => 'string|max:255',
            'fees.*.fee_price' => 'numeric|min:0',
        ];
    }
}
