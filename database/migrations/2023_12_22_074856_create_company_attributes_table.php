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
        Schema::create('company_attributes', function (Blueprint $table) {
            $table->id();
            $table->float('ot_rate')->default(1.25);
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
        Schema::dropIfExists('company_attributes');
    }
};
