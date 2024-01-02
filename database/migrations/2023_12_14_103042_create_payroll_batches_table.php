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
        Schema::create('payroll_batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->decimal('total_salary', 13, 4);
            $table->decimal('total_advance', 13, 4);
            $table->decimal('total_net', 13, 4);
            $table->decimal('ot_rate', 13, 4);
            $table->unsignedBigInteger('entry_by');
            $table->foreign('entry_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_batches');
    }
};
