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
            $table->float('rate_per_day', 8, 2);
            $table->integer('no_of_days');
            $table->float('ot_rate', 2, 2);
            $table->integer('ot_hour');
            $table->float('ot_amount', 8, 2);
            $table->float('salary', 8, 2);
            $table->integer('advance_amount')->nullable();
            $table->float('net_amount', 8, 2);
            $table->float('total_amount', 8, 2);
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
