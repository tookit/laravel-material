<?php

namespace App\Http\Requests\Acl;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserAttachRequest extends FormRequest
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

        return [
            'ids' => ['required', 'array'],
            'ids.*' => ['required','integer',sprintf('exists:%s,id',User::getTableName())],
        ];

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




}
