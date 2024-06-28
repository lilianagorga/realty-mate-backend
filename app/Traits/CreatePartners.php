<?php

namespace App\Traits;

use App\Models\Partner;

trait CreatePartners
{

    public function createPartners(): void
    {
        $partners = config('partners_data.partners');
        $defaultLogos = config('partners_data.default_logos');


        foreach ($partners as $partner) {
            $logo = $partner['logo'] ?? $defaultLogos[array_rand($defaultLogos)];
            Partner::updateOrCreate(
                ['name' => $partner['name']],
                array_merge($partner, ['logo' => $logo])
            );
        }
    }
}
