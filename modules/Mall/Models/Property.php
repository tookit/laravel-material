<?php

namespace Modules\Mall\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Modules\Mall\Database\factories\BrandFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Property extends Model
{
    use HasFactory, HasTranslations, HasSlug;


    protected $table = 'mall_properties';

    protected $fillable = [

        'name',
    ];


    public $translatable = [

        'name',
    ];

    protected $casts = [
        
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static function getTableName()
    {
        return (new self())->getTable();        
    }
        
    

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {

    }

    /**
     * 
     */

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');        
    }

    /**
     * factory 
     */
    protected static function newFactory() : BrandFactory
    {
        return BrandFactory::new();
    }



}
