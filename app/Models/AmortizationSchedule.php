<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\LoanDetail;

class AmortizationSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['month_number', 'starting_balance', 'monthly_payment', 'principal', 'interest', 'ending_balance'];

    public function loanDetails(): BelongsTo
    {
        return $this->belongsTo(LoanDetail::class, 'loan_details_id');
    }
}
