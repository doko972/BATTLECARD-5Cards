<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameFormRequest extends FormRequest
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
            'name' => $isRequired.'string',
			'status' => $isRequired.'string',
			'player1_id' => $isRequired.'string',
			'player2_id' => $isRequired.'string',
			'winner_id' => $isRequired.'string',
			'current_turn' => $isRequired.'string',
			'turn_number' => $isRequired.'string',
			'started_at' => $isRequired.'string',
			'finished_at' => $isRequired.'string',
			'player1_id' => $isRequired.'string',
			'player2_id' => $isRequired.'string',
			'winner_id' => $isRequired.'string'
			
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            
        ]);
    }
}