<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\AmortizationSchedule;

class LoanDetail extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'interest_rate', 'terms_in_years'];

    public function amortizationSchedules(): HasMany
    {
        return $this->hasMany(AmortizationSchedule::class, 'loan_details_id');
    }
}
