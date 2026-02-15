<?php

namespace App\Models;

use Database\Factories\TransitLineFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransitLine extends Model
{
    /** @use HasFactory<TransitLineFactory> */
    use HasFactory;

    protected $fillable = [
        'price',
        'origin_terminal_id',
        'destination_terminal_id',
    ];

    public function originTerminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class, 'origin_terminal_id');
    }

    public function destinationTerminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class, 'destination_terminal_id');
    }

    public function transitServices(): HasMany
    {
        return $this->hasMany(TransitService::class);
    }
}
