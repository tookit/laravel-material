<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Modules\CMS\Database\factories\PostFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasFactory, HasTranslations, HasSlug, HasStatus;


    protected $table = 'cms_post';

    protected $fillable = [

        'name','description','body','category_id', 'status'
    ];


    public $translatable = [

        'name', 'description','body'
    ];

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
     * relation 
     * 
     */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * factory 
     */
    protected static function newFactory() : PostFactory
    {
        return PostFactory::new();
    }
}
