<?php

namespace Modules\Mall\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }


}
