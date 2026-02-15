<?php

namespace App\Models\IranRegion;

use App\Models\Terminal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = [
        'name',
        'statistical_code',
    ];

    public function counties(): HasMany
    {
        return $this->hasMany(County::class);
    }

    public function terminals(): HasMany
    {
        return $this->hasMany(Terminal::class);
    }
}
