<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $admin = \App\Models\Role::findByName('admin');
        $user = \App\Models\User::updateOrCreate(
            ['email' => Config::get('admin.email')],
            [
                'username' => Config::get('admin.username'),
                'password' => (Config::get('admin.password')),
                'email' => Config::get('admin.email'),
                'phone' => Config::get('admin.mobile'),
                'flag'=> \App\Models\User::FLAG_ACTIVE,
                'gender' => 'male',
                'avatar' => 'https://avatars.githubusercontent.com/u/149564?s=60&v=4'
            ]
        );
        $user->assignRole($admin);
        if(Config::get('app.env') !== 'production'){

            \App\Models\User::factory()->times(25)->create();
        }
    }
}
