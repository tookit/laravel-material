<?php

namespace App\Http\Requests\Acl;

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
            'email' => ['required','email','unique:users,email'],
            'mobile' => ['required','unique:users,mobile'],
            'active' => ['boolean'],
            'password' => ['required','confirmed'],
        ];

    }

    protected function updateRules()
    {
        return [
            'username' => ['unique:users,username,'.$this->uniqueIdentifier()],
            'email' => ['email','unique:users,email,'.$this->uniqueIdentifier()],
            'mobile' => ['unique:users,mobile,'.$this->uniqueIdentifier()],
            'active' => ['boolean'],
            'avatar' => ['string','nullable'],
            'password' => ['required','confirmed'],
        ];
    }

}
