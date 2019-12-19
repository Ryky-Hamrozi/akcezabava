<?php

namespace App\Http\Requests;

class ProcessAdvertisingRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'person' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'dsc' => 'required',
        ];
    }
}
