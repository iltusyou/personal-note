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
        Schema::create('training_volumns', function (Blueprint $table) {
            $table->id();
            $table->integer('load');
            $table->integer('repetitions');
            $table->foreignId('weight_training_record_id')
            ->on('weight_training_records')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_volumns');
    }
};
