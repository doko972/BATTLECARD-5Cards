<?php

namespace App\Http\Controllers;

use App\Models\GameDeck;
use App\Models\Camp;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GamedeckFormRequest;
use Illuminate\Support\Facades\Storage;

class GamedeckController extends Controller
{
    public function index(): View
    {
        $gamedecks = GameDeck::orderBy('created_at', 'desc')->paginate(5);
        return view('gamedecks/index', ['gamedecks' => $gamedecks]);
    }

    public function show($id): View
    {
        $gamedeck = GameDeck::findOrFail($id);
        return view('gamedecks/show', ['gamedeck' => $gamedeck]);
    }
    public function create(): View
    {
        return view('gamedecks/create');
    }

    public function edit($id): View
    {
        $gamedeck = Gamedeck::findOrFail($id);
        return view('gamedecks/edit', ['gamedeck' => $gamedeck]);
    }

    public function store(GamedeckFormRequest $req): RedirectResponse
    {
        $data = $req->validated();



        $gamedeck = Gamedeck::create($data);
        return redirect()->route('admin.gamedeck.show', ['id' => $gamedeck->id]);
    }

    public function update(Gamedeck $gamedeck, GamedeckFormRequest $req)
    {
        $data = $req->validated();



        $gamedeck->update($data);

        return redirect()->route('admin.gamedeck.show', ['id' => $gamedeck->id]);
    }

    public function updateSpeed(Gamedeck $gamedeck, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $gamedeck->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Gamedeck $gamedeck)
    {

        $gamedeck->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function deckBuilder(): View
    {
        $camps = Camp::with('cards')->where('is_active', true)->get();
        return view('gamedecks/deck-builder', compact('camps'));
    }
}