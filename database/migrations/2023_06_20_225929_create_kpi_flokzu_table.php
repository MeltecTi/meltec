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
        Schema::create('kpi_flokzu', function (Blueprint $table) {
            $table->id();
            $table->string('form_reference_id');
            $table->dateTime('date_created');
            $table->string('name');
            $table->string('director_email');
            $table->text('observations')->nullable();
            $table->string('kpi_name');
            $table->string('period');
            $table->string('percent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_flokzu');
    }
};
