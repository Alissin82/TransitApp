<?php

use App\Enums\SettlementTypeEnum;
use App\Enums\VillageTypeEnum;
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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('statistical_code')->nullable();

            $table->timestamps();
        });

        Schema::create('counties', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('statistical_code')->nullable();

            $table->foreignId('province_id')->constrained('provinces');

            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('statistical_code')->nullable();

            $table->foreignId('county_id')->constrained('counties');

            $table->timestamps();
        });

        Schema::create('settlements', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->enum('type', SettlementTypeEnum::values());
            $table->string('statistical_code')->nullable();

            $table->foreignId('parent_id')->nullable()->constrained('settlements')->cascadeOnDelete();
            $table->foreignId('district_id')->constrained('districts');

            $table->timestamps();
        });

        Schema::create('villages', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->enum('type', VillageTypeEnum::values());
            $table->string('statistical_code')->nullable();

            $table->foreignId('settlement_id')->constrained('settlements');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
        Schema::dropIfExists('settlements');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('counties');
        Schema::dropIfExists('provinces');
    }
};
