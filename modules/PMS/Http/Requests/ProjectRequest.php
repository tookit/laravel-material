<?php

namespace Modules\PMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\PMS\Models\Project;

class ProjectRequest extends FormRequest
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

    public  function createRule()
    {
        return [
            'name' => [sprintf('unique:%s,name',Project::getTableName())],
            'description'=>['nullable', 'string','max:256'],
            'status' => ['integer']
        ];
    }
    public  function updateRule()
    {

        return [
            'name' => [sprintf('unique:%s,name, %s',Project::getTableName(),$this->uniqueIdentifier())],
            'description'=>['nullable','string'],
            'status' => ['integer']
        ];
    }
}
