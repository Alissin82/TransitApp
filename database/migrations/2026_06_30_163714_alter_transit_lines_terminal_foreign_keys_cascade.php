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
        Schema::table('transit_lines', function (Blueprint $table) {
            $table->dropForeign(['origin_terminal_id']);
            $table->dropForeign(['destination_terminal_id']);
            $table->foreign('origin_terminal_id')->references('id')->on('terminals')->onDelete('cascade');
            $table->foreign('destination_terminal_id')->references('id')->on('terminals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transit_lines', function (Blueprint $table) {
            $table->dropForeign(['origin_terminal_id']);
            $table->dropForeign(['destination_terminal_id']);
            $table->foreign('origin_terminal_id')->references('id')->on('terminals');
            $table->foreign('destination_terminal_id')->references('id')->on('terminals');
        });
    }
};
