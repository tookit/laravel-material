<?php

namespace Modules\Mall\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Modules\CMS\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::updateOrCreate(['name'=>'default'],[
            'name' => 'default',
            'description' => 'Default Category'
        ]);

    }
}
