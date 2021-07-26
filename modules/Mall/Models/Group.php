<?php

namespace Modules\Mall\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use Modules\Mall\Database\factories\GroupFactory;

class Group extends Model
{
    use HasFactory, HasTranslations ;


    protected $table = 'mall_property_groups';

    protected $fillable = [

        'name',
    ];


    public $translatable = [

        'name',
    ];

    protected $casts = [
        
        'created_at' => 'datetime:Y-m-d H:i:s'
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


    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attachProperties()
    {

    }


    /**
     * factory 
     */
    protected static function newFactory() : GroupFactory
    {
        return GroupFactory::new();
    }



}
