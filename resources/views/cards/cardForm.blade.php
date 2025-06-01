@extends('admin')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .card-preview {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 20px;
            color: white;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }
        .stat-badge {
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 5px 10px;
            margin: 2px;
            display: inline-block;
        }
        .type-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }
        .lieutenant { background: #f59e0b; color: white; }
        .sous_fifre { background: #6b7280; color: white; }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ isset($card) ? 'Modifier' : 'Créer' }} une carte</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($card) ? route('admin.card.update', ['card' => $card->id]) : route('admin.card.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($card))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <!-- Informations de base -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Informations générales</h5>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom de la carte</label>
                                    <input type="text" placeholder="Ex: Général Pyrion" name="name" 
                                           value="{{ old('name', isset($card) ? $card->name : '') }}" 
                                           class="form-control" id="name" required/>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="camp_id" class="form-label">Camp</label>
                                    <select name="camp_id" class="form-control" id="camp_id" required>
                                        <option value="">Choisir un camp...</option>
                                        @foreach(\App\Models\Camp::where('is_active', true)->get() as $camp)
                                            <option value="{{ $camp->id }}" 
                                                    {{ old('camp_id', isset($card) ? $card->camp_id : '') == $camp->id ? 'selected' : '' }}
                                                    style="color: {{ $camp->color }}">
                                                {{ $camp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('camp_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Type de carte</label>
                                    <select name="type" class="form-control" id="type" required>
                                        <option value="">Choisir un type...</option>
                                        <option value="lieutenant" {{ old('type', isset($card) ? $card->type : '') == 'lieutenant' ? 'selected' : '' }}>
                                            🏆 Lieutenant (Chef)
                                        </option>
                                        <option value="sous_fifre" {{ old('type', isset($card) ? $card->type : '') == 'sous_fifre' ? 'selected' : '' }}>
                                            ⚔️ Sous-fifre
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="3" 
                                              placeholder="Description de la carte...">{{ old('description', isset($card) ? $card->description : '') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image de la carte (optionnel)</label>
                                    <input type="file" accept="image/*" name="image" class="form-control" id="image"/>
                                    @if(isset($card) && $card->image_path)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($card->image_path) }}" alt="Image actuelle" style="max-width: 100px; max-height: 100px;">
                                            <small class="text-muted d-block">Image actuelle</small>
                                        </div>
                                    @endif
                                    <div id="imagePreview" class="mt-2"></div>
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Statistiques -->
                            <div class="col-md-6">
                                <h5 class="text-success mb-3">Statistiques de combat</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hp" class="form-label">Points de vie (HP)</label>
                                            <input type="number" min="1" max="50" name="hp" 
                                                   value="{{ old('hp', isset($card) ? $card->hp : '10') }}" 
                                                   class="form-control" id="hp" required/>
                                            @error('hp')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="max_hp" class="form-label">HP Maximum</label>
                                            <input type="number" min="1" max="50" name="max_hp" 
                                                   value="{{ old('max_hp', isset($card) ? $card->max_hp : '10') }}" 
                                                   class="form-control" id="max_hp" required/>
                                            @error('max_hp')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="attack" class="form-label">⚔️ Attaque</label>
                                            <input type="number" min="1" max="15" name="attack" 
                                                   value="{{ old('attack', isset($card) ? $card->attack : '5') }}" 
                                                   class="form-control" id="attack" required/>
                                            @error('attack')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="defense" class="form-label">🛡️ Défense</label>
                                            <input type="number" min="1" max="15" name="defense" 
                                                   value="{{ old('defense', isset($card) ? $card->defense : '5') }}" 
                                                   class="form-control" id="defense" required/>
                                            @error('defense')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="speed" class="form-label">⚡ Vitesse</label>
                                            <input type="number" min="1" max="10" name="speed" 
                                                   value="{{ old('speed', isset($card) ? $card->speed : '5') }}" 
                                                   class="form-control" id="speed" required/>
                                            @error('speed')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="xp" class="form-label">✨ Expérience</label>
                                            <input type="number" min="0" max="1000" name="xp" 
                                                   value="{{ old('xp', isset($card) ? $card->xp : '0') }}" 
                                                   class="form-control" id="xp" required/>
                                            @error('xp')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <small>
                                        <strong>💡 Conseils :</strong><br>
                                        • Lieutenant : 20-30 HP, stats élevées<br>
                                        • Sous-fifre : 8-20 HP, stats variées<br>
                                        • Total stats recommandé : 15-25 points
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.card.index') }}" class="btn btn-secondary">
                                ← Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($card) ? 'Mettre à jour' : 'Créer la carte' }} 🎯
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Prévisualisation -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Aperçu de la carte</h5>
                </div>
                <div class="card-body">
                    <div class="card-preview" id="cardPreview">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 id="previewName">Nom de la carte</h6>
                            <span class="type-badge" id="previewType">Type</span>
                        </div>
                        <p class="small mb-3" id="previewDescription">Description...</p>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="stat-badge">
                                    ❤️ <span id="previewHp">10</span>/<span id="previewMaxHp">10</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-badge">
                                    ✨ <span id="previewXp">0</span> XP
                                </div>
                            </div>
                        </div>
                        <div class="row text-center mt-2">
                            <div class="col-4">
                                <div class="stat-badge">
                                    ⚔️ <span id="previewAttack">5</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-badge">
                                    🛡️ <span id="previewDefense">5</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-badge">
                                    ⚡ <span id="previewSpeed">5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Synchronisation des champs max_hp et hp
    const hpInput = document.getElementById('hp');
    const maxHpInput = document.getElementById('max_hp');
    
    hpInput.addEventListener('input', function() {
        if (parseInt(this.value) > parseInt(maxHpInput.value)) {
            maxHpInput.value = this.value;
        }
        updatePreview();
    });

    maxHpInput.addEventListener('input', function() {
        if (parseInt(hpInput.value) > parseInt(this.value)) {
            hpInput.value = this.value;
        }
        updatePreview();
    });

    // Mise à jour de la prévisualisation
    function updatePreview() {
        document.getElementById('previewName').textContent = 
            document.getElementById('name').value || 'Nom de la carte';
        
        document.getElementById('previewDescription').textContent = 
            document.getElementById('description').value || 'Description...';
        
        const type = document.getElementById('type').value;
        const typeElement = document.getElementById('previewType');
        typeElement.textContent = type === 'lieutenant' ? '🏆 Lieutenant' : 
                                 type === 'sous_fifre' ? '⚔️ Sous-fifre' : 'Type';
        typeElement.className = 'type-badge ' + (type || '');

        document.getElementById('previewHp').textContent = 
            document.getElementById('hp').value || '10';
        document.getElementById('previewMaxHp').textContent = 
            document.getElementById('max_hp').value || '10';
        document.getElementById('previewXp').textContent = 
            document.getElementById('xp').value || '0';
        document.getElementById('previewAttack').textContent = 
            document.getElementById('attack').value || '5';
        document.getElementById('previewDefense').textContent = 
            document.getElementById('defense').value || '5';
        document.getElementById('previewSpeed').textContent = 
            document.getElementById('speed').value || '5';
    }

    // Écouter tous les changements
    document.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    // Prévisualisation d'image
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Prévisualisation" style="max-width: 100px; max-height: 100px; border-radius: 8px;">
                    <small class="text-muted d-block">Prévisualisation</small>
                `;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });

    // Initialiser la prévisualisation
    updatePreview();
});
</script>

@endsection