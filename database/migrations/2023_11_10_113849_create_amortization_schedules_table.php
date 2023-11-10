<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('amortization_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_details_id');

            $table->integer('month_number');
            $table->decimal('starting_balance');
            $table->decimal('monthly_payment');
            $table->decimal('principal');
            $table->decimal('interest');
            $table->decimal('ending_balance');

            $table->timestamps();

            $table->foreign('loan_details_id')->references('id')->on('loan_details')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amortization_schedules');
    }
};
