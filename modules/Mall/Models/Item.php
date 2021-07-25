<?php

namespace Modules\Mall\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Modules\Mall\Database\factories\ItemFactory;

class Item extends Model
{
    use HasFactory, HasTranslations, HasSlug, HasStatus, HasTags;


    protected $table = 'mall_items';

    protected $fillable = [

        'name','description','promotion_title',
        'mall_category_id', 'mall_brand_id', 'flag'
    ];


    public $translatable = [

        'name', 'description', 'promotion_title'
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
     * Brand relation
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Category Relation
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function detail()
    {
        return $this->hasOne(ItemDetail::class);
    }

    /**
     * factory 
     */
    protected static function newFactory() : ItemFactory
    {
        return ItemFactory::new();
    }

}
