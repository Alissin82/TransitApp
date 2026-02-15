<?php

namespace App\Models\IranRegion;

use App\Enums\VillageTypeEnum;
use App\Models\Terminal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    protected $fillable = [
        'name',
        'statistical_code',
        'type',
        'settlement_id',
    ];

    protected $casts = [
        'type' => VillageTypeEnum::class,
    ];

    public function settlement(): BelongsTo
    {
        return $this->belongsTo(Settlement::class);
    }

    public function terminals(): HasMany
    {
        return $this->hasMany(Terminal::class);
    }
}
