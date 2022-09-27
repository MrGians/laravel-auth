<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Post;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 1; $i <= 10; $i++){
            $new_post = new Post();
            $new_post->title = $faker->sentence();
            $new_post->slug = Str::slug($new_post->title, '-');
            $new_post->content = $faker->paragraphs('3', true);
            $new_post->save();
        }
    }
}
