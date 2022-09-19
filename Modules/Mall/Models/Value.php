<?php

namespace Modules\Mall\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use Modules\Mall\Database\factories\ValueFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Property value
 */
class Value extends Model
{
    use HasFactory, HasTranslations, HasSlug;


    protected $table = 'mall_property_values';

    protected $fillable = [

        'value', 'mall_property_id',
    ];

    protected $casts = [
        
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];


    public $translatable = [

        'value',
    ];

    public $appends = [];



    public function getKeyAttribute()
    {
        return $this->property->name;
    }


    public static function getTableName()
    {
        return (new self())->getTable();        
    }
        
    /**
     * 
     */

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['mall_property_id','value'])
            ->saveSlugsTo('slug');        
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {

    }

    public function propertyName()
    {
        return $this->belongsTo(Property::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
    
    
    /**
     * factory 
     */
    protected static function newFactory() : ValueFactory
    {
        return ValueFactory::new();
    }


}
