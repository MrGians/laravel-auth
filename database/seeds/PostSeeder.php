<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $category_id_list = Category::pluck('id')->toArray();

        for($i = 1; $i <= 20; $i++){
            $new_post = new Post();
            $new_post->title = $faker->sentence();
            $new_post->category_id = Arr::random($category_id_list);
            $new_post->slug = Str::slug($new_post->title, '-');
            $new_post->is_published = $faker->boolean();
            $new_post->content = $faker->paragraphs('3', true);
            $new_post->save();
        }
    }
}
