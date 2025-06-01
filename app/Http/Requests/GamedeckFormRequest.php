<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GamedeckFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isRequired = request()->isMethod("POST") ?"required|": "";
        return [
            //
            'game_id' => $isRequired.'string',
			'player_id' => $isRequired.'string',
			'card_id' => $isRequired.'string',
			'position' => $isRequired.'string',
			'current_hp' => $isRequired.'string',
			'is_alive' => $isRequired.'in:true,false|nullable',
			'game_id' => $isRequired.'string',
			'player_id' => $isRequired.'string',
			'card_id' => $isRequired.'string'
			
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'is_alive' => $this->input('is_alive') ? 'true' : 'false',
			
        ]);
    }
}