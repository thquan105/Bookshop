<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'id' => 1,
            'name' => 'Sách tham khảo',
            'slug' => '',
            'parent_id' => null
        ]);
        Category::create([
            'id' => 2,
            'name' => 'Sách văn học',
            'slug' => '',
            'parent_id' => 1
        ]);
        Category::create([
            'id' => 3,
            'name' => 'Sách kinh tế',
            'slug' => '',
            'parent_id' => 1
        ]);
    }
}
