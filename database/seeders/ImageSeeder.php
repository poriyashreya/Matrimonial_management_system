<?php

namespace Database\Seeders;

use App\Models\admin_images;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        admin_images::create([
            'user_id' => 1,
            'image_file_name' => time().'_logo3.png',
            'file_path' => 'storage/admin/logo/logo3.png',
            'Type_of_image' => 'logo'
        ]);
    }
}
