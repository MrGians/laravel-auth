<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach(config('data.tags') as $label){
            $new_tag = new Tag();
            $new_tag->label = $label;
            $new_tag->color = $faker->hexColor();
            $new_tag->save();
        }
    }
}
