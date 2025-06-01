<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GameFormRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\GameDeck;
use App\Models\Card;

class GameController extends Controller
{
    public function index(): View
    {
        $games = Game::orderBy('created_at', 'desc')->paginate(5);
        return view('games/index', ['games' => $games]);
    }

    public function show($id): View
    {
        $game = Game::findOrFail($id);

        return view('games/show', ['game' => $game]);
    }
    public function create(): View
    {
        return view('games/create');
    }

    public function edit($id): View
    {
        $game = Game::findOrFail($id);
        return view('games/edit', ['game' => $game]);
    }

    public function store(GameFormRequest $req): RedirectResponse
    {
        $data = $req->validated();

        // Créer la partie
        $game = Game::create([
            'name' => $data['game_name'],
            'status' => 'waiting',
            'player1_id' => auth()->id(),
            'current_turn' => 1,
            'turn_number' => 1
        ]);

        // Créer les GameDecks avec les cartes sélectionnées
        $deckCards = json_decode($data['deck_cards'], true);

        foreach ($deckCards as $position => $cardId) {
            $card = Card::findOrFail($cardId);  // $cardId est déjà l'ID
            GameDeck::create([
                'game_id' => $game->id,
                'player_id' => auth()->id(),
                'card_id' => $cardId,
                'position' => $position,
                'current_hp' => $card->max_hp,
                'is_alive' => true
            ]);
        }

        return redirect()->route('admin.game.show', ['id' => $game->id]);
    }

    public function update(Game $game, GameFormRequest $req)
    {
        $data = $req->validated();



        $game->update($data);

        return redirect()->route('admin.game.show', ['id' => $game->id]);
    }

    public function updateSpeed(Game $game, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $game->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Game $game)
    {

        $game->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function deckBuilder(): View
    {
        $camps = \App\Models\Camp::with('cards')->where('is_active', true)->get();
        return view('gamedecks/deck-builder', compact('camps'));
    }
}