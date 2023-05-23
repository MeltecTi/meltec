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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('businessUnit');
            $table->string('goal');
            $table->string('goalPercent');
            $table->string('goalDirector');
            $table->string('goalDirectorPercent');
            $table->string('goalCommercial');
            $table->string('commercialPercent');
            $table->string('q1Percent');
            $table->string('q2Percent');
            $table->string('q3Percent');
            $table->string('q4Percent');
            $table->string('q1');
            $table->string('q2');
            $table->string('q3');
            $table->string('q4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
