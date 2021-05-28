<?php

namespace App\Models;

use App\Traits\HasAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Plank\Mediable\Media as Base;

class Media extends Base
{
    use HasFactory;


    protected $casts = [
        
    ];


    public static function getTableName()
    {
        return (new self())->getTable();        
    }

    public static function getResources()
    {
        return static::groupBy('resource')->pluck('resource');
    }

}
