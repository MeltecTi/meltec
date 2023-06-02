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
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->unsignedBigInteger('meetingRoom_id');
            $table->string('personal_quantity');
            $table->foreign('meetingRoom_id')->references('id')->on('meeting_rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropColumn('meetingRoom_id');
            $table->dropColumn('personal_quantity');
        });
    }
};
