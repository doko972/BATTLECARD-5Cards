<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 50%, #2d1b69 100%);
            min-height: 100vh;
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

        .saint-seiya-container {
            background: rgba(15, 15, 35, 0.95);
            border-radius: 20px;
            border: 2px solid #ffd700;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
            backdrop-filter: blur(10px);
            color: white;
            overflow: hidden;
            position: relative;
        }

        .cosmic-title {
            font-size: 3rem;
            background: linear-gradient(45deg, #ffd700, #ffed4e, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.5)); }
            to { filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.8)); }
        }

        .action-card {
            background: linear-gradient(145deg, rgba(26, 26, 46, 0.8), rgba(22, 33, 62, 0.8));
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .action-card:hover {
            transform: translateY(-10px) scale(1.05);
            border-color: #ffd700;
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.4);
            color: white;
            text-decoration: none;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .action-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #ffd700;
        }

        .action-description {
            color: #ccc;
            font-size: 1rem;
            line-height: 1.4;
        }

        .deck-builder-card {
            background: linear-gradient(45deg, rgba(255, 215, 0, 0.2), rgba(255, 215, 0, 0.1));
            border-color: #ffd700;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
        }

        .deck-builder-card:hover {
            background: linear-gradient(45deg, rgba(255, 215, 0, 0.3), rgba(255, 215, 0, 0.2));
            box-shadow: 0 15px 50px rgba(255, 215, 0, 0.6);
        }

        .cards-management-card {
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1));
            border-color: #3b82f6;
        }

        .cards-management-card:hover {
            border-color: #60a5fa;
            box-shadow: 0 15px 40px rgba(59, 130, 246, 0.4);
        }

        .games-list-card {
            background: linear-gradient(45deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1));
            border-color: #22c55e;
        }

        .games-list-card:hover {
            border-color: #4ade80;
            box-shadow: 0 15px 40px rgba(34, 197, 94, 0.4);
        }

        .welcome-text {
            color: #e5e7eb;
            font-size: 1.2rem;
            margin-bottom: 3rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
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
            animation: cosmic-float 8s infinite ease-in-out;
            opacity: 0.6;
        }

        @keyframes cosmic-float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0; }
            50% { transform: translateY(-30px) rotate(360deg); opacity: 1; }
        }

        .stats-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #ffd700;
        }

        .stat-label {
            color: #ccc;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>

    <div class="cosmic-background"></div>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="saint-seiya-container p-8">
                <div class="floating-particles">
                    <div class="particle" style="left: 10%; width: 3px; height: 3px; animation-delay: 0s;"></div>
                    <div class="particle" style="left: 25%; width: 4px; height: 4px; animation-delay: 2s;"></div>
                    <div class="particle" style="left: 40%; width: 3px; height: 3px; animation-delay: 4s;"></div>
                    <div class="particle" style="left: 55%; width: 5px; height: 5px; animation-delay: 1s;"></div>
                    <div class="particle" style="left: 70%; width: 3px; height: 3px; animation-delay: 3s;"></div>
                    <div class="particle" style="left: 85%; width: 4px; height: 4px; animation-delay: 5s;"></div>
                </div>

                <div class="text-center mb-8">
                    <h1 class="cosmic-title mb-4">⭐ Sanctuaire Saint Seiya ⭐</h1>
                    <p class="welcome-text">
                        Bienvenue, {{ auth()->user()->name }} ! Préparez votre équipe de chevaliers et partez conquérir les galaxies !
                    </p>
                </div>

                <!-- Statistiques rapides -->
                <div class="stats-section">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-value">{{ \App\Models\Card::count() }}</div>
                                <div class="stat-label">👑 Chevaliers</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-value">{{ \App\Models\Camp::count() }}</div>
                                <div class="stat-label">🏰 Camps</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-value">{{ \App\Models\Game::count() }}</div>
                                <div class="stat-label">⚔️ Parties</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-value">{{ \App\Models\Game::where('player1_id', auth()->id())->orWhere('player2_id', auth()->id())->count() }}</div>
                                <div class="stat-label">🎮 Mes Combats</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions principales -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <a href="{{ route('admin.gamedeck.deck-builder') }}" class="action-card deck-builder-card d-block">
                            <span class="action-icon">🚀</span>
                            <h3 class="action-title">Créer une Partie</h3>
                            <p class="action-description">
                                Sélectionnez votre lieutenant et vos 4 sous-fifres pour partir au combat cosmique !
                            </p>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="{{ route('admin.card.index') }}" class="action-card cards-management-card d-block">
                            <span class="action-icon">👑</span>
                            <h3 class="action-title">Gérer les Cartes</h3>
                            <p class="action-description">
                                Administrez vos chevaliers, créez de nouvelles cartes et gérez les camps.
                            </p>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="{{ route('admin.game.index') }}" class="action-card games-list-card d-block">
                            <span class="action-icon">⚔️</span>
                            <h3 class="action-title">Parties en Cours</h3>
                            <p class="action-description">
                                Rejoignez des parties en attente ou consultez l'historique de vos combats.
                            </p>
                        </a>
                    </div>
                </div>

                <!-- Section liens rapides -->
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="stats-section">
                            <h4 class="text-warning mb-3"><i class="fas fa-fire"></i> Liens Rapides</h4>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.camp.index') }}" class="btn btn-outline-warning btn-sm">
                                    🏰 Camps
                                </a>
                                <a href="{{ route('admin.camp.create') }}" class="btn btn-outline-warning btn-sm">
                                    ➕ Nouveau Camp
                                </a>
                                <a href="{{ route('admin.card.create') }}" class="btn btn-outline-warning btn-sm">
                                    ⭐ Nouvelle Carte
                                </a>
                                <a href="{{ route('admin.gamedeck.index') }}" class="btn btn-outline-warning btn-sm">
                                    🎴 GameDecks
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="stats-section">
                            <h4 class="text-warning mb-3"><i class="fas fa-chart-bar"></i> Dernière Activité</h4>
                            <div class="small text-muted">
                                @php
                                    $lastCard = \App\Models\Card::latest()->first();
                                    $lastGame = \App\Models\Game::latest()->first();
                                @endphp
                                
                                @if($lastCard)
                                <p><i class="fas fa-plus-circle text-success"></i> Dernière carte créée : <strong>{{ $lastCard->name }}</strong></p>
                                @endif
                                
                                @if($lastGame)
                                <p><i class="fas fa-gamepad text-info"></i> Dernière partie : <strong>{{ $lastGame->name }}</strong></p>
                                @endif
                                
                                <p><i class="fas fa-clock text-warning"></i> Connecté depuis : <strong>{{ now()->diffForHumans() }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>