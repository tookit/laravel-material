<?php

namespace Module\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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
            
            'file' => ['mimes:jpg,bmp,png,webp,xml,json,txt,doc,docx,xls,xlsx','required','file','max:1024'],
            'disk' => ['nullable', 'string'],
            'directory' => ['nullable','string']
        ];

    }



  

}
