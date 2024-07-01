<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class FooterController extends Controller
{
    public function index(): JsonResponse
    {
        $footerLinks = [
            'services' => [
                ['name' => 'Our Services', 'link' => '/our-services'],
                ['name' => 'Meet The Team', 'link' => '/meet-the-team'],
                ['name' => 'Careers at Realty Mate', 'link' => '/careers-at-realty-mate'],
                ['name' => 'Latest News & Videos', 'link' => '/latest-news']
            ],
            'about' => [
                ['name' => 'Buy', 'link' => '/buy'],
                ['name' => 'Rent', 'link' => '/rent'],
                ['name' => 'Commercial', 'link' => '/commercial'],
                ['name' => 'Mortgage Services', 'link' => '/mortgage-services'],
                ['name' => 'Property Management', 'link' => '/property-management']
            ],
            'workWithUs' => [
                ['name' => 'Off-Plan', 'link' => '/off-plan'],
                ['name' => 'Holiday Homes', 'link' => '/holiday-homes'],
                ['name' => 'Home Maintenance', 'link' => '/home-maintenance'],
                ['name' => 'Sell with us', 'link' => '/sell-with-us'],
                ['name' => 'Let with us', 'link' => '/let-with-us']
            ],
            'ourOffices' => [
                ['name' => 'Milan', 'link' => '/office/milan'],
                ['name' => 'London', 'link' => '/office/london'],
                ['name' => 'Paris', 'link' => '/office/paris'],
                ['name' => 'Berlin', 'link' => '/office/berlin'],
                ['name' => 'Barcelona', 'link' => '/office/barcelona']
            ]
        ];

        return response()->json($footerLinks);
    }
}
