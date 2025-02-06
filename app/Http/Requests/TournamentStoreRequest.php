<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => 'required|in:M,F',
            'player_ids' => 'required|array|min:2',
            'player_ids.*' => 'exists:players,id',
        ];
    }
}
