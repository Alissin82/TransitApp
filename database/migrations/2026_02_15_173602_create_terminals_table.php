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
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('county_id')->constrained('counties');
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('settlement_id')->constrained('settlements');
            $table->foreignId('village_id')->nullable()->constrained('villages');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminals');
    }
};
