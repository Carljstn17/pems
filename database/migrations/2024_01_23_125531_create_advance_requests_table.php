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
        Schema::create('advance_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_by');
            $table->foreign('entry_by')->references('id')->on('users');
            $table->integer('amount');
            $table->string('text');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advance_requests');
    }
};
