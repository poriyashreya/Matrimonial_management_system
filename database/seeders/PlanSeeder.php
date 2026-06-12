<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price' => 10,
            'stripe_price_id' => 'price_basic',
            'duration' => 'Monthly',
            'features' => json_encode([
                'View Profiles',
                '5 Requests Daily'
            ])
        ]);

        Plan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'price' => 25,
            'stripe_price_id' => 'price_premium',
            'duration' => 'Monthly',
            'features' => json_encode([
                'Unlimited Requests',
                'View Contact Details',
                'Premium Badge'
            ])
        ]);
    }
}
