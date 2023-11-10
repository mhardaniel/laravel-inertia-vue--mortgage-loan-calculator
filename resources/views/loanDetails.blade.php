@extends('layouts.default') @section('content')

<div class="row">
    <div class="loan-form">
        <h1>Mortgage calculator</h1>
        <form action="{{ route('payment-breakdown.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="loan_amount" class="form-label">Loan Amount</label>
                <input
                    class="form-control"
                    type="number"
                    id="loan_amount"
                    name="input_loan_amount"
                    value="{{ old('input_loan_amount') }}"
                    min="100000"
                    required
                />
            </div>
            <div class="mb-3">
                <label for="interest_rate" class="form-label"
                    >Annual Interest Rate (in percentage)</label
                >
                <input
                    class="form-control"
                    type="number"
                    id="interest_rate"
                    name="input_interest_rate"
                    value="{{ old('input_interest_rate') }}"
                    min="1"
                    max="20"
                    required
                />
            </div>

            <div class="mb-3">
                <label for="loan_terms" class="form-label"
                    >Loan Term (in years)</label
                >
                <input
                    class="form-control"
                    type="number"
                    id="loan_terms"
                    name="input_loan_terms"
                    placeholder="Min 1 year, max 40 years"
                    value="{{ old('input_loan_terms') }}"
                    min="1"
                    max="40"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary w-100">
                Calculate
            </button>
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

@stop
