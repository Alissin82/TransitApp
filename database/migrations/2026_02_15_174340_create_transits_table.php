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

            $table->unsignedBigInteger('base_price');

            $table->foreignId('origin_terminal_id')->constrained('terminals');
            $table->foreignId('destination_terminal_id')->constrained('terminals');

            $table->unsignedMediumInteger('estimated_distance_km');
            $table->unsignedSmallInteger('estimated_duration_min');

            $table->timestamps();
        });

        Schema::create('transit_services', function (Blueprint $table) {
            $table->id();

            $table->timestamp('departure_time');

            $table->foreignId('transit_line_id')->constrained('transit_lines');

            $table->string('vehicle_type'); // cast type enum
            $table->unsignedSmallInteger('capacity');
            $table->unsignedTinyInteger('occupancy_percentage')->default(0);
            $table->boolean('is_vip')->default(false);

            $table->unsignedBigInteger('computed_price')->nullable();
            $table->timestamp('price_computed_at')->nullable();

            $table->timestamps();
        });

        Schema::create('transit_service_price_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('transit_service_id')
                ->constrained('transit_services')
                ->cascadeOnDelete();

            // Price calculation snapshot
            $table->unsignedBigInteger('base_price');

            $table->integer('distance_adjustment')->default(0);
            $table->integer('duration_adjustment')->default(0);
            $table->integer('time_adjustment')->default(0);
            $table->integer('occupancy_adjustment')->default(0);
            $table->integer('vip_adjustment')->default(0);

            // Result
            $table->unsignedBigInteger('price');

            // Comparison with the previous calculated price
            $table->unsignedBigInteger('previous_price')->nullable();
            $table->integer('change_amount')->default(0);

            $table->timestamp('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index(
                ['transit_service_id', 'created_at'],
                'tsph_transit_service_id_created_at_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transit_service_price_histories');
        Schema::dropIfExists('transit_services');
        Schema::dropIfExists('transit_lines');
    }
};
