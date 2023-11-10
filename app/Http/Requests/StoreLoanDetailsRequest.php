<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanDetailsRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    protected $redirect = '/';

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
            'input_loan_amount' => 'required|integer|min:100000',
            'input_interest_rate' => 'required|integer|min:1|max:20',
            'input_loan_terms' => 'required|integer|min:1|max:40',
        ];
    }

    public function messages(): array
    {
        return [
            'input_loan_amount.required' => 'Amount is required',
            'input_interest_rate.required' => 'Interest rate is required',
            'input_interest_rate.min' => 'Min 1% interest rate is required',
            'input_loan_terms.required' => 'Terms in years is required',
            'input_loan_terms.min' => 'Min 1 year is required',
            'input_loan_terms.max' => 'Max 40 years is required',
        ];
    }

    public function attributes(): array
    {
        return [
            'input_loan_amount' => 'Loan amount',
            'input_interest_rate' => 'Interest rate',
            'input_loan_terms' => 'Terms in years',
        ];
    }
}
