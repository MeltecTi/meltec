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
        Schema::create('success_cases', function (Blueprint $table) {
            $table->id();
            $table->string('caseneed');
            $table->text('caseneedContent');
            $table->string('caseSolution');
            $table->text('caseSolutionContent');
            $table->string('caseResult');
            $table->text('caseResultContent');
            $table->unsignedBigInteger('mark_id');
            $table->timestamps();
            $table->foreign('mark_id')->references('id')->on('marks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('success_cases');
    }
};
