<?php

namespace App\Models;

use App\Enums\TransitServiceVehicleType;
use Database\Factories\TransitServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransitService extends Model
{
    /** @use HasFactory<TransitServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'departure_time',
        'transit_line_id',
        'vehicle_type',
        'capacity',
        'occupancy_percentage',
        'is_vip',
        'computed_price',
        'price_computed_at',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'vehicle_type' => TransitServiceVehicleType::class,
        'is_vip' => 'boolean',
    ];

    public function transitLine(): BelongsTo
    {
        return $this->belongsTo(TransitLine::class);
    }

    public function priceHistories(): HasMany
    {
        return $this->hasMany(TransitServicePriceHistory::class);
    }
}
