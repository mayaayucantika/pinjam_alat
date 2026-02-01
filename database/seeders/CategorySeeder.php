<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Elektronik',
            'description' => 'Alat-alat elektronik untuk keperluan presentasi dan dokumentasi',
        ]);

        Category::create([
            'name' => 'Audio Visual',
            'description' => 'Perangkat audio dan visual untuk acara',
        ]);

        Category::create([
            'name' => 'Fotografi',
            'description' => 'Peralatan fotografi dan videografi',
        ]);
    }
}
