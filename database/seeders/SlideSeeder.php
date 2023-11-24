<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slide::create([
            'id' => 1,
            'title' => 'Title',
            'body' => 'Body',
            'status' => 'active',
            'path' => '1920x930.png',
            'user_id' => 1,
        ]);
    }
}
