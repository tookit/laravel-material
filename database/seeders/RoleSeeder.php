<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed admin
        $permissions = \App\Models\Permission::all();
        $items = [
            [
                'name' => 'admin',
                'guard_name' => 'api',
            ]
        ];
        foreach($items as $item) {
            $admin = \App\Models\Role::updateOrCreate($item);
            $admin->syncPermissions($permissions);
        }

    }
}
