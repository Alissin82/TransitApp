<?php

namespace App\Models;

use Database\Factories\TransitServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransitService extends Model
{
    /** @use HasFactory<TransitServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'departure_time',
        'transit_line_id',
    ];

    public function transitLine(): BelongsTo
    {
        return $this->belongsTo(TransitLine::class);
    }
}
