<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $new_user = new User;
        $new_user->name = 'Gianluca';
        $new_user->email = 'gianlumura97@gmail.com';
        $new_user->password = bcrypt('password');
        $new_user->save();

        for($i=1; $i <= 10; $i++){
            $new_user = new User;
            $new_user->name = $faker->userName();
            $new_user->email = $faker->email();
            $new_user->password = bcrypt('password');
            $new_user->save();
        }
    }
}
