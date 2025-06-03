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
     */
    public function rules(): array
    {
        $isRequired = request()->isMethod("POST") ? "required|" : "";

        return [
            'name' => 'nullable|string|max:255',
            'game_name' => 'nullable|string|max:255',  // Pour la création depuis deck-builder
            'deck_cards' => 'nullable|string',         // Pour les cartes sélectionnées
            'status' => 'nullable|string|in:waiting,in_progress,finished',
            'player1_id' => 'nullable|integer|exists:users,id',
            'player2_id' => 'nullable|integer|exists:users,id',
            'winner_id' => 'nullable|integer|exists:users,id',
            'current_turn' => 'nullable|integer|min:1|max:2',
            'turn_number' => 'nullable|integer|min:1',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
        ];
    }

    public function prepareForValidation()
    {
        // Nettoyage et préparation des données si nécessaire
        $this->merge([
            // Rien pour l'instant
        ]);
    }
}