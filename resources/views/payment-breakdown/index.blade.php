@extends('layouts.default') @section('content')

<div class="row">
    <h1 class="text-center">Mortgage calculator - Monthly payment breakdown</h1>
    <div class="loan-form">
        <p class="fw-bold">Extra Payments</p>
        <form action="{{ route('extra-payment.store') }}" method="post">
            @csrf

            <div class="mb-3">
                <label for="month_no" class="form-label">Month #</label>
                <input
                    class="form-control"
                    type="number"
                    id="month_no"
                    name="input_month_no"
                    value="{{ old('input_month_no') }}"
                    min="1"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="extra_payment" class="form-label">Amount</label>
                <input
                    class="form-control"
                    type="number"
                    id="extra_payment"
                    name="input_extra_payment"
                    value="{{ old('input_extra_payment') }}"
                    min="1"
                    required
                />
            </div>

            <input
                type="hidden"
                name="input_loan_id"
                value="{{$loanDetails->id}}"
            />
            <input
                type="hidden"
                name="input_loan_amount"
                value="{{$loanDetails->amount}}"
            />
            <input
                type="hidden"
                name="input_interest_rate"
                value="{{$loanDetails->interest_rate}}"
            />
            <input
                type="hidden"
                name="input_loan_terms"
                value="{{$loanDetails->terms_in_years}}"
            />

            <button type="submit" class="btn btn-primary">Calculate</button>
            <a href="{{ url('/') }}" class="btn btn-success">Back</a>
        </form>

        @if ($errors->any())
        <div class="alert alert-danger my-3">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>

<div class="row my-5">
    <p class="fs-2">
        Loan amount: ₱{{number_format($loanDetails->amount, 2, '.', ',')}}
    </p>
    <p class="fs-2">
        Interest rate:
        {{number_format($loanDetails->interest_rate, 0, '.', ',')}}%
    </p>
    <p class="fs-2">Loan term: {{$loanDetails->terms_in_years}} years</p>
</div>

<div class="row my-5">
    <div class="col">
        <p class="fw-bold">Amortization</p>
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Month #</th>
                    <th scope="col">Starting Balance</th>
                    <th scope="col">Monthly Payment</th>
                    <th scope="col">Principal</th>
                    <th scope="col">Interest</th>
                    <th scope="col">Ending Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($amortizationSchedules as $amortizationSchedule)
                <tr>
                    <th scope="row">{{$amortizationSchedule->month_number}}</th>
                    <td>
                        {{number_format($amortizationSchedule->starting_balance, 2, '.', ',')}}
                    </td>
                    <td>
                        {{number_format($amortizationSchedule->monthly_payment, 2, '.', ',')}}
                    </td>
                    <td>
                        {{number_format($amortizationSchedule->principal, 2, '.', ',')}}
                    </td>
                    <td>
                        {{number_format($amortizationSchedule->interest, 2, '.', ',')}}
                    </td>
                    <td>
                        {{number_format($amortizationSchedule->ending_balance, 2, '.', ',')}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
