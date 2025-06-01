<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CardFormRequest;
use Illuminate\Support\Facades\Storage;

class CardController extends Controller
{
    public function index(): View
    {
    $cards = Card::with('camp')->paginate(10); // Garde la pagination existante
    $camps = \App\Models\Camp::with('cards')->where('is_active', true)->get(); // Ajoute les camps
    
    return view('cards/index', compact('cards', 'camps')); //
    }

    public function show($id): View
    {
    $card = Card::findOrFail($id);
    return view('cards/show', compact('card'));
    }
    public function create(): View
    {
        return view('cards/create');
    }

    public function edit($id): View
    {
        $card = Card::findOrFail($id);
        return view('cards/edit', ['card' => $card]);
    }

    public function store(CardFormRequest $req): RedirectResponse
    {
        $data = $req->validated();

        // Gestion de l'upload d'image dans le dossier images/cards
        if ($req->hasFile('image')) {
            $imagePath = $req->file('image')->store('images/cards', 'public');
            $data['image_path'] = $imagePath;
        }

        $card = Card::create($data);
        return redirect()->route('admin.card.show', ['id' => $card->id]);
    }

    public function update(Card $card, CardFormRequest $req)
    {
        $data = $req->validated();

        // Gestion de l'upload d'image dans le dossier images/cards
        if ($req->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($card->image_path && Storage::disk('public')->exists($card->image_path)) {
                Storage::disk('public')->delete($card->image_path);
            }

            $imagePath = $req->file('image')->store('images/cards', 'public');
            $data['image_path'] = $imagePath;
        }

        $card->update($data);

        return redirect()->route('admin.card.show', ['id' => $card->id]);
    }

    public function updateSpeed(Card $card, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $card->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Card $card)
    {

        $card->delete();

        return [
            'isSuccess' => true
        ];
    }


}