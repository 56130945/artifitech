<?php

namespace App\Controllers;

class HomeController
{
    private $metaData;

    public function __construct()
    {
        $this->metaData = [
            'page' => 'home',
            'title' => "Artifitech - Leading Educational Technology Solutions Provider",
            'keywords' => "Educational Technology, EduManager, AI Solutions, IoT Solutions, Cloud Computing",
            'description' => "Artifitech is South Africa's leading provider of educational technology solutions, specializing in Learning Management Systems and enterprise solutions.",
            'og_title' => "Artifitech - Leading Educational Technology Solutions",
            'og_description' => "South Africa's leading provider of educational technology solutions",
            'og_url' => "https://artifitech.com"
        ];
    }

    public function index()
    {
        $data = [
            'meta' => $this->metaData,
            'products' => $this->getProducts(),
            'promotions' => $this->getActivePromotions()
        ];

        return view('home.index', $data);
    }

    private function getProducts()
    {
        // Get products from database or service
        return [];
    }

    private function getActivePromotions()
    {
        // Get active promotions from database or service
        return [
            'new_year' => [
                'active' => true,
                'title' => 'New Year Special!',
                'old_price' => 'R3,999/mo',
                'new_price' => 'R2,499/mo',
                'valid_until' => '2025-01-31'
            ]
        ];
    }
}
