<?php
namespace App\Http\Requests;

class StoreEventRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $today = date('d.m.Y');
        return [
            'name' => 'required',
            'description' => 'required',
            'date-start' => "required|date_format:d.m.Y|after_or_equal:$today",
            'date-end' => "required|date_format:d.m.Y",
            'time-start' => "required|date_format:H:i",
            'time-end' => "required|date_format:H:i",
            'images.*' => 'mimes:jpeg,png,svg|max:2048',
            'person' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required',
            'user_place' => 'sometimes|required',
        ];
    }
}
