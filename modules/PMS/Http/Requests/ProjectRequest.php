<?php

namespace Modules\PMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\PMS\Models\Project;
use BenSampo\Enum\Rules\EnumValue;
use Modules\PMS\Enum\ProjectStatus;

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
            'name' => ['required', sprintf('unique:%s,name',Project::getTableName())],
            'description'=>['nullable', 'string','max:256'],
            'status' => ['required', new EnumValue(ProjectStatus::class)]
        ];
    }
    public  function updateRule()
    {

        return [
            'name' => ['required', sprintf('unique:%s,name, %s',Project::getTableName(),$this->uniqueIdentifier())],
            'description'=>['nullable','string'],
            'status' => [new EnumValue(ProjectStatus::class)]
        ];
    }
}
