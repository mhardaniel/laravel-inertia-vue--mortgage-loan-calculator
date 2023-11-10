<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExtraPaymentRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
            'input_month_no' => 'required|integer|min:1',
            'input_extra_payment' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'input_month_no.min' => 'Min 1 is required',
            'input_extra_payment.min' => 'Min 1 is required',
        ];
    }

    public function attributes(): array
    {
        return [
            'input_month_no' => 'Month number',
            'input_extra_payment' => 'Payment amount',
        ];
    }
}
