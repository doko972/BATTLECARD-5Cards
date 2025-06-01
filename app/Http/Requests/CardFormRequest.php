<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardFormRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'type' => 'required|in:lieutenant,sous_fifre',
            'hp' => 'required|integer|min:1|max:50',
            'max_hp' => 'required|integer|min:1|max:50',
            'xp' => 'required|integer|min:0|max:1000',
            'attack' => 'required|integer|min:1|max:15',
            'defense' => 'required|integer|min:1|max:15',
            'speed' => 'required|integer|min:1|max:10',
            'camp_id' => 'required|exists:camps,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1000',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            
        ]);
    }
}