<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Post;
use App\User;
use App\Models\Category;
use App\Models\Tag;
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
        $user_id_list = User::pluck('id')->toArray();
        $tag_id_list = Tag::pluck('id')->toArray();

        for($i = 1; $i <= 20; $i++){
            $new_post = new Post();
            $new_post->title = $faker->sentence();
            $new_post->user_id = Arr::random($user_id_list);
            $new_post->category_id = Arr::random($category_id_list);
            $new_post->slug = Str::slug($new_post->title, '-');
            $new_post->thumb = $faker->imageUrl();
            $new_post->is_published = $faker->boolean();
            $new_post->content = $faker->paragraphs('3', true);
            $new_post->save();


            $new_post_tags = [];
            
            foreach($tag_id_list as $tag_id){
                if($faker->boolean()) $new_post_tags[] = $tag_id; 
            }

            $new_post->tags()->attach($new_post_tags);
        }
    }
}
