<?php

namespace App\Models;

use App\Models\IranRegion\County;
use App\Models\IranRegion\District;
use App\Models\IranRegion\Province;
use App\Models\IranRegion\Settlement;
use App\Models\IranRegion\Village;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Database\Factories\TerminalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terminal extends Model
{
    /** @use HasFactory<TerminalFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'province_id',
        'county_id',
        'district_id',
        'settlement_id',
        'village_id',
    ];

    protected function address(): Attribute
    {
        return Attribute::get(fn () => implode(' - ', array_filter([
            $this->province->name,
            $this->county->name,
            $this->district->name,
            $this->settlement->name,
            $this->village?->name,
        ])) ?: '-');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function settlement(): BelongsTo
    {
        return $this->belongsTo(Settlement::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function originTransitLines(): HasMany
    {
        return $this->hasMany(TransitLine::class, 'origin_terminal_id', 'id');
    }

    public function destinationTransitLines(): HasMany
    {
        return $this->hasMany(TransitLine::class, 'destination_terminal_id', 'id');
    }
}
