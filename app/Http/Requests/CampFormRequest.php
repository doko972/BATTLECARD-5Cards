<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampFormRequest extends FormRequest
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
			'color' => $isRequired.'string',
			'description' => $isRequired.'string',
			'is_active' => $isRequired.'in:true,false|nullable'
			
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->input('is_active') ? 'true' : 'false',
			
        ]);
    }
}