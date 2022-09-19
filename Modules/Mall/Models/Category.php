<?php

namespace Modules\Mall\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Mall\Database\factories\CategoryFactory;

class Category extends Model
{
    use HasFactory, HasTranslations, HasSlug, HasStatus, HasTags, NodeTrait;


    protected $table = 'mall_categories';

    protected $fillable = [

        'name','description','parent_id'
    ];


    public $translatable = [

        'name', 'description',
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
     *  generate slug from name
     */

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');        
    }


    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'mall_category_has_properties', 'mall_category_id', 'mall_property_id');
    }

    /**
     * @param array|\ArrayAccess
     *
     * @return \Illuminate\Suppport\Collection
     */
    public function attachProperties($names)
    {
        $collection = collect($names)->map(function($item) {
            $item = $this->attachProperty($item);
            return $item;
        });
        return $collection;
    }

    /**
     * @param string|\Modules\Mall\Models\Property $name
     *
     * @return $this
     */
    public function attachProperty($name)
    {
        $name = is_object($name) 
        ? $name 
        : Property::updateOrCreate(['name' => $name, 'mall_category_id'=>$this->id],['name' => $name, 'mall_category_id'=>$this->id]);
        $this->properties()->saveMany([$name]);
        return $name;
    }    
    /**
     * factory 
     */
    protected static function newFactory() : CategoryFactory
    {
        return CategoryFactory::new();
    }



}
