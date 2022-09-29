<?php

use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users_id_list = User::pluck('id')->toArray();

        foreach($users_id_list as $id){
            $new_user_detail = new UserDetail();
            $new_user_detail->user_id = $id;
            $new_user_detail->first_name = $faker->firstName();
            $new_user_detail->last_name = $faker->lastName();
            $new_user_detail->phone = $faker->phoneNumber();
            $new_user_detail->save();
        }
    }
}
