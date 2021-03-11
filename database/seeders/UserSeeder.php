<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Config;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed admin
        User::updateOrCreate(
            [
                'username' => Config::get('admin.username'),
                'password' => (Config::get('admin.password')),
                'email' => Config::get('admin.email'),
                'phone' => Config::get('admin.mobile'),
                'flag'=> User::FLAG_ACTIVE,
                'gender' => 'male',
                'avatar' => 'https://avatars.githubusercontent.com/u/149564?s=60&v=4'
            ]
        );
        if(Config::get('app.env') !== 'production'){

            User::factory()->times(25)->create();
        }
    }
}
