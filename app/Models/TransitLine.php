<?php

namespace App\Models;

use Database\Factories\TransitLineFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransitLine extends Model
{
    /** @use HasFactory<TransitLineFactory> */
    use HasFactory;

    protected $fillable = [
        'origin_city',
        'destination_city',
        'origin_terminal',
        'destination_terminal',
        'price',
    ];

    public function transitServices(): HasMany
    {
        return $this->hasMany(TransitService::class);
    }
}
