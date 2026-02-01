<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elektronik = Category::where('name', 'Elektronik')->first();
        $audioVisual = Category::where('name', 'Audio Visual')->first();
        $fotografi = Category::where('name', 'Fotografi')->first();

        Tool::create([
            'name' => 'Kamera DSLR Canon EOS 80D',
            'category_id' => $fotografi->id,
            'description' => 'Kamera DSLR dengan lensa 18-55mm, cocok untuk dokumentasi acara',
            'stock' => 3,
        ]);

        Tool::create([
            'name' => 'Proyektor Epson EB-X41',
            'category_id' => $audioVisual->id,
            'description' => 'Proyektor dengan resolusi XGA, brightness 3600 lumens',
            'stock' => 5,
        ]);

        Tool::create([
            'name' => 'Microphone Wireless Shure BLX14',
            'category_id' => $audioVisual->id,
            'description' => 'Microphone wireless dengan receiver, jangkauan hingga 100 meter',
            'stock' => 4,
        ]);

        Tool::create([
            'name' => 'Laptop Dell Latitude 5520',
            'category_id' => $elektronik->id,
            'description' => 'Laptop untuk presentasi dan administrasi acara',
            'stock' => 2,
        ]);

        Tool::create([
            'name' => 'Speaker Portable JBL Flip 6',
            'category_id' => $audioVisual->id,
            'description' => 'Speaker bluetooth dengan kualitas suara jernih',
            'stock' => 6,
        ]);
    }
}
