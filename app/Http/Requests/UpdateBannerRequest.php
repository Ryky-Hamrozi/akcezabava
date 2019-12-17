<?php

namespace App\Http\Requests;


class UpdateBannerRequest extends StoreBannerRequest
{
    public function rules()
    {
        $rules =  parent::rules();
        $rules['image'] = 'mimes:jpeg,svg,png|max:128';

        return $rules;
    }
}
