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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('resume')->nullable();
            $table->text('description');
            $table->string('routeImage');
            $table->string('urlTechnical')->nullable();
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
        Schema::dropIfExists('products');
    }
};
