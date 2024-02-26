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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('name');
            $table->decimal('rate_per_day', 13, 4);
            $table->decimal('no_of_days', 13, 4);
            $table->decimal('ot_rate', 13, 4);
            $table->decimal('ot_hour', 13, 4)->nullable();
            $table->decimal('ot_amount', 13, 4)->nullable();
            $table->decimal('salary', 13, 4);
            $table->integer('advance_amount')->nullable();
            $table->decimal('net_amount', 13, 4);
            $table->unsignedBigInteger('entry_by');
            $table->foreign('entry_by')->references('id')->on('users');
            $table->unsignedBigInteger('batch_id');
            $table->foreign('batch_id')->references('id')->on('payroll_batches');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
