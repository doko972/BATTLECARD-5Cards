@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 50%, #2d1b69 100%);
            min-height: 100vh;
            color: #fff;
        }

        .saint-seiya-container {
            background: rgba(15, 15, 35, 0.95);
            border-radius: 20px;
            border: 2px solid #ffd700;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        .camp-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-radius: 15px;
            border: 1px solid rgba(255, 215, 0, 0.3);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .camp-header {
            padding: 1rem 1.5rem;
            background: linear-gradient(90deg, #ffd700 0%, #ffed4e 50%, #ffd700 100%);
            color: #000;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .camp-header.flammes {
            background: linear-gradient(90deg, #ef4444 0%, #f97316 50%, #ef4444 100%);
            color: white;
        }

        .camp-header.glace {
            background: linear-gradient(90deg, #3b82f6 0%, #06b6d4 50%, #3b82f6 100%);
            color: white;
        }

        .card-saint-seiya {
            background: linear-gradient(145deg, #1e1e2e 0%, #2a2a3e 100%);
            border: 2px solid #ffd700;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            height: 100%;
            cursor: pointer;
        }


        .card-saint-seiya:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.4);
            border-color: #ffed4e;
        }

        .card-saint-seiya::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255, 215, 0, 0.1) 50%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-saint-seiya:hover::before {
            opacity: 1;
        }

        .card-image {
            height: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .card-image .no-image {
            color: rgba(255, 255, 255, 0.7);
            font-size: 3rem;
        }

        .card-type-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .lieutenant-badge {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #000;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
        }

        .sous-fifre-badge {
            background: linear-gradient(45deg, #6b7280, #9ca3af);
            color: white;
        }

        .card-content {
            padding: 1rem;
            /* height: 200px; */
            display: flex;
            flex-direction: column;
        }

        .card-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #ffd700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .card-description {
            font-size: 0.8rem;
            color: #ccc;
            margin-bottom: 1rem;
            flex-grow: 1;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            height: 100%;
        }

        .card-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-top: auto;
        }

        .stat-item {
            background: rgba(255, 215, 0, 0.1);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 8px;
            padding: 0.25rem;
            text-align: center;
            font-size: 0.75rem;
        }

        .stat-value {
            display: block;
            font-weight: bold;
            color: #ffd700;
            font-size: 0.9rem;
        }

        .stat-label {
            color: #ccc;
            font-size: 0.7rem;
        }

        .hp-bar {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            height: 6px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .hp-fill {
            height: 100%;
            background: linear-gradient(90deg, #ef4444 0%, #f97316 50%, #22c55e 100%);
            transition: width 0.3s ease;
        }

        .card-actions {
            position: absolute;
            bottom: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-saint-seiya:hover .card-actions {
            opacity: 1;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .btn-edit {
            background: #22c55e;
            color: white;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .cosmic-energy {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(255, 215, 0, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-saint-seiya:hover .cosmic-energy {
            opacity: 1;
        }

        .lieutenant-card {
            border-color: #ffd700;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
        }

        .lieutenant-card:hover {
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.6);
        }
    </style>
@endsection

@section('content')
<div class="saint-seiya-container p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-gold mb-0">⭐ Chevaliers Disponibles ⭐</h2>
            <p class="text-muted mb-0">Gérez vos cartes de combat cosmique</p>
        </div>
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter"></i> Filtres
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" onclick="filterCards('all')">Tous les camps</a>
                    <a class="dropdown-item" href="#" onclick="filterCards('flammes')">Flammes Écarlates</a>
                    <a class="dropdown-item" href="#" onclick="filterCards('glace')">Gardiens de Glace</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="filterCards('lieutenant')">Lieutenants</a>
                    <a class="dropdown-item" href="#" onclick="filterCards('sous_fifre')">Sous-fifres</a>
                </div>
            </div>
            <a href="{{ route('admin.card.create') }}" class="btn btn-warning">
                <i class="fas fa-plus"></i> Nouveau Chevalier
            </a>
        </div>
    </div>

    @foreach($camps as $camp)
    <div class="camp-section" data-camp="{{ strtolower(str_replace(' ', '-', $camp->name)) }}">
        <div class="camp-header {{ $camp->color == '#ef4444' ? 'flammes' : 'glace' }}">
            <div class="d-flex align-items-center">
                <i class="fas fa-{{ $camp->color == '#ef4444' ? 'fire' : 'snowflake' }} me-2"></i>
                <h4 class="mb-0">{{ $camp->name }}</h4>
                <span class="badge bg-dark ms-2">{{ $camp->cards->count() }} Chevaliers</span>
            </div>
            <div class="text-end">
                <small>{{ $camp->description }}</small>
            </div>
        </div>

        <div class="p-3">
            @if($camp->cards->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Aucun chevalier dans ce camp</p>
                    <a href="{{ route('admin.card.create') }}" class="btn btn-outline-warning">
                        Créer le premier chevalier
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach($camp->cards as $card)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card-saint-seiya {{ $card->type == 'lieutenant' ? 'lieutenant-card' : '' }}" 
                             data-type="{{ $card->type }}"
                             onclick="viewCard({{ $card->id }})">
                            
                            <div class="cosmic-energy"></div>
                            
                            <div class="card-image">
                                @if($card->image_path)
                                    <img src="{{ Storage::url($card->image_path) }}" alt="{{ $card->name }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-{{ $card->type == 'lieutenant' ? 'crown' : 'fist-raised' }}"></i>
                                    </div>
                                @endif
                                
                                <div class="card-type-badge {{ $card->type == 'lieutenant' ? 'lieutenant-badge' : 'sous-fifre-badge' }}">
                                    {{ $card->type == 'lieutenant' ? '👑 Lieutenant' : '⚔️ Sous-fifre' }}
                                </div>
                            </div>

                            <div class="card-content">
                                <h6 class="card-name">{{ $card->name }}</h6>
                                
                                <div class="hp-bar">
                                    <div class="hp-fill" style="width: {{ ($card->hp / $card->max_hp) * 100 }}%"></div>
                                </div>
                                
                                <p class="card-description">{{ $card->description ?: 'Mystérieux chevalier aux pouvoirs cosmiques...' }}</p>
                                
                                <div class="card-stats">
                                    <div class="stat-item">
                                        <span class="stat-value">{{ $card->hp }}/{{ $card->max_hp }}</span>
                                        <span class="stat-label">❤️ Vie</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">{{ $card->attack }}</span>
                                        <span class="stat-label">⚔️ ATQ</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">{{ $card->defense }}</span>
                                        <span class="stat-label">🛡️ DEF</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-actions">
                                <button class="action-btn btn-view" onclick="event.stopPropagation(); viewCard({{ $card->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn btn-edit" onclick="event.stopPropagation(); editCard({{ $card->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn btn-delete" onclick="event.stopPropagation(); deleteCard({{ $card->id }}, '{{ $card->name }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-warning">
                <h5 class="modal-title">⚠️ Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer le chevalier <strong id="cardNameToDelete"></strong> ?</p>
                <p class="text-warning"><small>Cette action est irréversible !</small></p>
            </div>
            <div class="modal-footer border-warning">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script>
    function viewCard(cardId) {
        window.location.href = `/admin/cards/show/${cardId}`;
    }

    function editCard(cardId) {
        window.location.href = `/admin/cards/edit/${cardId}`;
    }

    function deleteCard(cardId, cardName) {
        document.getElementById('cardNameToDelete').textContent = cardName;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
        
        document.getElementById('confirmDeleteBtn').onclick = async function() {
            try {
                const response = await fetch(`/admin/cards/delete/${cardId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });
                
                const result = await response.json();
                if (result && result.isSuccess) {
                    location.reload();
                }
            } catch (error) {
                console.error('Erreur lors de la suppression:', error);
            }
            modal.hide();
        };
    }

    function filterCards(filter) {
        const cards = document.querySelectorAll('.card-saint-seiya');
        const camps = document.querySelectorAll('.camp-section');
        
        camps.forEach(camp => camp.style.display = 'block');
        cards.forEach(card => card.parentElement.style.display = 'block');
        
        if (filter === 'all') return;
        
        if (filter === 'flammes' || filter === 'glace') {
            camps.forEach(camp => {
                if (!camp.dataset.camp.includes(filter === 'flammes' ? 'flammes' : 'gardiens')) {
                    camp.style.display = 'none';
                }
            });
        } else if (filter === 'lieutenant' || filter === 'sous_fifre') {
            cards.forEach(card => {
                if (card.dataset.type !== filter) {
                    card.parentElement.style.display = 'none';
                }
            });
        }
    }
</script>
@endsection