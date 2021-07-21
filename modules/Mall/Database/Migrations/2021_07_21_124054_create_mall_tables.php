<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMallTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

 
        # categories
        Schema::create('mall_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->nestedSet();
            $table->string('slug')->unique();
            $table->json('name');
            $table->string('icon')->nullable();
            $table->json('description')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->json('meta_description')->nullable();
            $table->string('reference_url')->nullable();
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->tinyInteger('flag')->unsigned()->default(0)->comment('1:hot|2:featrued|3:Home page');
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });

        # brands
        Schema::create('mall_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->default(0);
            $table->string('slug')->unique();
            $table->json('name')->comment('Product spec name');
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mall_category_has_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_category_id');
            $table->integer('mall_brand_id');
            $table->timestamps();
        });

        # specs
        Schema::create('mall_spec_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->default(0);
            $table->json('name')->comment('Product spec name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mall_specs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->default(0);
            $table->integer('mall_spec_group_id')->default(0);
            $table->json('name')->comment('Product spec group name');
            $table->boolean('generic')->default(false)->comment('true:SKU|false:SPU');
            $table->boolean('is_numeric')->default(false);
            $table->boolean('searchable')->default(false);
            $table->string('unit')->nullable();
            $table->json('segments')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

       # product items
       Schema::create('mall_spus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->default(0);
            $table->integer('mall_brand_id')->default(0);
            $table->string('slug')->unique();
            $table->json('name')->comment('Product name');
            $table->json('speical_title')->nullable()->comment('Title for promotion');
            $table->tinyInteger('flag')->unsigned()->default(0)->comment('1:hot|2:featrued|3:Home page');
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mall_category_has_spus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_category_id')->default(0);
            $table->integer('mall_spu_id')->default(0);
        });

        Schema::create('mall_spu_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_spu_id')->default(0);
            $table->json('description')->comment('Product description');
            $table->json('generic_specs')->nullable()->comment('Generic specs|[<{spec_id:spec_value}>]');
            $table->json('special_specs')->nullable()->comment('Speical specs|[<{spec_id:spec_value}>]');
            $table->json('packing')->nullable();
            $table->json('after_service')->nullable();
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('mall_skus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_spu_id')->default(0);
            $table->json('title')->comment('Product title');
            $table->integer('stock')->default(0);
            $table->bigint('price')->default(0);
            $table->string('indexes')->nullable();
            $table->json('own_specs')->nullable()->comment('Speical specs|{spec_id:[spec_value...]}');
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
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
        Schema::dropIfExists('mall_categories');
        Schema::dropIfExists('mall_brands');
        Schema::dropIfExists('mall_category_has_brands');
        Schema::dropIfExists('mall_spec_groups');
        Schema::dropIfExists('mall_specs');
        Schema::dropIfExists('mall_spus');
        Schema::dropIfExists('mall_category_has_spus');
        Schema::dropIfExists('mall_spu_details');
        Schema::dropIfExists('mall_skus');
    }
}
