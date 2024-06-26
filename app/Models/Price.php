<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Price extends Model
{
    use HasFactory;
    protected $fillable = [
        'best',
        'plan',
        'price',
        'ptext',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(PriceFeature::class);
    }
}
