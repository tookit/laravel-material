<?php

namespace Module\Media\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Plank\Mediable\Media as Base;

class Media extends Base
{
    use HasFactory;


    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        
    ];


    public $appends = [
        'basename',
        'url'

    ];

    
    public function getUrlAttribute()
    {
        return $this->getUrl();
    }

    public static function getTableName()
    {
        return (new self())->getTable();        
    }

    public static function getDirectory()
    {
        return static::groupBy('directory')->pluck('directory');
    }


}
