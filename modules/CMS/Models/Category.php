<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Modules\CMS\Database\factories\CategoryFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Category extends Model implements Sortable
{
    use HasFactory, HasTranslations, HasSlug, HasStatus, SortableTrait;


    protected $table = 'cms_category';

    protected $fillable = [

        'name','description','body', 'status'
    ];


    public $translatable = [

        'name', 'description','body'
    ];

    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:i:s'
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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    /**
     * factory 
     */
    protected static function newFactory() : CategoryFactory
    {
        return CategoryFactory::new();
    }
}
