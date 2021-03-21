<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;


trait HasStatus
{

    public static $PENDING  = 0;
    public static $PUBLISHED  = 1;

    public static function  getAvaialbeStatus()
    {
        return [
            self::$PENDING => 'PEDING',
            self::$PUBLISHED => 'PUBLISED'
        ];
    }

    public static function getStatusByName($name)
    {
        $status = array_flip(self::getAvaialbeStatus());
        return $status[$name];
    }


    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfStatus(Builder $query, $status)
    {
        return $query->where('status', $status);
    }

}