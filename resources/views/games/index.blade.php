@extends('admin')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 50%, #2d1b69 100%);
            min-height: 100vh;
            color: #fff;
        }

        .cosmic-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 80%, rgba(255, 215, 0, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .games-container {
            background: rgba(15, 15, 35, 0.95);
            border-radius: 20px;
            border: 2px solid #ffd700;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
            backdrop-filter: blur(10px);
            margin: 2rem;
            padding: 2rem;
        }

        .games-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .games-title {
            font-size: 2.5rem;
            background: linear-gradient(45deg, #ffd700, #ffed4e, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .tabs-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            justify-content: center;
        }

        .tab-button {
            padding: 0.75rem 1.5rem;
            background: rgba(26, 26, 46, 0.8);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 10px;
            color: #ccc;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .tab-button.active {
            background: rgba(255, 215, 0, 0.2);
            border-color: #ffd700;
            color: #ffd700;
            transform: translateY(-2px);
        }

        .tab-button:hover {
            border-color: #ffd700;
            color: #ffd700;
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .game-card {
            background: linear-gradient(145deg, rgba(26, 26, 46, 0.9), rgba(22, 33, 62, 0.9));
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .game-card:hover {
            transform: translateY(-5px);
            border-color: #ffd700;
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.4);
        }

        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .game-card:hover::before {
            left: 100%;
        }

        .game-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-waiting {
            background: linear-gradient(45deg, #f59e0b, #fbbf24);
            color: #000;
            animation: pulse-waiting 2s infinite;
        }

        .status-in-progress {
            background: linear-gradient(45deg, #22c55e, #4ade80);
            color: #000;
        }

        .status-finished {
            background: linear-gradient(45deg, #6b7280, #9ca3af);
            color: #fff;
        }

        @keyframes pulse-waiting {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .game-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #ffd700;
            margin-bottom: 1rem;
            margin-right: 6rem; /* Pour éviter le statut */
        }

        .game-players {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .player-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .player-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #000;
        }

        .player-name {
            color: #fff;
            font-weight: bold;
        }

        .vs-divider {
            color: #ffd700;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .waiting-player {
            color: #6b7280;
            font-style: italic;
        }

        .game-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .meta-item {
            text-align: center;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .meta-value {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffd700;
        }

        .meta-label {
            font-size: 0.8rem;
            color: #ccc;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .game-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .action-btn {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-join {
            background: linear-gradient(45deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
            border-color: #22c55e;
            color: #22c55e;
        }

        .btn-join:hover {
            background: linear-gradient(45deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2));
            box-shadow: 0 5px 20px rgba(34, 197, 94, 0.3);
            color: #4ade80;
            text-decoration: none;
        }

        .btn-spectate {
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1));
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .btn-spectate:hover {
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.3), rgba(59, 130, 246, 0.2));
            box-shadow: 0 5px 20px rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            text-decoration: none;
        }

        .btn-view {
            background: linear-gradient(45deg, rgba(255, 215, 0, 0.2), rgba(255, 215, 0, 0.1));
            border-color: #ffd700;
            color: #ffd700;
        }

        .btn-view:hover {
            background: linear-gradient(45deg, rgba(255, 215, 0, 0.3), rgba(255, 215, 0, 0.2));
            box-shadow: 0 5px 20px rgba(255, 215, 0, 0.3);
            color: #ffed4e;
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: rgba(255, 215, 0, 0.3);
        }

        .create-game-btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 1rem 2rem;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #000;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .create-game-btn:hover {
            background: linear-gradient(45deg, #ffed4e, #ffd700);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4);
            color: #000;
            text-decoration: none;
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
            animation: cosmic-float 10s infinite ease-in-out;
            opacity: 0.4;
        }

        @keyframes cosmic-float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0; }
            50% { transform: translateY(-40px) rotate(360deg); opacity: 1; }
        }

        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .stat-counter {
            text-align: center;
        }

        .stat-counter-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffd700;
        }

        .stat-counter-label {
            font-size: 0.8rem;
            color: #ccc;
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            .games-grid {
                grid-template-columns: 1fr;
            }
            
            .tabs-container {
                flex-direction: column;
                align-items: center;
            }
            
            .game-meta {
                grid-template-columns: 1fr;
            }
            
            .stats-bar {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="cosmic-background"></div>
<div class="floating-particles">
    <div class="particle" style="left: 5%; width: 2px; height: 2px; animation-delay: 0s;"></div>
    <div class="particle" style="left: 15%; width: 3px; height: 3px; animation-delay: 2s;"></div>
    <div class="particle" style="left: 30%; width: 2px; height: 2px; animation-delay: 4s;"></div>
    <div class="particle" style="left: 45%; width: 4px; height: 4px; animation-delay: 1s;"></div>
    <div class="particle" style="left: 60%; width: 2px; height: 2px; animation-delay: 3s;"></div>
    <div class="particle" style="left: 75%; width: 3px; height: 3px; animation-delay: 5s;"></div>
    <div class="particle" style="left: 90%; width: 2px; height: 2px; animation-delay: 2.5s;"></div>
</div>

<div class="games-container">
    <div class="games-header">
        <h1 class="games-title">⚔️ Arène de Combat ⚔️</h1>
        <p class="text-muted">Rejoignez des parties épiques ou créez votre propre combat cosmique !</p>
    </div>

    <!-- Statistiques -->
    <div class="stats-bar">
        <div class="stat-counter">
            <div class="stat-counter-value">{{ $gamesWaiting }}</div>
            <div class="stat-counter-label">🕐 En Attente</div>
        </div>
        <div class="stat-counter">
            <div class="stat-counter-value">{{ $gamesInProgress }}</div>
            <div class="stat-counter-label">⚔️ En Cours</div>
        </div>
        <div class="stat-counter">
            <div class="stat-counter-value">{{ $gamesFinished }}</div>
            <div class="stat-counter-label">🏆 Terminées</div>
        </div>
        <div class="stat-counter">
            <div class="stat-counter-value">{{ $totalGames }}</div>
            <div class="stat-counter-label">📊 Total</div>
        </div>
    </div>

    <!-- Onglets -->
    <div class="tabs-container">
        <div class="tab-button active" data-tab="waiting" onclick="switchTab('waiting')">
            <i class="fas fa-clock me-2"></i>En Attente
        </div>
        <div class="tab-button" data-tab="in-progress" onclick="switchTab('in-progress')">
            <i class="fas fa-gamepad me-2"></i>En Cours
        </div>
        <div class="tab-button" data-tab="finished" onclick="switchTab('finished')">
            <i class="fas fa-trophy me-2"></i>Terminées
        </div>
        <div class="tab-button" data-tab="my-games" onclick="switchTab('my-games')">
            <i class="fas fa-user me-2"></i>Mes Parties
        </div>
    </div>

    <!-- Contenu des onglets -->
    <div id="waiting-tab" class="tab-content">
        @if($waitingGames->isEmpty())
            <div class="empty-state">
                <i class="fas fa-plus-circle"></i>
                <h3>Aucune partie en attente</h3>
                <p>Soyez le premier à créer une partie épique !</p>
                <a href="{{ route('admin.deck-builder') }}" class="create-game-btn">
                    🚀 Créer une Partie
                </a>
            </div>
        @else
            <div class="games-grid">
                @foreach($waitingGames as $game)
                <div class="game-card">
                    <div class="game-status status-waiting">⏳ En Attente</div>
                    
                    <h3 class="game-name">{{ $game->name }}</h3>
                    
                    <div class="game-players">
                        <div class="player-info">
                            <div class="player-avatar">{{ substr($game->player1->name, 0, 2) }}</div>
                            <div class="player-name">{{ $game->player1->name }}</div>
                        </div>
                        <div class="vs-divider">VS</div>
                        <div class="player-info waiting-player">
                            <div class="player-avatar" style="background: #6b7280;">?</div>
                            <div>En attente d'adversaire...</div>
                        </div>
                    </div>

                    <div class="game-meta">
                        <div class="meta-item">
                            <div class="meta-value">{{ $game->gameDecks->where('player_id', $game->player1_id)->count() }}</div>
                            <div class="meta-label">Cartes</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-value">{{ $game->created_at->diffForHumans() }}</div>
                            <div class="meta-label">Créée</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-value">Tour {{ $game->turn_number }}</div>
                            <div class="meta-label">État</div>
                        </div>
                    </div>

                    <div class="game-actions">
                        @if($game->player1_id !== auth()->id())
                            <a href="{{ route('admin.game.join', ['id' => $game->id]) }}" class="action-btn btn-join">
                                <i class="fas fa-sword me-2"></i>Rejoindre
                            </a>
                        @endif
                        <a href="{{ route('admin.game.show', ['id' => $game->id]) }}" class="action-btn btn-view">
                            <i class="fas fa-eye me-2"></i>Voir
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="in-progress-tab" class="tab-content" style="display: none;">
        @if($inProgressGames->isEmpty())
            <div class="empty-state">
                <i class="fas fa-gamepad"></i>
                <h3>Aucune partie en cours</h3>
                <p>Les combats cosmiques arrivent bientôt !</p>
            </div>
        @else
            <div class="games-grid">
                @foreach($inProgressGames as $game)
                <div class="game-card">
                    <div class="game-status status-in-progress">⚔️ En Cours</div>
                    
                    <h3 class="game-name">{{ $game->name }}</h3>
                    
                    <div class="game-players">
                        <div class="player-info">
                            <div class="player-avatar">{{ substr($game->player1->name, 0, 2) }}</div>
                            <div class="player-name">{{ $game->player1->name }}</div>
                        </div>
                        <div class="vs-divider">VS</div>
                        <div class="player-info">
                            <div class="player-avatar">{{ substr($game->player2->name, 0, 2) }}</div>
                            <div class="player-name">{{ $game->player2->name }}</div>
                        </div>
                    </div>

                    <div class="game-meta">
                        <div class="meta-item">
                            <div class="meta-value">{{ $game->turn_number }}</div>
                            <div class="meta-label">Tour</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-value">{{ $game->getCurrentPlayer()->name }}</div>
                            <div class="meta-label">À jouer</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-value">{{ $game->started_at->diffForHumans() }}</div>
                            <div class="meta-label">Démarrée</div>
                        </div>
                    </div>

                    <div class="game-actions">
                        @if($game->player1_id === auth()->id() || $game->player2_id === auth()->id())
                            <a href="{{ route('admin.game.play', ['id' => $game->id]) }}" class="action-btn btn-join">
                                <i class="fas fa-play me-2"></i>Jouer
                            </a>
                        @else
                            <a href="{{ route('admin.game.spectate', ['id' => $game->id]) }}" class="action-btn btn-spectate">
                                <i class="fas fa-eye me-2"></i>Regarder
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="finished-tab" class="tab-content" style="display: none;">
        @if($finishedGames->isEmpty())
            <div class="empty-state">
                <i class="fas fa-trophy"></i>
                <h3>Aucune partie terminée</h3>
                <p>L'historique des combats apparaîtra ici !</p>
            </div>
        @else
            <div class="games-grid">
                @foreach($finishedGames as $game)
                <div class="game-card">
                    <div class="game-status status-finished">🏆 Terminée</div>
                    
                    <h3 class="game-name">{{ $game->name }}</h3>
                    
                    <div class="game-players">
                        <div class="player-info {{ $game->winner_id === $game->player1_id ? 'text-warning' : '' }}">
                            <div class="player-avatar">{{ substr($game->player1->name, 0, 2) }}</div>
                            <div class="player-name">
                                {{ $game->player1->name }}
                                @if($game->winner_id === $game->player1_id) 👑 @endif
                            </div>
                        </div>
                        <div class="vs-divider">VS</div>
                        <div class="player-info {{ $game->winner_id === $game->player2_id ? 'text-warning' : '' }}">
                            <div class="player-avatar">{{ substr($game->player2->name, 0, 2) }}</div>
                            <div class="player-name">
                                {{ $game->player2->name }}
                                @if($game->winner_id === $game->player2_id) 👑 @endif
                            </div>
                        </div>
                    </div>

                    <div class="game-meta">
                        <div class="meta-item">
                            <div class="meta-value">{{ $game->turn_number }}</div>
                            <div class="meta-label">Tours</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-value">{{ $game->winner->name ?? 'Égalité' }}</div>
                            <div class="meta-label">Vainqueur</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-value">{{ $game->finished_at->diffForHumans() }}</div>
                            <div class="meta-label">Finie</div>
                        </div>
                    </div>

                    <div class="game-actions">
                        <a href="{{ route('admin.game.show', ['id' => $game->id]) }}" class="action-btn btn-view">
                            <i class="fas fa-history me-2"></i>Revoir
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="my-games-tab" class="tab-content" style="display: none;">
        @if($myGames->isEmpty())
            <div class="empty-state">
                <i class="fas fa-user"></i>
                <h3>Aucune partie personnelle</h3>
                <p>Créez votre première partie pour commencer !</p>
                <a href="{{ route('admin.deck-builder') }}" class="create-game-btn">
                    🚀 Créer une Partie
                </a>
            </div>
        @else
            <div class="games-grid">
                @foreach($myGames as $game)
                <div class="game-card">
                    <div class="game-status status-{{ $game->status }}">
                        @if($game->status === 'waiting') ⏳ En Attente
                        @elseif($game->status === 'in_progress') ⚔️ En Cours
                        @else 🏆 Terminée
                        @endif
                    </div>
                    
                    <h3 class="game-name">{{ $game->name }}</h3>
                    
                    <div class="game-players">
                        <div class="player-info">
                            <div class="player-avatar">{{ substr($game->player1->name, 0, 2) }}</div>
                            <div class="player-name">{{ $game->player1->name }}</div>
                        </div>
                        <div class="vs-divider">VS</div>
                        @if($game->player2)
                            <div class="player-info">
                                <div class="player-avatar">{{ substr($game->player2->name, 0, 2) }}</div>
                                <div class="player-name">{{ $game->player2->name }}</div>
                            </div>
                        @else
                            <div class="player-info waiting-player">
                                <div class="player-avatar" style="background: #6b7280;">?</div>
                                <div>En attente...</div>
                            </div>
                        @endif
                    </div>

                    <div class="game-actions">
                        @if($game->status === 'in_progress')
                            <a href="{{ route('admin.game.play', ['id' => $game->id]) }}" class="action-btn btn-join">
                                <i class="fas fa-play me-2"></i>Continuer
                            </a>
                        @else
                            <a href="{{ route('admin.game.show', ['id' => $game->id]) }}" class="action-btn btn-view">
                                <i class="fas fa-eye me-2"></i>Voir
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Bouton flottant pour créer une partie -->
    <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1000;">
        <a href="{{ route('admin.deck-builder') }}" class="create-game-btn" style="border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-plus"></i>
        </a>
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Masquer tous les contenus d'onglets
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // Désactiver tous les boutons d'onglets
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });
        
        // Afficher le contenu sélectionné
        document.getElementById(tabName + '-tab').style.display = 'block';
        
        // Activer le bouton sélectionné
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    }

    // Auto-refresh pour les parties en cours
    setInterval(() => {
        if (document.querySelector('[data-tab="in-progress"].active')) {
            // Rafraîchir seulement si on est sur l'onglet "En Cours"
            // location.reload();
        }
    }, 30000); // 30 secondes
</script>
@endsection