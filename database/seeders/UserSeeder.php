<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Shreya poria',
            'email' => 'shreya.p@techxperts.co.in',
            'password' => Hash::make('Shreya@123'),
            'role' => 'admin',
        ]);
    }
}
