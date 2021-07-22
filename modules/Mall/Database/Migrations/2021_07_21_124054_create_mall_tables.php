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
            $table->string('reference_url')->nullable();
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->tinyInteger('flag')->unsigned()->default(0)->comment('1:hot|2:featrued|3:Home page');
            $table->timestamps();
        });

        # product items // spus
        Schema::create('mall_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_category_id')->default(0);
            $table->integer('mall_brand_id')->default(0)->comment('duplicated');
            $table->string('slug')->unique();
            $table->json('name')->comment('Product name');
            $table->json('speical_title')->nullable()->comment('Product title for promotion');
            $table->json('description')->comment('Product description');
            $table->string('alias')->nullable()->comment('Product alias name');
            $table->string('keywords')->nullable()->comment('Product keywords');
            $table->tinyInteger('flag')->unsigned()->default(0)->comment('1:hot|2:featrued|3:Home page');
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mall_item_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_spu_id')->default(0);
            $table->json('body')->nullable();
            $table->json('generic_specs')->nullable()->comment('Generic specs|[<{spec_id:spec_value}>]');
            $table->json('special_specs')->nullable()->comment('Speical specs|[<{spec_id:spec_value}>]');
            $table->json('packing')->nullable();
            $table->json('after_service')->nullable();
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mall_category_has_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_category_id')->default(0);
            $table->integer('mall_item_id')->default(0);
        });

        # brands
        Schema::create('mall_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_category_id')->default(0);
            $table->string('slug')->unique();
            $table->json('name')->comment('Product brand name');
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        # property groups
        Schema::create('mall_property_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_category_id')->default(0);
            $table->json('name')->comment('Product property group name');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mall_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_category_id')->default(0);
            $table->integer('mall_property_group_id')->default(0);
            $table->json('name')->comment('Product property name');
            $table->boolean('generic')->default(false)->comment('true:SKU|false:SPU');
            $table->boolean('is_numeric')->default(false);
            $table->boolean('searchable')->default(false);
            $table->string('unit')->nullable();
            $table->json('segments')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('mall_property_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_property_id')->default(0);
            $table->json('value')->comment('Product property value');
            $table->timestamps();
        });

        # skus
        Schema::create('mall_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku_code');
            $table->integer('mall_item_id')->default(0);
            $table->json('title')->comment('Product title');
            $table->integer('stock')->default(0);
            $table->bigint('price')->default(0);
            $table->bigint('promote_price')->default(0);
            $table->string('indexes')->nullable();
            $table->json('own_specs')->nullable()->comment('Speical specs|{spec_id:[spec_value...]}');
            $table->boolean('distributed')->default(false);
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('mall_item_has_specs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mall_item_id');
            $table->integer('mall_property_value_id')->default(0);
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
        Schema::dropIfExists('mall_items');
        Schema::dropIfExists('mall_item_details');
        Schema::dropIfExists('mall_category_has_items');
        Schema::dropIfExists('mall_brands');
        Schema::dropIfExists('mall_property_groups');
        Schema::dropIfExists('mall_properties');
        Schema::dropIfExists('mall_property_values');
        Schema::dropIfExists('mall_stocks');
        Schema::dropIfExists('mall_item_has_specs');
    }
}
