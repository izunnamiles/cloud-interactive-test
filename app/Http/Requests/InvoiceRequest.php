<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.invoice_number' => 'required|numeric',
            'data.invoice_name' => 'required',
            'data.products' => 'required|array',
            'data.products.*.price' => 'required|numeric',
            'data.products.*.quantity' => 'required|numeric',
            'data.products.*.product_name' => 'required'
        ];
    }
}
