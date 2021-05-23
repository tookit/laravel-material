<?php

namespace App\Http\Requests\Acl;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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


    public function uniqueIdentifier() {

        return $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'firstname' => ['string', 'nullable'],
            'lastname' => ['string', 'nullable'],
            'email' => ['required','email','unique:users,email,'.$this->uniqueIdentifier()],
            'phone' => ['required','unique:users,phone,'.$this->uniqueIdentifier()],
            'avatar' => ['url','nullable'],
        ];

    }





  

}
