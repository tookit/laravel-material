<?php

namespace App\Http\Requests\Acl;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => ['required','unique:users,username'],
            'firstname' => ['string', 'nullable'],
            'lastname' => ['string', 'nullable'],
            'email' => ['required','email','unique:users,email'],
            'phone' => ['required','unique:users,phone'],
            'active' => ['boolean'],
            'avatar' => ['url','nullable'],
            'password' => ['required'],
            'role_ids' => ['array', 'nullable'],
            'role_ids.*' => ['integer', sprintf('exists:%s,id',Role::getTableName())]
        ];

    }

    protected function updateRules()
    {
        return [
            'username' => ['unique:users,username,'.$this->uniqueIdentifier()],
            'firstname' => ['string', 'nullable'],
            'lastname' => ['string', 'nullable'],
            'email' => ['email','unique:users,email,'.$this->uniqueIdentifier()],
            'phone' => ['unique:users,phone,'.$this->uniqueIdentifier()],
            'active' => ['boolean'],
            'avatar' => ['url','nullable'],
            'role_ids' => ['array', 'nullable'],
            'role_ids.*' => ['integer', sprintf('exists:%s,id',Role::getTableName())]
//            'password' => ['required','confirmed'],
        ];
    }

}
