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
                radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .join-game-container {
            background: rgba(15, 15, 35, 0.95);
            border-radius: 20px;
            border: 2px solid #ffd700;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
            backdrop-filter: blur(10px);
            margin: 2rem;
            padding: 2rem;
        }

        .join-game-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .join-game-title {
            font-size: 2.2rem;
            background: linear-gradient(45deg, #ffd700, #ffed4e, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .opponent-info {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .opponent-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ef4444, #f97316);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 1.2rem;
        }

        .vs-text {
            font-size: 1.5rem;
            color: #ffd700;
            font-weight: bold;
        }

        .your-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, #3b82f6, #06b6d4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 1.2rem;
        }

        /* Réutiliser les styles du deck-builder */
        .deck-zones {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 2rem;
            height: calc(100vh - 300px);
            min-height: 600px;
        }

        .available-cards-zone {
            background: rgba(26, 26, 46, 0.8);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 1rem;
            overflow-y: auto;
        }

        .camp-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .camp-option {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid transparent;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }

        .camp-option.active {
            border-color: #ffd700;
            background: rgba(255, 215, 0, 0.2);
            transform: scale(1.05);
        }

        .camp-option.flammes {
            background: linear-gradient(145deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1));
        }

        .camp-option.flammes.active {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.3);
        }

        .camp-option.glace {
            background: linear-gradient(145deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1));
        }

        .camp-option.glace.active {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.3);
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 1rem;
        }

        .mini-card {
            width: 140px;
            height: 200px;
            background: linear-gradient(145deg, #1e1e2e 0%, #2a2a3e 100%);
            border: 2px solid #ffd700;
            border-radius: 12px;
            overflow: hidden;
            cursor: grab;
            transition: all 0.3s ease;
            position: relative;
        }

        .mini-card:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4);
        }

        .mini-card.lieutenant {
            border-color: #ffd700;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        }

        .mini-card.sous-fifre {
            border-color: #6b7280;
        }

        .mini-card.selected {
            opacity: 0.5;
            transform: scale(0.9);
            filter: grayscale(50%);
        }

        .mini-card-image {
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .mini-card-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .mini-card-type {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.8);
            color: #ffd700;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 0.6rem;
            font-weight: bold;
        }

        .mini-card-content {
            padding: 0.5rem;
            height: 80px;
            display: flex;
            flex-direction: column;
        }

        .mini-card-name {
            font-size: 0.8rem;
            font-weight: bold;
            color: #ffd700;
            margin-bottom: 0.25rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .mini-card-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
            margin-top: auto;
        }

        .mini-stat {
            background: rgba(255, 215, 0, 0.1);
            border-radius: 4px;
            padding: 2px 4px;
            text-align: center;
            min-width: 25px;
        }

        .deck-selection-zone {
            background: rgba(26, 26, 46, 0.8);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .deck-formation {
            display: grid;
            grid-template-areas:
                "lieutenant lieutenant lieutenant"
                "sous1 sous2 sous3"
                "sous4 . info";
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: auto auto 1fr;
            gap: 1rem;
            height: 100%;
            align-items: start;
        }

        .deck-slot {
            border: 3px dashed rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            background: rgba(255, 255, 255, 0.05);
        }

        .deck-slot.lieutenant-slot {
            grid-area: lieutenant;
            min-height: 200px;
            background: linear-gradient(145deg, rgba(255, 215, 0, 0.1), rgba(255, 215, 0, 0.05));
        }

        .deck-slot.sous-fifre-1 {
            grid-area: sous1;
        }

        .deck-slot.sous-fifre-2 {
            grid-area: sous2;
        }

        .deck-slot.sous-fifre-3 {
            grid-area: sous3;
        }

        .deck-slot.sous-fifre-4 {
            grid-area: sous4;
        }

        .deck-info {
            grid-area: info;
            background: rgba(255, 215, 0, 0.1);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
        }

        .deck-slot.drag-over {
            border-color: #ffd700;
            background: rgba(255, 215, 0, 0.2);
            transform: scale(1.05);
        }

        .deck-slot.filled {
            border-style: solid;
            border-color: #ffd700;
        }

        .slot-label {
            font-size: 0.9rem;
            color: rgba(255, 215, 0, 0.7);
            margin-bottom: 0.5rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .slot-icon {
            font-size: 2rem;
            color: rgba(255, 215, 0, 0.3);
            margin-bottom: 0.5rem;
        }

        .slot-description {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.5);
            text-align: center;
        }

        .deck-card {
            width: 100%;
            height: 160px;
            background: linear-gradient(145deg, #1e1e2e 0%, #2a2a3e 100%);
            border: 2px solid #ffd700;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }

        .deck-card .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 25px;
            height: 25px;
            background: #ef4444;
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 0.8rem;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .deck-card:hover .remove-btn {
            opacity: 1;
        }

        .deck-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .deck-stat {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.5rem;
            text-align: center;
        }

        .deck-stat-value {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffd700;
        }

        .deck-stat-label {
            font-size: 0.7rem;
            color: #ccc;
        }

        .join-battle-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, #22c55e, #4ade80);
            border: none;
            border-radius: 12px;
            color: #000;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
        }

        .join-battle-btn:hover {
            background: linear-gradient(45deg, #4ade80, #22c55e);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.4);
        }

        .join-battle-btn:disabled {
            background: #6b7280;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .formation-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ffd700;
            font-size: 1.3rem;
            font-weight: bold;
        }

        .back-btn {
            background: linear-gradient(45deg, rgba(107, 114, 128, 0.2), rgba(107, 114, 128, 0.1));
            border: 2px solid #6b7280;
            color: #6b7280;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .back-btn:hover {
            border-color: #9ca3af;
            color: #9ca3af;
            text-decoration: none;
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')
    <div class="cosmic-background"></div>

    <div class="join-game-container">
        <a href="{{ route('admin.game.index') }}" class="back-btn">
            <i class="fas fa-arrow-left me-2"></i>Retour aux parties
        </a>

        <div class="join-game-header">
            <h1 class="join-game-title">⚔️ Rejoindre la Bataille ⚔️</h1>
            <p class="text-muted">Sélectionnez votre formation pour affronter {{ $game->player1->name }} !</p>

            <div class="opponent-info">
                <div>
                    <div class="opponent-avatar">{{ substr($game->player1->name, 0, 2) }}</div>
                    <div class="mt-2 text-warning font-weight-bold">{{ $game->player1->name }}</div>
                </div>
                <div class="vs-text">VS</div>
                <div>
                    <div class="your-avatar">{{ substr(auth()->user()->name, 0, 2) }}</div>
                    <div class="mt-2 text-info font-weight-bold">{{ auth()->user()->name }}</div>
                </div>
            </div>

            <div class="text-center">
                <h4 class="text-warning">🏆 Partie : {{ $game->name }}</h4>
            </div>
        </div>

        <div class="deck-zones">
            <!-- Zone des cartes disponibles -->
            <div class="available-cards-zone">
                <h3 class="text-warning mb-3"><i class="fas fa-users"></i> Chevaliers Disponibles</h3>

                <!-- Sélecteur de camp -->
                <div class="camp-selector">
                    <div class="camp-option flammes active" data-camp="flammes" onclick="selectCamp('flammes')">
                        <i class="fas fa-fire"></i>
                        <div class="mt-1">Enfers</div>
                    </div>
                    <div class="camp-option glace" data-camp="glace" onclick="selectCamp('glace')">
                        <i class="fas fa-snowflake"></i>
                        <div class="mt-1">Sanctuaire</div>
                    </div>
                </div>

                <!-- Grille des cartes -->
                <div class="cards-grid" id="cardsGrid">
                    @foreach ($camps as $camp)
                        @foreach ($camp->cards as $card)
                            <div class="mini-card {{ $card->type }}" data-card-id="{{ $card->id }}"
                                data-card-type="{{ $card->type }}"
                                data-camp="{{ strtolower(str_replace(' ', '-', $camp->name)) }}" draggable="true"
                                ondragstart="dragStart(event)">

                                <div class="mini-card-image">
                                    @if ($card->image_path)
                                        <img src="{{ Storage::url($card->image_path) }}" alt="{{ $card->name }}">
                                    @else
                                        <i
                                            class="fas fa-{{ $card->type == 'lieutenant' ? 'crown' : 'fist-raised' }} text-warning fa-2x"></i>
                                    @endif
                                    <div class="mini-card-type">
                                        {{ $card->type == 'lieutenant' ? '👑' : '⚔️' }}
                                    </div>
                                </div>

                                <div class="mini-card-content">
                                    <div class="mini-card-name">{{ $card->name }}</div>
                                    <div class="mini-card-stats">
                                        <div class="mini-stat">❤️{{ $card->hp }}</div>
                                        <div class="mini-stat">⚔️{{ $card->attack }}</div>
                                        <div class="mini-stat">🛡️{{ $card->defense }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <!-- Zone de formation du deck -->
            <div class="deck-selection-zone">
                <div class="formation-title">🛡️ Votre Formation de Combat 🛡️</div>

                <div class="deck-formation">
                    <!-- Slot Lieutenant -->
                    <div class="deck-slot lieutenant-slot" data-slot="lieutenant" ondrop="drop(event)"
                        ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)">
                        <div class="slot-icon">👑</div>
                        <div class="slot-label">Lieutenant</div>
                        <div class="slot-description">Votre commandant en chef</div>
                    </div>

                    <!-- Slots Sous-fifres -->
                    <div class="deck-slot sous-fifre-1" data-slot="sous_fifre_1" ondrop="drop(event)"
                        ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)">
                        <div class="slot-icon">⚔️</div>
                        <div class="slot-label">Sous-fifre 1</div>
                        <div class="slot-description">Premier guerrier</div>
                    </div>

                    <div class="deck-slot sous-fifre-2" data-slot="sous_fifre_2" ondrop="drop(event)"
                        ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)">
                        <div class="slot-icon">⚔️</div>
                        <div class="slot-label">Sous-fifre 2</div>
                        <div class="slot-description">Deuxième guerrier</div>
                    </div>

                    <div class="deck-slot sous-fifre-3" data-slot="sous_fifre_3" ondrop="drop(event)"
                        ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)">
                        <div class="slot-icon">⚔️</div>
                        <div class="slot-label">Sous-fifre 3</div>
                        <div class="slot-description">Troisième guerrier</div>
                    </div>

                    <div class="deck-slot sous-fifre-4" data-slot="sous_fifre_4" ondrop="drop(event)"
                        ondragover="allowDrop(event)" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)">
                        <div class="slot-icon">⚔️</div>
                        <div class="slot-label">Sous-fifre 4</div>
                        <div class="slot-description">Quatrième guerrier</div>
                    </div>

                    <!-- Informations du deck -->
                    <div class="deck-info">
                        <h5 class="text-warning mb-3">📊 Statistiques</h5>
                        <div class="deck-stats">
                            <div class="deck-stat">
                                <div class="deck-stat-value" id="totalHp">0</div>
                                <div class="deck-stat-label">PV Total</div>
                            </div>
                            <div class="deck-stat">
                                <div class="deck-stat-value" id="avgAttack">0</div>
                                <div class="deck-stat-label">ATQ Moy.</div>
                            </div>
                            <div class="deck-stat">
                                <div class="deck-stat-value" id="avgDefense">0</div>
                                <div class="deck-stat-label">DEF Moy.</div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <div class="text-warning font-weight-bold" id="deckStatus">
                                Sélectionnez vos cartes
                            </div>
                            <div class="small text-muted" id="deckProgress">
                                0/5 cartes sélectionnées
                            </div>
                        </div>

                        <form id="joinGameForm" action="{{ route('admin.game.join-with-deck', ['id' => $game->id]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="deck_cards" id="deckCardsInput">

                            <button type="submit" class="join-battle-btn" id="joinBattleBtn" disabled>
                                ⚔️ Rejoindre le Combat !
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedCards = {};
        let cardData = {};

        // Initialiser les données des cartes
        @foreach ($camps as $camp)
            @foreach ($camp->cards as $card)
                cardData[{{ $card->id }}] = {
                    id: {{ $card->id }},
                    name: "{{ $card->name }}",
                    type: "{{ $card->type }}",
                    hp: {{ $card->hp }},
                    attack: {{ $card->attack }},
                    defense: {{ $card->defense }},
                    image: "{{ $card->image_path ? Storage::url($card->image_path) : '' }}",
                    camp: "{{ strtolower(str_replace(' ', '-', $camp->name)) }}"
                };
            @endforeach
        @endforeach

        // Réutiliser les fonctions du deck-builder...
        function selectCamp(camp) {
            document.querySelectorAll('.camp-option').forEach(option => {
                option.classList.remove('active');
            });
            document.querySelector(`[data-camp="${camp}"]`).classList.add('active');

            document.querySelectorAll('.mini-card').forEach(card => {
                const cardCamp = card.dataset.camp;

                if (camp === 'flammes') {
                    if (cardCamp.includes('enfers')) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                } else if (camp === 'glace') {
                    if (cardCamp.includes('sanctuaire')) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    card.style.display = 'block';
                }
            });
        }

        function dragStart(event) {
            const card = event.target.closest('.mini-card');
            const cardId = card.dataset.cardId;
            const cardType = card.dataset.cardType;

            event.dataTransfer.setData('cardId', cardId);
            event.dataTransfer.setData('cardType', cardType);
        }

        function allowDrop(event) {
            event.preventDefault();
        }

        function dragEnter(event) {
            event.target.closest('.deck-slot').classList.add('drag-over');
        }

        function dragLeave(event) {
            event.target.closest('.deck-slot').classList.remove('drag-over');
        }

        function drop(event) {
            event.preventDefault();
            const slot = event.target.closest('.deck-slot');
            slot.classList.remove('drag-over');

            const cardId = event.dataTransfer.getData('cardId');
            const cardType = event.dataTransfer.getData('cardType');
            const slotType = slot.dataset.slot;

            if (slotType === 'lieutenant' && cardType !== 'lieutenant') {
                alert('Seuls les lieutenants peuvent être placés dans ce slot !');
                return;
            }
            if (slotType.startsWith('sous_fifre') && cardType !== 'sous_fifre') {
                alert('Seuls les sous-fifres peuvent être placés dans ce slot !');
                return;
            }

            if (Object.values(selectedCards).includes(parseInt(cardId))) {
                alert('Cette carte est déjà sélectionnée !');
                return;
            }

            placeCardInSlot(cardId, slotType, slot);
        }

        function placeCardInSlot(cardId, slotType, slotElement) {
            const card = cardData[cardId];

            if (selectedCards[slotType]) {
                removeCardFromSlot(slotType);
            }

            selectedCards[slotType] = parseInt(cardId);

            slotElement.innerHTML = `
            <div class="deck-card">
                <button class="remove-btn" onclick="removeCardFromSlot('${slotType}')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="mini-card-image">
                    ${card.image ? `<img src="${card.image}" alt="${card.name}">` : 
                      `<i class="fas fa-${card.type === 'lieutenant' ? 'crown' : 'fist-raised'} text-warning fa-3x"></i>`}
                </div>
                <div class="mini-card-content">
                    <div class="mini-card-name">${card.name}</div>
                    <div class="mini-card-stats">
                        <div class="mini-stat">❤️${card.hp}</div>
                        <div class="mini-stat">⚔️${card.attack}</div>
                        <div class="mini-stat">🛡️${card.defense}</div>
                    </div>
                </div>
            </div>
        `;

            slotElement.classList.add('filled');
            document.querySelector(`[data-card-id="${cardId}"]`).classList.add('selected');
            updateDeckStats();
        }

        function removeCardFromSlot(slotType) {
            const cardId = selectedCards[slotType];
            if (cardId) {
                delete selectedCards[slotType];

                const slot = document.querySelector(`[data-slot="${slotType}"]`);
                const isLieutenant = slotType === 'lieutenant';
                slot.innerHTML = `
                <div class="slot-icon">${isLieutenant ? '👑' : '⚔️'}</div>
                <div class="slot-label">${isLieutenant ? 'Lieutenant' : slotType.replace('_', ' ')}</div>
                <div class="slot-description">${isLieutenant ? 'Votre commandant en chef' : 'Guerrier'}</div>
            `;
                slot.classList.remove('filled');
                document.querySelector(`[data-card-id="${cardId}"]`).classList.remove('selected');
                updateDeckStats();
            }
        }

        function updateDeckStats() {
            const cards = Object.values(selectedCards).map(id => cardData[id]);
            const totalCards = cards.length;

            // Calculer les stats
            const totalHp = cards.reduce((sum, card) => sum + card.hp, 0);
            const avgAttack = totalCards > 0 ? Math.round(cards.reduce((sum, card) => sum + card.attack, 0) / totalCards) :
                0;
            const avgDefense = totalCards > 0 ? Math.round(cards.reduce((sum, card) => sum + card.defense, 0) /
                totalCards) : 0;

            // Mettre à jour l'affichage
            document.getElementById('totalHp').textContent = totalHp;
            document.getElementById('avgAttack').textContent = avgAttack;
            document.getElementById('avgDefense').textContent = avgDefense;

            // Mettre à jour le statut
            const deckStatus = document.getElementById('deckStatus');
            const deckProgress = document.getElementById('deckProgress');
            const joinBtn = document.getElementById('joinBattleBtn');

            deckProgress.textContent = `${totalCards}/5 cartes sélectionnées`;

            if (totalCards === 0) {
                deckStatus.textContent = "Sélectionnez vos cartes";
                deckStatus.className = "text-warning font-weight-bold";
                joinBtn.disabled = true;
            } else if (totalCards < 5) {
                deckStatus.textContent = `Il manque ${5 - totalCards} carte(s)`;
                deckStatus.className = "text-warning font-weight-bold";
                joinBtn.disabled = true;
            } else if (totalCards === 5) {
                // Vérifier qu'on a bien 1 lieutenant et 4 sous-fifres
                const hasLieutenant = selectedCards.lieutenant !== undefined;
                const sousFifresCount = Object.keys(selectedCards).filter(key => key.startsWith('sous_fifre')).length;

                if (hasLieutenant && sousFifresCount === 4) {
                    deckStatus.textContent = "Formation prête ! En route pour la bataille ! 🎯";
                    deckStatus.className = "text-success font-weight-bold";
                    joinBtn.disabled = false;
                } else {
                    deckStatus.textContent = "Formation incomplète";
                    deckStatus.className = "text-warning font-weight-bold";
                    joinBtn.disabled = true;
                }
            }

            // Mettre à jour le champ caché pour le formulaire
            document.getElementById('deckCardsInput').value = JSON.stringify(selectedCards);
        }

        // Initialiser l'affichage
        document.addEventListener('DOMContentLoaded', function() {
            selectCamp('flammes');
            updateDeckStats();
        });

        // Gérer la soumission du formulaire
        document.getElementById('joinGameForm').addEventListener('submit', function(e) {
            console.log('=== FORM SUBMIT DEBUG ===');
            console.log('Selected cards:', selectedCards);
            console.log('Form data:', new FormData(this));
            console.log('Deck cards input value:', document.getElementById('deckCardsInput').value);

            const totalCards = Object.keys(selectedCards).length;
            if (totalCards !== 5) {
                e.preventDefault();
                alert('Vous devez sélectionner exactement 5 cartes (1 lieutenant + 4 sous-fifres) !');
                return;
            }

            // Vérifier la formation
            const hasLieutenant = selectedCards.lieutenant !== undefined;
            const sousFifresCount = Object.keys(selectedCards).filter(key => key.startsWith('sous_fifre')).length;

            if (!hasLieutenant || sousFifresCount !== 4) {
                e.preventDefault();
                alert('Formation invalide ! Vous devez avoir 1 lieutenant et 4 sous-fifres.');
                return;
            }

            // Animation de lancement
            const btn = document.getElementById('joinBattleBtn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Rejoindre en cours...';
            btn.disabled = true;
        });
    </script>
@endsection
