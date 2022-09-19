<?php

namespace Modules\Mall\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Mall\Models\Item;
use Modules\Mall\Models\ItemDetail;

class DetailRequest extends FormRequest
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
    public  function rules()
    {
        return [
            'body' => ['nullable', 'string'],
            'package' => ['nullable', 'string'],
            'after_service' => ['nullable', 'string']
        ];
    }


}
