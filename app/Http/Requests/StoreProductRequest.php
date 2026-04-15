<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'            => 'required|string|max:255',
            'barcode'            => 'required|numeric',
            'total_price'     => 'required|numeric',
            'total_quantity'  => 'required|integer',
            'price_unit'      => 'required|numeric',
            'date_of_pay'     => 'required|date',
            'emp_name'        => 'required|exists:employees,id', // التحقق من وجود الجندي في الـ database
            'supplier_id'    => 'required|exists:suppliers,id', // ← مهم جداً
            
        ];
    }
}
