<?php

namespace Modules\Mall\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use Modules\Mall\Database\factories\PropertyFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Property extends Model
{
    use HasFactory, HasTranslations, HasSlug;


    protected $table = 'mall_properties';

    protected $fillable = [

        'name', 'unit',
        'mall_category_id', 'mall_property_id',
        'generic', 'is_numeric','searchable'
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


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function values()
    {
        return $this->hasMany(Value::class);
    }


    /**
     * factory 
     */
    protected static function newFactory() : PropertyFactory
    {
        return PropertyFactory::new();
    }


}
