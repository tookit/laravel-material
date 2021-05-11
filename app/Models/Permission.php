<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as Base;

class Permission extends Base
{
    use HasFactory;

    protected $fillable = [

        'name', 'guard_name', 
        'description', 'action','verb','endpoint'
    ];
}
