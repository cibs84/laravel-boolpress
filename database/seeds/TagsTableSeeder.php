<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Piatto veloce',
            'Vegano',
            'Vegetariano',
            'Gluten free',
            'Piatto freddo'
        ];
        
        foreach ($tags as $tag_name) {
            $new_tag = new Tag();
            $new_tag->name = $tag_name;
            $new_tag->slug = Str::slug($tag_name, '-');
            $new_tag->save();
        }
    }
}
