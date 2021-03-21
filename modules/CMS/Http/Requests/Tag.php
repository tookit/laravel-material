<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Tag extends FormRequest
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

    public  function rules()
    {
        return $this->id ? $this->createRule() : $this->updateRule();
    }

    public   function createRule()
    {
        return [
            'name' => ['required','string', 'unique_translation:tags,name'],


        ];
    }
    public  function updateRule()
    {
        return [
            'name' => ['string','unique_translation:tags,name,'.$this->id],
        ];
    }
}
