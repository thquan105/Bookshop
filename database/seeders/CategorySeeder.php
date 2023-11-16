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
            'parent_id' => null
        ]);
        Category::create([
            'id' => 2,
            'name' => 'Sách văn học',
            'parent_id' => 1
        ]);
        Category::create([
            'id' => 3,
            'name' => 'Sách kinh tế',
            'parent_id' => 1
        ]);
    }
}
