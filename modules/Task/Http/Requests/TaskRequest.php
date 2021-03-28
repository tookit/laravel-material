<?php

namespace Modules\Task\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'name' => ['required','string', 'unique_translation:task,name'],
            'description'=>['nullable', 'string','max:256'],
            'owner'=>['nullable', 'string','max:256'],
            'status' => ['integer']


        ];
    }
    public  function updateRule()
    {
        return [
            'name' => ['string','unique_translation:task,name,'.$this->id],
            'description'=>['nullable', 'string','max:256'],
            'owner'=>['nullable', 'string','max:256'],
            'status' => ['integer']
        ];
    }
}
