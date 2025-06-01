<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CampFormRequest;
use Illuminate\Support\Facades\Storage;

class CampController extends Controller
{
    public function index(): View
    {
        $camps = Camp::orderBy('created_at', 'desc')->paginate(5);
        return view('camps/index', ['camps' => $camps]);
    }

    public function show($id): View
    {
        $camp = Camp::findOrFail($id);

        return view('camps/show', ['camp' => $camp]);
    }
    public function create(): View
    {
        return view('camps/create');
    }

    public function edit($id): View
    {
        $camp = Camp::findOrFail($id);
        return view('camps/edit', ['camp' => $camp]);
    }

    public function store(CampFormRequest $req): RedirectResponse
    {
        $data = $req->validated();

        // Convertir is_active en booléen
        if (isset($data['is_active'])) {
            $data['is_active'] = $data['is_active'] === 'true' || $data['is_active'] === '1' || $data['is_active'] === 1;
        } else {
            $data['is_active'] = false; // Valeur par défaut si pas coché
        }

        $camp = Camp::create($data);
        return redirect()->route('admin.camp.show', ['id' => $camp->id]);
    }

    public function update(Camp $camp, CampFormRequest $req)
    {
        $data = $req->validated();

        // Convertir is_active en booléen
        if (isset($data['is_active'])) {
            $data['is_active'] = $data['is_active'] === 'true' || $data['is_active'] === '1' || $data['is_active'] === 1;
        } else {
            $data['is_active'] = false;
        }

        $camp->update($data);

        return redirect()->route('admin.camp.show', ['id' => $camp->id]);
    }

    public function updateSpeed(Camp $camp, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $camp->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Camp $camp)
    {

        $camp->delete();

        return [
            'isSuccess' => true
        ];
    }


}