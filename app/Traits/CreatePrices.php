<?php

namespace App\Traits;

use App\Models\Price;
use App\Models\PriceFeature;

trait CreatePrices
{
    public function createPrices(): void
    {
        $prices = config('price_data');

        foreach ($prices as $priceData) {
            $features = $priceData['features'];
            unset($priceData['features']);

            $price = Price::create($priceData);

            foreach ($features as $featureData) {
                $featureData['price_id'] = $price->id;
                PriceFeature::create($featureData);
            }
        }
    }
}
