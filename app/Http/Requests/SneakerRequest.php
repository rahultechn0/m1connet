<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SneakerRequest extends FormRequest
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

        // dd('Request error');
        return [
            'user_id' => 'required',
            'trans_id' => 'required',
            'name' => 'required',
            'level' => 'required',
            'color' => 'required',
            'rarity' => 'required',
            'time_type' => 'required',
            'charisma' => 'required',
        ];


    }
}
