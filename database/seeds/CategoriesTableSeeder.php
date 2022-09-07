<?php

use Illuminate\Database\Seeder;
use App\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lista nomi categorie
        $categories = [
            'Antipasti',
            'Primi',
            'Secondi',
            'Contorni',
            'Piatti unici'
        ];

        // Popolamento 
        foreach ($categories as $category_name) {
            $new_category = new Category();
            $new_category->name = $category_name;
            $new_category->slug = Str::of($category_name, '-');
            $new_category->save();
        }
    }
}
