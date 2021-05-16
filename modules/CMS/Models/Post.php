<?php

namespace Modules\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Modules\CMS\Database\factories\PostFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use HasFactory, HasTranslations, HasSlug, HasStatus, HasTags;


    protected $table = 'cms_posts';

    protected $fillable = [

        'name','description','body','category_id', 'status'
    ];


    public $translatable = [

        'name', 'description','body'
    ];

    protected $casts = [
        
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static function getTableName()
    {
        return (new self())->getTable();        
    }
        
    

    public static function getTagClassName(): string
    {
        return Tag::class;
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
