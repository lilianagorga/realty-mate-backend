<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_id',
        'icon',
        'text',
        'change',
    ];

    public function price(): BelongsTo
    {
        return $this->belongsTo(Price::class);
    }

    protected $casts = [
        'icon' => 'json',
    ];
}
