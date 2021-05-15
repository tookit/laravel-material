<?php

namespace App\Http\Requests\Acl;

use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
    public function rules()
    {

        return ($this->uniqueIdentifier()) ? $this->updateRules() : $this->createRules();

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



    protected function createRules()
    {
        return [
            'guard_name' => ['string'],
            'description' => ['string'],
            'verbs' => ['array', 'nullable'],
            'name' => ['required',sprintf('unique:%s,name',Permission::getTableName())],
        ];

    }

    protected function updateRules()
    {
        return [
            'guard_name' => ['string'],
            'description' => ['string'],
            'verbs' => ['array','nullable'],
            'name' => [sprintf('unique:%s,name, %s',Permission::getTableName(),$this->uniqueIdentifier())],
        ];
    }

}
