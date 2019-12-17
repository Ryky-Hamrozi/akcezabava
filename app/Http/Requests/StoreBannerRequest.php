<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'required|mimes:jpeg,svg,png|max:128',
        ];
    }

    public function attributes()
    {
        $attributes =  parent::attributes();
        $attributes['image'] = 'Pole obrázek';

        return $attributes;
    }

    public function messages()
    {
        $messages =  parent::messages();
        $messages['image.max'] = 'Obrázek musí být menší než :max kB';

        return $messages;
    }

}
