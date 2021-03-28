<?php

namespace Modules\Task\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Task\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Project::updateOrCreate(['name' => 'chat server','description' => 'A simple websocket server for chatting']);
        Project::updateOrCreate(['name' => 'Larave MDC','description' => 'A simple integration with laravel']);
    }
}
