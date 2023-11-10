@extends('layouts.default') @section('content')

<div class="row">
    <h1 class="text-center">Mortgage calculator - Monthly payment breakdown</h1>
    <a
        href="{{ url('/payment-breakdown/' . $loanDetails->id) }}"
        class="btn btn-info"
        >Back</a
    >
</div>

<div class="row my-5">
    <p class="fs-2">
        Extra payment of ₱{{
            number_format($inputExtraPayment, 2, ".", ",")
        }}
        to Month #{{ $inputMonthNo }}
    </p>
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
    @if ($extraPayment && count($extraPayment) > 0)
    <div class="col">
        <p class="fw-bold">Extra Payments</p>
        <table class="table table-secondary">
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
                @foreach ($extraPayment as $amortizationSchedule)
                <tr>
                    <th scope="row">
                        {{ $amortizationSchedule["month_number"] }}
                    </th>
                    <td>
                        {{
                            number_format(
                                $amortizationSchedule["starting_balance"],
                                2,
                                ".",
                                ","
                            )
                        }}
                    </td>
                    <td>
                        {{
                            number_format(
                                $amortizationSchedule["monthly_payment"],
                                2,
                                ".",
                                ","
                            )
                        }}
                    </td>
                    <td>
                        {{
                            number_format(
                                $amortizationSchedule["principal"],
                                2,
                                ".",
                                ","
                            )
                        }}
                    </td>
                    <td>
                        {{
                            number_format(
                                $amortizationSchedule["interest"],
                                2,
                                ".",
                                ","
                            )
                        }}
                    </td>
                    <td>
                        {{
                            number_format(
                                $amortizationSchedule["ending_balance"],
                                2,
                                ".",
                                ","
                            )
                        }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@stop
