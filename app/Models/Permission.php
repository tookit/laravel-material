<?php

namespace App\Models;

use App\Traits\HasAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as Base;

class Permission extends Base
{
    use HasFactory, HasAudit;

    protected $table = 'acl_permissions';

    protected $fillable = [

        'name', 'guard_name', 'prefix',
        'description', 'action','verbs','endpoint', 'type'
    ];


    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'verbs' => 'array', 
    ];


    public static function getTableName()
    {
        return (new self())->getTable();        
    }

}
