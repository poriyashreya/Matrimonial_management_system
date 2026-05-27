<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $india = Country::create(['name' => 'India']);
        $usa   = Country::create(['name' => 'USA']);

        // States
        $gujarat = State::create([
            'country_id' => $india->id,
            'name' => 'Gujarat'
        ]);

        $maharashtra = State::create([
            'country_id' => $india->id,
            'name' => 'Maharashtra'
        ]);

        $california = State::create([
            'country_id' => $usa->id,
            'name' => 'California'
        ]);

        // Cities
        City::insert([
            ['state_id' => $gujarat->id, 'name' => 'Ahmedabad'],
            ['state_id' => $gujarat->id, 'name' => 'Surat'],
            ['state_id' => $maharashtra->id, 'name' => 'Mumbai'],
            ['state_id' => $maharashtra->id, 'name' => 'Pune'],
            ['state_id' => $california->id, 'name' => 'Los Angeles'],
            ['state_id' => $california->id, 'name' => 'San Francisco'],
        ]);
    }
}
