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
        $user = auth()->user();

        // Récupérer les parties par statut
        $waitingGames = Game::with(['player1', 'player2', 'gameDecks'])
            ->where('status', 'waiting')
            ->orderBy('created_at', 'desc')
            ->get();

        $inProgressGames = Game::with(['player1', 'player2', 'gameDecks'])
            ->where('status', 'in_progress')
            ->orderBy('updated_at', 'desc')
            ->get();

        $finishedGames = Game::with(['player1', 'player2', 'winner', 'gameDecks'])
            ->where('status', 'finished')
            ->orderBy('finished_at', 'desc')
            ->limit(20)
            ->get();

        $myGames = Game::with(['player1', 'player2', 'winner', 'gameDecks'])
            ->where(function ($query) use ($user) {
                $query->where('player1_id', $user->id)
                    ->orWhere('player2_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiques
        $gamesWaiting = $waitingGames->count();
        $gamesInProgress = $inProgressGames->count();
        $gamesFinished = $finishedGames->count();
        $totalGames = Game::count();

        return view('games/index', compact(
            'waitingGames',
            'inProgressGames',
            'finishedGames',
            'myGames',
            'gamesWaiting',
            'gamesInProgress',
            'gamesFinished',
            'totalGames'
        ));
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

    public function join($id): RedirectResponse
    {
        $game = Game::findOrFail($id);

        // Vérifications
        if ($game->status !== 'waiting') {
            return redirect()->back()->with('error', 'Cette partie n\'est plus disponible.');
        }

        if ($game->player1_id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas rejoindre votre propre partie.');
        }

        if ($game->player2_id) {
            return redirect()->back()->with('error', 'Cette partie est déjà complète.');
        }

        // Rejoindre la partie
        $game->update([
            'player2_id' => auth()->id(),
            'status' => 'in_progress',
            'started_at' => now()
        ]);

        return redirect()->route('admin.game.play', ['id' => $game->id])
            ->with('success', 'Vous avez rejoint la partie !');
    }

    public function play($id): View
    {
        $game = Game::with(['player1', 'player2', 'gameDecks.card'])->findOrFail($id);

        // Vérifier que l'utilisateur fait partie de la partie
        if ($game->player1_id !== auth()->id() && $game->player2_id !== auth()->id()) {
            abort(403, 'Vous ne participez pas à cette partie.');
        }

        return view('games/play', compact('game'));
    }
}