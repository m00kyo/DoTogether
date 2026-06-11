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
        $categories = [
            ['name'=> 'Sport'],
            ['name' => 'Kulinaria'],
            ['name' => 'Gry terenowe'],
            ['name' => 'Kultura'],
            ['name' => 'Przyroda'],
            ['name' => 'Sztuka'],
            ['name' => 'Rozrywka'],
        ];
        
        foreach($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']]);
        }
    }
}
