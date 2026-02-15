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
        Schema::create('transit_lines', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('price');

            $table->foreignId('origin_terminal_id')->constrained('terminals');
            $table->foreignId('destination_terminal_id')->constrained('terminals');

            $table->timestamps();
        });

        Schema::create('transit_services', function (Blueprint $table) {
            $table->id();

            $table->timestamp('departure_time');

            $table->foreignId('transit_line_id')->constrained('transit_lines');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transit_services');
        Schema::dropIfExists('transit_lines');
    }
};
