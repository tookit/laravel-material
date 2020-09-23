<?php

namespace App\Http\Resources;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends  JsonResource
{


    public function __construct(Model $resource)
    {
        parent::__construct($resource);
    }

}
