<?php

namespace Modules\PMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\PMS\Models\Task;

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

    /**
     * @return mixed null|integer
     */
    protected function uniqueIdentifier()
    {
        return $this->id;
    }
    
    
    

    public  function rules()
    {
        return !$this->uniqueIdentifier() ? $this->createRule() : $this->updateRule();
    }

    public   function createRule()
    {
        return [
            'name' => ['required', sprintf('unique:%s,name',Task::getTableName())],
            'description'=>['nullable', 'string','max:256'],
            'owner'=>['nullable', 'string','max:256'],
            'status' => ['integer'],
            'project_id' => ['required','integer']


        ];
    }
    public  function updateRule()
    {
        return [
            'name' => ['required', sprintf('unique:%s,name, %s',Task::getTableName(),$this->uniqueIdentifier())],
            'description'=>['nullable', 'string','max:256'],
            'owner'=>['nullable', 'string','max:256'],
            'status' => ['integer'],
            'project_id' => ['integer']
        ];
    }
}
