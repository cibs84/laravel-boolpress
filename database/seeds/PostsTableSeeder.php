<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 15; $i++) { 
            $new_post = new Post();
            $new_post->title = Str::of($faker->words(rand(3, 5), true))->ucfirst();
            $new_post->slug = Str::slug($new_post->title, '-');
            $new_post->content = $faker->paragraphs(rand(7, 15), true);
            $new_post->save();
        }
    }
}
