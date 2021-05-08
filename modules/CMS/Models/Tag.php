<?php

namespace Modules\CMS\Models;

use Spatie\Tags\Tag as Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use Modules\CMS\Database\factories\TagFactory;

class Tag extends Base
{
    use HasFactory;


    protected $table = 'tags';

    protected $fillable = [

        'name', 'type'
    ];


    /**
     * factory 
     */
    protected static function newFactory() : TagFactory
    {
        return TagFactory::new();
    }    
}
