<?php

namespace App\Http\Requests\Acl;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class RoleRequest extends FormRequest
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
            'name' => ['required',sprintf('unique:%s,name', Role::getTableName())],
        ];

    }

    protected function updateRules()
    {
        return [
            'guard_name' => ['string'],
            'name' => ['string', sprintf('unique:%s,name,%s', Role::getTableName(), $this->uniqueIdentifier())],
        ];
    }

}
