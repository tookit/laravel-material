<?php

namespace Modules\Mall\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use BenSampo\Enum\Rules\EnumKey;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Mall\Enums\ProductFlag;
use Modules\Mall\Models\Item;
use Modules\Mall\Models\Category;
use Modules\Mall\Models\Brand;

class ItemRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public  function rules()
    {
        return !$this->uniqueIdentifier() ? $this->createRule() : $this->updateRule();
    }

    public   function createRule()
    {
        return [
            'name' => ['required', 'string', sprintf('unique_translation:%s,name', Item::getTableName())],
            'description' => ['nullable', 'string', 'max:256'],
            'promotion_title' => ['nullable', 'string', 'max:256'],
            'mall_category_id' => ['integer', sprintf('exists:%s,id', Category::getTableName())],
            'mall_brand_id' => ['integer', sprintf('exists:%s,id', Brand::getTableName())],
            'flag' => ['integer', new EnumValue(ProductFlag::class)],
            'tags' => ['array'],
        ];
    }
    
    public  function updateRule()
    {

        return [
            'name' => ['string',  sprintf('unique_translation:%s,name, %s', Item::getTableName(), $this->id)],
            'description' => ['nullable', 'string', 'max:256'],
            'promotion_title' => ['nullable', 'string', 'max:256'],
            'mall_category_id' => ['integer', sprintf('exists:%s,id', Category::getTableName())],
            'mall_brand_id' => ['integer', sprintf('exists:%s,id', Brand::getTableName())],
            'flag' => ['integer', new EnumValue(ProductFlag::class)],
            'tags' => ['array'],
        ];
    }

    public function attributes()
    {
        return [];
    }


    /**
     * @return mixed null|integer
     */
    protected function uniqueIdentifier()
    {
        return $this->id;
    }




}
