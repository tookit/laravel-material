<?php

namespace Modules\Mall\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Mall\Models\Category;

class CategoryRequest extends FormRequest
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
            'name' => ['required', 'string', sprintf('unique_translation:%s,name', Category::getTableName())],
            'description' => ['nullable', 'string', 'max:256'],
            'parent_id' => ['integer', 'nullable'],
            'flag' => ['integer'],
        ];
    }
    
    public  function updateRule()
    {

        return [
            'name' => ['string',  sprintf('unique_translation:%s,name, %s', Category::getTableName(), $this->id)],
            'description' => ['nullable', 'string', 'max:256'],
            'parent_id' => ['integer', 'nullable'],
            'flag' => ['integer'],
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
