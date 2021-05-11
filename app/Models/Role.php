<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as Base;

class Role extends Base
{
    use HasFactory;

    protected $table = 'acl_roles';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    
}
