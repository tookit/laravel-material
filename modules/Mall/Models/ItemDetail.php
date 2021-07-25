<?php

namespace Modules\Mall\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Mall\Database\factories\ItemFactory;

class ItemDetail extends Model
{
    use HasFactory, HasTranslations;


    protected $table = 'mall_item_detail';

    protected $fillable = [

        'body','package','after_service','mall_item_id'
    ];


    public $translatable = [

        'body','package','after_service',
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

    public function item()
    {
        return $this->belongsTo(Item::class);
    }


}
