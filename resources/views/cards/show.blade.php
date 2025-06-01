@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 50%, #2d1b69 100%);
            min-height: 100vh;
            color: #fff;
            overflow-x: hidden;
        }

        .cosmic-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 80%, rgba(255, 215, 0, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(239, 68, 68, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        .card-container {
            perspective: 1000px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .saint-seiya-card {
            width: 800px;
            height: 900px;
            background: linear-gradient(145deg, #1a1a2e 0%, #16213e 50%, #0f0f23 100%);
            border: 3px solid #ffd700;
            border-radius: 20px;
            box-shadow: 
                0 0 30px rgba(255, 215, 0, 0.3),
                inset 0 0 20px rgba(255, 215, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }

        .saint-seiya-card:hover {
            transform: rotateY(5deg) rotateX(5deg);
            box-shadow: 
                0 0 50px rgba(255, 215, 0, 0.5),
                inset 0 0 30px rgba(255, 215, 0, 0.2);
        }

        .card-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, #ffd700, transparent, #ffd700, transparent);
            /* animation: rotate 4s linear infinite; */
            opacity: 0.3;
        }

        /* @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        } */

        .card-inner {
            position: relative;
            z-index: 2;
            /* height: 100%; */
            background: linear-gradient(145deg, rgba(26, 26, 46, 0.95) 0%, rgba(22, 33, 62, 0.95) 100%);
            border-radius: 17px;
            display: flex;
            flex-direction: column;
        }

        .card-header {
            padding: 1rem;
            background: linear-gradient(90deg, #ffd700 0%, #ffed4e 100%);
            color: #000;
            position: relative;
            overflow: hidden;
        }

        .card-header.lieutenant {
            background: linear-gradient(90deg, #ffd700 0%, #ff8c00 50%, #ffd700 100%);
        }

        .card-header.sous-fifre {
            background: linear-gradient(90deg, #6b7280 0%, #9ca3af 50%, #6b7280 100%);
            color: white;
        }

        .card-type-badge {
            position: absolute;
            top: 10px;
            right: 15px;
            background: rgba(0, 0, 0, 0.8);
            color: #ffd700;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .card-camp {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 0.25rem;
        }

        .card-image-section {
            height: 280px;
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }

        .card-image-section img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .card-image-section .no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: rgba(255, 255, 255, 0.7);
            font-size: 4rem;
        }

        .energy-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255, 215, 0, 0.1) 50%,
                transparent 70%
            );
            animation: energy-pulse 2s ease-in-out infinite alternate;
        }

        @keyframes energy-pulse {
            0% { opacity: 0.3; }
            100% { opacity: 0.7; }
        }

        .card-stats-section {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .hp-section {
            margin-bottom: 1rem;
        }

        .hp-bar-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            height: 12px;
            overflow: hidden;
            position: relative;
            margin-bottom: 0.5rem;
        }

        .hp-bar {
            height: 100%;
            background: linear-gradient(90deg, #ef4444 0%, #f97316 50%, #22c55e 100%);
            transition: width 0.5s ease;
            position: relative;
        }

        .hp-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .hp-text {
            text-align: center;
            font-weight: bold;
            color: #ffd700;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .stat-box {
            background: linear-gradient(145deg, rgba(255, 215, 0, 0.1), rgba(255, 215, 0, 0.05));
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .stat-box:hover::before {
            left: 100%;
        }

        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffd700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .stat-label {
            font-size: 0.8rem;
            color: #ccc;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .xp-section {
            background: linear-gradient(90deg, rgba(255, 215, 0, 0.1), rgba(255, 215, 0, 0.05));
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .xp-bar-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            height: 8px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .xp-bar {
            height: 100%;
            background: linear-gradient(90deg, #8b5cf6, #a855f7, #c084fc);
            transition: width 0.5s ease;
        }

        .description-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 4px solid #ffd700;
        }

        .description-text {
            color: #e5e7eb;
            font-style: italic;
            line-height: 1.4;
        }

        .actions-section {
            display: flex;
            gap: 1rem;
            margin-top: auto;
        }

        .cosmic-btn {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid #ffd700;
            background: linear-gradient(145deg, rgba(255, 215, 0, 0.1), rgba(255, 215, 0, 0.05));
            color: #ffd700;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cosmic-btn:hover {
            background: linear-gradient(145deg, rgba(255, 215, 0, 0.2), rgba(255, 215, 0, 0.1));
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
            color: #fff;
            transform: translateY(-2px);
        }

        .cosmic-btn.edit {
            border-color: #22c55e;
            color: #22c55e;
        }

        .cosmic-btn.edit:hover {
            background: linear-gradient(145deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
        }

        .cosmic-btn.delete {
            border-color: #ef4444;
            color: #ef4444;
        }

        .cosmic-btn.delete:hover {
            background: linear-gradient(145deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
        }

        .side-panel {
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            width: 300px;
            background: rgba(26, 26, 46, 0.9);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .camp-info {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .camp-color {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            border: 3px solid #ffd700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        @media (max-width: 1200px) {
            .side-panel {
                position: static;
                width: 100%;
                transform: none;
                margin-top: 2rem;
            }
        }

        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: #ffd700;
            border-radius: 50%;
            animation: float 6s infinite ease-in-out;
            opacity: 0.6;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
        }
    </style>
@endsection

@section('content')
<div class="cosmic-background"></div>
<div class="floating-particles">
    <div class="particle" style="left: 10%; width: 4px; height: 4px; animation-delay: 0s;"></div>
    <div class="particle" style="left: 20%; width: 6px; height: 6px; animation-delay: 1s;"></div>
    <div class="particle" style="left: 35%; width: 4px; height: 4px; animation-delay: 2s;"></div>
    <div class="particle" style="left: 50%; width: 5px; height: 5px; animation-delay: 0.5s;"></div>
    <div class="particle" style="left: 65%; width: 4px; height: 4px; animation-delay: 1.5s;"></div>
    <div class="particle" style="left: 80%; width: 6px; height: 6px; animation-delay: 3s;"></div>
    <div class="particle" style="left: 90%; width: 4px; height: 4px; animation-delay: 2.5s;"></div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card-container">
                <div class="saint-seiya-card">
                    <div class="card-glow"></div>
                    
                    <div class="card-inner">
                        <!-- En-tête de la carte -->
                        <div class="card-header {{ $card->type }}">
                            <div class="card-type-badge">
                                {{ $card->type == 'lieutenant' ? '👑 Lieutenant' : '⚔️ Sous-fifre' }}
                            </div>
                            <h1 class="card-name">{{ $card->name }}</h1>
                            <div class="card-camp">{{ $card->camp->name }}</div>
                        </div>

                        <!-- Section image -->
                        <div class="card-image-section">
                            @if($card->image_path)
                                <img src="{{ Storage::url($card->image_path) }}" alt="{{ $card->name }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-{{ $card->type == 'lieutenant' ? 'crown' : 'fist-raised' }}"></i>
                                </div>
                            @endif
                            <div class="energy-overlay"></div>
                        </div>

                        <!-- Section statistiques -->
                        <div class="card-stats-section">
                            <!-- Points de vie -->
                            <div class="hp-section">
                                <div class="hp-bar-container">
                                    <div class="hp-bar" style="width: {{ ($card->hp / $card->max_hp) * 100 }}%"></div>
                                </div>
                                <div class="hp-text">❤️ {{ $card->hp }} / {{ $card->max_hp }} PV</div>
                            </div>

                            <!-- Grille des stats -->
                            <div class="stats-grid">
                                <div class="stat-box">
                                    <span class="stat-icon">⚔️</span>
                                    <div class="stat-value">{{ $card->attack }}</div>
                                    <div class="stat-label">Attaque</div>
                                </div>
                                <div class="stat-box">
                                    <span class="stat-icon">🛡️</span>
                                    <div class="stat-value">{{ $card->defense }}</div>
                                    <div class="stat-label">Défense</div>
                                </div>
                                <div class="stat-box">
                                    <span class="stat-icon">⚡</span>
                                    <div class="stat-value">{{ $card->speed }}</div>
                                    <div class="stat-label">Vitesse</div>
                                </div>
                            </div>

                            <!-- Expérience -->
                            <div class="xp-section">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-star text-warning"></i> Expérience</span>
                                    <span class="text-warning font-weight-bold">{{ $card->xp }} XP</span>
                                </div>
                                <div class="xp-bar-container">
                                    <div class="xp-bar" style="width: {{ min(($card->xp / 100) * 100, 100) }}%"></div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($card->description)
                            <div class="description-section">
                                <p class="description-text">"{{ $card->description }}"</p>
                            </div>
                            @endif

                            <!-- Actions -->
                            <div class="actions-section">
                                <a href="{{ route('admin.card.index') }}" class="cosmic-btn">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <a href="{{ route('admin.card.edit', ['id' => $card->id]) }}" class="cosmic-btn edit">
                                    <i class="fas fa-edit me-2"></i>Modifier
                                </a>
                                <button class="cosmic-btn delete" onclick="confirmDelete()">
                                    <i class="fas fa-trash me-2"></i>Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panneau latéral avec infos du camp -->
                <div class="side-panel d-none d-lg-block">
                    <div class="camp-info">
                        <div class="camp-color" style="background-color: {{ $card->camp->color }};">
                            <i class="fas fa-{{ $card->camp->color == '#ef4444' ? 'fire' : 'snowflake' }} text-white"></i>
                        </div>
                        <h4 class="text-warning">{{ $card->camp->name }}</h4>
                        <p class="text-muted small">{{ $card->camp->description }}</p>
                    </div>

                    <div class="text-center">
                        <h6 class="text-warning mb-3">🏆 Statistiques du camp</h6>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <div class="h4 text-warning">{{ $card->camp->cards->count() }}</div>
                                    <small class="text-muted">Chevaliers</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="h4 text-warning">{{ $card->camp->cards->where('type', 'lieutenant')->count() }}</div>
                                <small class="text-muted">Lieutenants</small>
                            </div>
                        </div>
                    </div>

                    <hr class="border-warning">

                    <div class="text-center">
                        <h6 class="text-warning mb-3">⚔️ Autres chevaliers</h6>
                        @foreach($card->camp->cards->where('id', '!=', $card->id)->take(3) as $otherCard)
                        <div class="d-flex align-items-center mb-2 p-2 bg-dark rounded">
                            <div class="me-2">
                                @if($otherCard->type == 'lieutenant')
                                    <i class="fas fa-crown text-warning"></i>
                                @else
                                    <i class="fas fa-fist-raised text-secondary"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1 text-start">
                                <div class="small text-white">{{ $otherCard->name }}</div>
                                <div class="text-muted" style="font-size: 0.7rem;">{{ $otherCard->hp }}/{{ $otherCard->max_hp }} PV</div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($card->camp->cards->count() > 4)
                        <a href="{{ route('admin.card.index') }}" class="btn btn-outline-warning btn-sm mt-2">
                            Voir tous les chevaliers
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-warning">
            <div class="modal-header border-warning">
                <h5 class="modal-title text-warning">⚠️ Supprimer le chevalier</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p>Êtes-vous sûr de vouloir supprimer <strong class="text-warning">{{ $card->name }}</strong> ?</p>
                    <p class="text-danger"><small>Cette action est irréversible !</small></p>
                </div>
            </div>
            <div class="modal-footer border-warning">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" onclick="deleteCard()">
                    <i class="fas fa-trash me-2"></i>Supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    async function deleteCard() {
        try {
            const response = await fetch(`/admin/cards/delete/{{ $card->id }}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });
            
            const result = await response.json();
            if (result && result.isSuccess) {
                window.location.href = '/admin/cards';
            }
        } catch (error) {
            console.error('Erreur lors de la suppression:', error);
        }
    }

    // Animation des particules cosmiques
    document.addEventListener('DOMContentLoaded', function() {
        const particles = document.querySelectorAll('.particle');
        particles.forEach((particle, index) => {
            particle.style.animationDelay = `${index * 0.5}s`;
            particle.style.top = `${Math.random() * 100}%`;
        });
    });
</script>
@endsection