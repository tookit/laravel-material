<?php

namespace Modules\Task\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Project extends Model implements Sortable
{
    use HasFactory, HasTranslations, HasSlug, HasStatus, SortableTrait;


    protected $table = 'task_project';

    protected $fillable = [

        'name','description', 'status'
    ];


    public $translatable = [

        'name', 'description',
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

    public function task()
    {
        return $this->hasMany(Task::class);
    }

}
