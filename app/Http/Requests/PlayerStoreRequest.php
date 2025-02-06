<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'gender' => 'required|in:M,F',
            'skill' => 'nullable|integer|min:0|max:100',
            'strength' => 'nullable|integer|min:0|max:100',
            'speed' => 'nullable|integer|min:0|max:100',
            'reaction_time' => 'nullable|integer|min:0|max:100',
        ];
    }
}
