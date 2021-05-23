<?php

namespace Modules\PMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Modules\PMS\Database\factories\TaskFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Task extends Model implements Sortable
{
    use HasFactory, HasTranslations, HasSlug, HasStatus, SortableTrait;


    protected $table = 'pms_tasks';

    protected $fillable = [

        'name','description', 'status', 'owner_name', 'project_id'
    ];

    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:i:s',
    ];


    public $translatable = [

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
     * relation 
     * 
     */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * factory 
     */
    protected static function newFactory() : TaskFactory
    {
        return TaskFactory::new();
    }    


}
