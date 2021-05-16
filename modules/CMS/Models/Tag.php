<?php

namespace Modules\CMS\Models;

use Illuminate\Support\Facades\App;
use Spatie\Tags\Tag as Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CMS\Database\factories\TagFactory;

class Tag extends Base
{
    use HasFactory;


    protected $table = 'tags';

    protected $fillable = [

        'name', 'type'
    ];

    protected $casts = [
        
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];



    public static function getTableName()
    {
        return (new self())->getTable();        
    }
        
    
    /**
     * factory 
     */
    protected static function newFactory() : TagFactory
    {
        return TagFactory::new();
    }    

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, App::getLocale());
        }
        return $attributes;
    }    
}
