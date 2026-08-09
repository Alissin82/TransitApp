<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransitServicePriceHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'transit_service_id',

        'base_price',
        'distance_adjustment',
        'duration_adjustment',
        'time_adjustment',
        'occupancy_adjustment',
        'vip_adjustment',

        'price',
        'previous_price',
        'change_amount',

        'created_at',
    ];

    protected $casts = [
        'base_price' => 'integer',
        'distance_adjustment' => 'integer',
        'duration_adjustment' => 'integer',
        'time_adjustment' => 'integer',
        'occupancy_adjustment' => 'integer',
        'vip_adjustment' => 'integer',
        'price' => 'integer',
        'previous_price' => 'integer',
        'change_amount' => 'integer',
        'created_at' => 'datetime',
    ];

    public function transitService(): BelongsTo
    {
        return $this->belongsTo(TransitService::class);
    }
}
