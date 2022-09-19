<?php

namespace Modules\Mall\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Mall\Models\Brand;
use Modules\Mall\Models\Category;


class BrandRequest extends FormRequest
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
            'name' => ['required', 'string', sprintf('unique_translation:%s,name', Brand::getTableName())],
            'mall_category_id' => ['integer', sprintf('exists:%s,id', Category::getTableName())],
            'url' => ['string','url','nullable'],
            'logo' => ['string','url','nullable']
        ];
    }
    
    public  function updateRule()
    {

        return [
            'name' => ['string',  sprintf('unique_translation:%s,name, %s', Brand::getTableName(), $this->id)],
            'mall_category_id' => ['integer', sprintf('exists:%s,id', Category::getTableName())],
            'url' => ['string','url','nullable'],
            'logo' => ['string','url','nullable']
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
