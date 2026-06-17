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
        Schema::table('reminder', function (Blueprint $table) {
            $table->dropForeign('reminder_ibfk_1');
            $table->foreign('tugas_id')
                  ->references('id')
                  ->on('tugas')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reminder', function (Blueprint $table) {
            $table->dropForeign(['tugas_id']);
            $table->foreign('tugas_id', 'reminder_ibfk_1')
                  ->references('id')
                  ->on('tugas');
        });
    }
};
