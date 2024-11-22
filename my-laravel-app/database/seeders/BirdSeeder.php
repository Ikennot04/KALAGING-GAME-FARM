<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bird;

class BirdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Bird::create([
            'name' => 'Champion Cock',
            'owner' => 'John Doe',
            'image' => 'champion-cock.jpg',
        ]);
    
        Bird::create([
            'name' => 'Fighter Cock',
            'owner' => 'Jane Smith',
            'image' => 'fighter-cock.jpg',
        ]);
    }
    
}
