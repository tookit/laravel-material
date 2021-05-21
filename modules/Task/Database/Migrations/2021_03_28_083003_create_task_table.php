<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id',false, true)->default(0)->comment('Project');
            $table->string('slug')->unique();
            $table->string('name')->comment('task name');
            $table->mediumText('description')->nullable()->comment('task short description');
            $table->unsignedInteger('sort_number');
            $table->integer('user_id')->unsigned()->default(0)->comment('Task owner id');
            $table->tinyInteger('status')->default(0)->comment('task status');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('task_projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name')->comment('project name');
            $table->mediumText('description')->nullable()->comment('project description');
            $table->text('body')->nullable();
            $table->unsignedInteger('sort_number');
            $table->integer('user_id')->unsigned()->default(0)->comment('Task owner id');
            $table->tinyInteger('status')->default(0)->comment('project status');
            $table->softDeletes();
            $table->timestamps();
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_projects');
    }
}
