<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanCalculatorTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_calculate_valid_request(): void
    {
        $response = $this->post('/payment-breakdown', [
            'input_loan_amount' => 100000,
            'input_interest_rate' => 5,
            'input_loan_terms' => 30,
        ]);
        $response->assertValid();
    }

    public function test_calculate_returns_error_on_negative_loan_amount_request(): void
    {
        $response = $this->post('/payment-breakdown', [
            'input_loan_amount' => -1,
            'input_interest_rate' => -1,
            'input_loan_terms' => -1,
        ]);

        $response->assertInvalid([
            'input_loan_amount' => 'The Loan amount field must be at least 100000.',
        ]);
    }

    public function test_calculate_returns_error_on_negative_interest_rate_request(): void
    {
        $response = $this->post('/payment-breakdown', [
            'input_loan_amount' => 100000,
            'input_interest_rate' => -1,
            'input_loan_terms' => -1,
        ]);

        $response->assertInvalid([
            'input_interest_rate' => 'Min 1% interest rate is required',
        ]);
    }

    public function test_calculate_returns_error_on_negative_loan_terms_request(): void
    {
        $response = $this->post('/payment-breakdown', [
            'input_loan_amount' => 100000,
            'input_interest_rate' => 1,
            'input_loan_terms' => -1,
        ]);

        $response->assertInvalid([
            'input_loan_terms' => 'Min 1 year is required',
        ]);
    }

}
