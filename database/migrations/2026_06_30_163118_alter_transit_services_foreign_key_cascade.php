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
        Schema::table('transit_services', function (Blueprint $table) {
            $table->dropForeign(['transit_line_id']);
            $table->foreign('transit_line_id')->references('id')->on('transit_lines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transit_services', function (Blueprint $table) {
            $table->dropForeign(['transit_line_id']);
            $table->foreign('transit_line_id')->references('id')->on('transit_lines');
        });
    }
};
