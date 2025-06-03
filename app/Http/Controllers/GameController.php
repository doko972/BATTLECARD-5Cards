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

        // Décoder les cartes du deck (le 2e paramètre doit être true, pas 1)
        $deckCards = json_decode($data['deck_cards'], true);

        // Vérifier que les cartes ont été décodées correctement
        if (!$deckCards || count($deckCards) !== 5) {
            return redirect()->back()->with('error', 'Erreur lors de la création du deck.');
        }

        // Créer les GameDecks pour le joueur 1
        foreach ($deckCards as $position => $cardId) {
            $card = Card::findOrFail($cardId);
            GameDeck::create([
                'game_id' => $game->id,
                'player_id' => auth()->id(),
                'card_id' => (int) $cardId,  // S'assurer que c'est un entier
                'position' => $position,
                'current_hp' => (int) $card->max_hp,  // S'assurer que c'est un entier
                'is_alive' => 1  // Utiliser 1 au lieu de true
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
            'isSuccess' => 1,
            'data' => $req->all()
        ];
    }

    public function delete(Game $game)
    {

        $game->delete();

        return [
            'isSuccess' => 1
        ];
    }

    public function deckBuilder(): View
    {
        $camps = \App\Models\Camp::with('cards')->where('is_active', 1)->get();
        return view('gamedecks/deck-builder', compact('camps'));
    }

    public function join($id): RedirectResponse
    {
        $game = Game::findOrFail($id);

        // Vérifications de sécurité
        if ($game->status !== 'waiting') {
            return redirect()->back()->with('error', 'Cette partie n\'est plus disponible.');
        }

        if ($game->player1_id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas rejoindre votre propre partie.');
        }

        if ($game->player2_id) {
            return redirect()->back()->with('error', 'Cette partie est déjà complète.');
        }

        // Le joueur 2 doit d'abord sélectionner son deck
        // On redirige vers une page de sélection de deck spéciale
        return redirect()->route('admin.game.select-deck', ['id' => $game->id]);
    }
    public function selectDeck($id): View|RedirectResponse
    {
        $game = Game::with(['player1'])->findOrFail($id);

        // Vérifications
        if ($game->status !== 'waiting') {
            abort(404, 'Cette partie n\'est plus disponible.');
        }

        if ($game->player1_id === auth()->id()) {
            abort(403, 'Vous ne pouvez pas rejoindre votre propre partie.');
        }

        $camps = \App\Models\Camp::with('cards')->where('is_active', 1)->get();

        return view('games/select-deck', compact('game', 'camps'));
    }

    public function joinWithDeck(Request $request, $id): RedirectResponse
    {
        $game = Game::findOrFail($id);

        // Vérifications finales
        if ($game->status !== 'waiting' || $game->player2_id) {
            return redirect()->route('admin.game.index')->with('error', 'Cette partie n\'est plus disponible.');
        }

        // Valider le deck
        $request->validate([
            'deck_cards' => 'required|json'
        ]);

        $deckCards = json_decode($request->deck_cards, 1);

        if (count($deckCards) !== 5) {
            return redirect()->back()->with('error', 'Vous devez sélectionner exactement 5 cartes.');
        }

        // Vérifier la formation (1 lieutenant + 4 sous-fifres)
        $hasLieutenant = isset($deckCards['lieutenant']);
        $sousFifresCount = count(array_filter(array_keys($deckCards), fn($key) => str_starts_with($key, 'sous_fifre')));

        if (!$hasLieutenant || $sousFifresCount !== 4) {
            return redirect()->back()->with('error', 'Formation invalide ! Vous devez avoir 1 lieutenant et 4 sous-fifres.');
        }

        // Rejoindre la partie
        $game->update([
            'player2_id' => auth()->id(),
            'status' => 'in_progress',
            'started_at' => now()
        ]);

        // Créer les GameDecks pour le joueur 2
        foreach ($deckCards as $position => $cardId) {
            $card = Card::findOrFail($cardId);
            GameDeck::create([
                'game_id' => $game->id,
                'player_id' => auth()->id(),
                'card_id' => $cardId,
                'position' => $position,
                'current_hp' => $card->max_hp,
                'is_alive' => 1
            ]);
        }

        return redirect()->route('admin.game.play', ['id' => $game->id])
            ->with('success', 'Vous avez rejoint la partie ! Que le combat commence !');
    }

    public function play($id): View|RedirectResponse
    {
        $game = Game::with(['player1', 'player2', 'gameDecks.card.camp'])->findOrFail($id);

        // Vérifier que l'utilisateur fait partie de la partie
        if ($game->player1_id !== auth()->id() && $game->player2_id !== auth()->id()) {
            abort(403, 'Vous ne participez pas à cette partie.');
        }

        if ($game->status !== 'in_progress') {
            return redirect()->route('admin.game.index')->with('error', 'Cette partie n\'est pas en cours.');
        }

        return view('games/play', compact('game'));
    }

    public function spectate($id): View|RedirectResponse
    {
        $game = Game::with(['player1', 'player2', 'gameDecks.card.camp'])->findOrFail($id);

        if ($game->status !== 'in_progress') {
            abort(404, 'Cette partie n\'est pas en cours.');
        }

        return view('games/spectate', compact('game'));
    }
}