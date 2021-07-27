<?php

namespace Modules\Mall\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Mall\Models\Property;
use Modules\Mall\Models\Category;
use Modules\Mall\Models\Group;

class PropertyRequest extends FormRequest
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
            'name' => ['required', 'string', sprintf('unique_translation:%s,name', Property::getTableName())],
            'mall_category_id' => ['integer', sprintf('exists:%s,id', Category::getTableName()), 'nullable'],
            'mall_group_id' => ['integer', sprintf('exists:%s,id', Group::getTableName()), 'nullable'],
            'values' => ['array', 'nullable'],
            'generic' => ['boolean'],
            'searchable' => ['boolean'],
            'is_numeric' => ['boolean'],
            'unit' => ['string', 'nullable'],
            'segments' => ['array', 'nullable']
        ];
    }
    
    public  function updateRule()
    {

        return [
            'name' => ['string',  sprintf('unique_translation:%s,name, %s', Property::getTableName(), $this->id)],
            'mall_category_id' => ['integer', sprintf('exists:%s,id', Category::getTableName()), 'nullable'],
            'mall_group_id' => ['integer', sprintf('exists:%s,id', Group::getTableName()), 'nullable'],
            'values' => ['array', 'nullable'],
            'generic' => ['boolean'],
            'searchable' => ['boolean'],
            'is_numeric' => ['boolean'],
            'unit' => ['string', 'nullable'],
            'segments' => ['array', 'nullable']
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
