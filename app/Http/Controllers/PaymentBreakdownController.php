<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanDetail;
use App\Models\AmortizationSchedule;
use App\Http\Requests\StoreLoanDetailsRequest;
use App\Http\Requests\StoreExtraPaymentRequest;

class PaymentBreakdownController extends Controller
{
    public function extraShow(Request $request, LoanDetail $loanDetail)
    {
        $inputExtraPayment = $request->input('input_extra_payment');
        $inputMonthNo = $request->input('input_month_no');

        $inputLoanAmount = $loanDetail->amount;
        $inputInterestRate = $loanDetail->interest_rate;
        $inputLoanTerms = $loanDetail->terms_in_years;

        $loanTermsInMonths = $inputLoanTerms * 12;
        $loanInterestRate = $inputInterestRate / 100 / 12;
        $monthlyPayment = $this->_monthlyPayment($inputLoanAmount, $loanTermsInMonths, $loanInterestRate);

        $amortizationSchedules = [];
        $inputLoanAmountCopy = $inputLoanAmount;

        for ($i=1; $i <= $loanTermsInMonths; $i++) {
            $startingBalance = $inputLoanAmountCopy;
            $interest = $startingBalance * ($loanInterestRate);
            $monthlyPayment = min($startingBalance + $interest , $monthlyPayment);
            $principal = $monthlyPayment - $interest;
            $endingBalance = $i == $inputMonthNo ? $startingBalance - $principal - $inputExtraPayment : $startingBalance - $principal;
            $inputLoanAmountCopy = $endingBalance;

            array_push($amortizationSchedules, [
                'month_number' => $i,
                'starting_balance' => $startingBalance,
                'monthly_payment' => $monthlyPayment,
                'principal' => $principal,
                'interest' => $interest,
                'ending_balance' => $endingBalance,
            ]);

        }
        $loanDetail->load(['amortizationSchedules']);

        return view('extra-payment.index',[
            'loanDetails' => $loanDetail,
            'amortizationSchedules' => $loanDetail->amortizationSchedules,
            'extraPayment' => $amortizationSchedules,
            'inputExtraPayment' => $inputExtraPayment,
            'inputMonthNo' => $inputMonthNo
        ]);
    }

    public function show(LoanDetail $loanDetail)
    {
        $loanDetail->load(['amortizationSchedules']);

        return view('payment-breakdown.index',[
            'loanDetails' => $loanDetail,
            'amortizationSchedules' => $loanDetail->amortizationSchedules,
        ]);
    }

    public function store(StoreLoanDetailsRequest $request)
    {
        $inputLoanAmount = $request->input('input_loan_amount');
        $inputInterestRate = $request->input('input_interest_rate');
        $inputLoanTerms = $request->input('input_loan_terms');

        $loanDetails = new LoanDetail;
        $loanDetails->amount = $inputLoanAmount;
        $loanDetails->interest_rate = $inputInterestRate;
        $loanDetails->terms_in_years = $inputLoanTerms;
        $loanDetails->save();

        $loanTermsInMonths = $inputLoanTerms * 12;
        $loanInterestRate = $inputInterestRate / 100 / 12;
        $monthlyPayment = $this->_monthlyPayment($inputLoanAmount, $loanTermsInMonths, $loanInterestRate);

        $amortizationSchedules = [];
        $inputLoanAmountCopy = $inputLoanAmount;

        for ($i=1; $i <= $loanTermsInMonths; $i++) {
            $startingBalance = $inputLoanAmountCopy;
            $interest = $startingBalance * ($loanInterestRate);
            $monthlyPayment = min($startingBalance + $interest , $monthlyPayment);
            $principal = $monthlyPayment - $interest;
            $principal = $monthlyPayment - $interest;
            $endingBalance = $startingBalance - $principal;
            $inputLoanAmountCopy = $endingBalance;

            array_push($amortizationSchedules, new AmortizationSchedule([
                'month_number' => $i,
                'starting_balance' => $startingBalance,
                'monthly_payment' => $monthlyPayment,
                'principal' => $principal,
                'interest' => $interest,
                'ending_balance' => $endingBalance,
            ]));

        }

        $loanDetails->amortizationSchedules()->saveMany($amortizationSchedules);

        return redirect()->route('payment-breakdown.show', $loanDetails->id);
    }

    public function extraStore(StoreExtraPaymentRequest $request)
    {
        return redirect()->route('extra-payment.show', [$request->input('input_loan_id'), 'input_extra_payment' => $request->input('input_extra_payment'), 'input_month_no' => $request->input('input_month_no')]
        );
    }

    private function _monthlyPayment($p, $n, $i) {
        return $p * $i * (pow(1 + $i, $n)) / (pow(1 + $i, $n) - 1);
    }
}
