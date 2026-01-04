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
        Schema::create('reimbursements', function (Blueprint $table) {
            $table->id();
            $table->string('reimbursement_number')->unique()->nullable();
            $table->date('reimbursement_date');
            $table->string('employee_name');
            $table->string('employee_division');
            $table->string('employee_position');
            $table->json('items'); // No, Keterangan, Tanggal, Nominal
            $table->bigInteger('total_amount', false, true);
            $table->string('employee_account_number');
            $table->string('employee_account_name');
            $table->string('employee_bank_name');
            $table->string('employee_signature_path');
            $table->string('employee_phone_number', 25);
            $table->json('proof_path')->nullable(); // Array of file paths
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('notes')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursements');
    }
};
