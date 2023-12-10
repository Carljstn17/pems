<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('description');
            $table->string('uom')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_cost', 8, 2);
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->decimal('total_amount', 8, 2)->default(0.00);
            $table->string('group_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estimates');
    }
};
