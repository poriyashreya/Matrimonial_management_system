<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CountryStateCitySeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            'India' => [
                'Gujarat' => ['Ahmedabad', 'Surat', 'Vadodara'],
                'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur'],
                'Rajasthan' => ['Jaipur', 'Udaipur']
            ],

            'USA' => [
                'California' => ['Los Angeles', 'San Francisco'],
                'Texas' => ['Houston', 'Dallas'],
                'New York' => ['New York City', 'Buffalo']
            ],

            'Canada' => [
                'Ontario' => ['Toronto', 'Ottawa'],
                'British Columbia' => ['Vancouver', 'Victoria']
            ],

            'UK' => [
                'England' => ['London', 'Manchester'],
                'Scotland' => ['Edinburgh', 'Glasgow']
            ],

            'Australia' => [
                'New South Wales' => ['Sydney', 'Newcastle'],
                'Victoria' => ['Melbourne', 'Geelong']
            ],

            'Germany' => [
                'Bavaria' => ['Munich', 'Nuremberg'],
                'Berlin' => ['Berlin']
            ],

            'France' => [
                'Île-de-France' => ['Paris'],
                'Provence-Alpes-Côte d\'Azur' => ['Marseille', 'Nice']
            ],

            'Japan' => [
                'Tokyo' => ['Shinjuku', 'Shibuya'],
                'Osaka' => ['Osaka', 'Sakai']
            ],

            'China' => [
                'Beijing' => ['Beijing'],
                'Shanghai' => ['Shanghai']
            ],

            'Brazil' => [
                'São Paulo' => ['São Paulo'],
                'Rio de Janeiro' => ['Rio de Janeiro']
            ],

            'South Africa' => [
                'Gauteng' => ['Johannesburg', 'Pretoria'],
                'Western Cape' => ['Cape Town']
            ],

            'UAE' => [
                'Dubai' => ['Dubai'],
                'Abu Dhabi' => ['Abu Dhabi']
            ]

        ];

        foreach ($data as $countryName => $states) {

            $country = Country::create([
                'name' => $countryName
            ]);

            foreach ($states as $stateName => $cities) {

                $state = State::create([
                    'country_id' => $country->id,
                    'name' => $stateName
                ]);

                foreach ($cities as $cityName) {
                    City::create([
                        'state_id' => $state->id,
                        'name' => $cityName
                    ]);
                }
            }
        }
    }
}

