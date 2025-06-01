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

        .deck-builder-container {
            background: rgba(15, 15, 35, 0.95);
            border-radius: 20px;
            border: 2px solid #ffd700;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
            backdrop-filter: blur(10px);
            margin: 2rem;
            padding: 2rem;
        }

        .deck-builder-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .deck-builder-title {
            font-size: 2.5rem;
            background: linear-gradient(45deg, #ffd700, #ffed4e, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .deck-zones {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 2rem;
            /* height: calc(100vh - 200px); */
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

        .deck-slot.sous-fifre-1 { grid-area: sous1; }
        .deck-slot.sous-fifre-2 { grid-area: sous2; }
        .deck-slot.sous-fifre-3 { grid-area: sous3; }
        .deck-slot.sous-fifre-4 { grid-area: sous4; }

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

        .start-battle-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
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

        .start-battle-btn:hover {
            background: linear-gradient(45deg, #ffed4e, #ffd700);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4);
        }

        .start-battle-btn:disabled {
            background: #6b7280;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .cosmic-particles {
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

        .formation-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #ffd700;
            font-size: 1.3rem;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
<div class="cosmic-background"></div>
<div class="cosmic-particles">
    <div class="particle" style="left: 10%; width: 3px; height: 3px; animation-delay: 0s;"></div>
    <div class="particle" style="left: 25%; width: 4px; height: 4px; animation-delay: 2s;"></div>
    <div class="particle" style="left: 40%; width: 3px; height: 3px; animation-delay: 4s;"></div>
    <div class="particle" style="left: 55%; width: 5px; height: 5px; animation-delay: 1s;"></div>
    <div class="particle" style="left: 70%; width: 3px; height: 3px; animation-delay: 3s;"></div>
    <div class="particle" style="left: 85%; width: 4px; height: 4px; animation-delay: 5s;"></div>
</div>

<div class="deck-builder-container">
    <div class="deck-builder-header">
        <h1 class="deck-builder-title">⭐ Formation de Combat ⭐</h1>
        <p class="text-muted">Choisissez votre lieutenant et vos 4 sous-fifres pour partir au combat !</p>
    </div>

    <div class="deck-zones">
        <!-- Zone des cartes disponibles -->
        <div class="available-cards-zone">
            <h3 class="text-warning mb-3"><i class="fas fa-users"></i> Chevaliers Disponibles</h3>
            
            <!-- Sélecteur de camp -->
            <div class="camp-selector">
                <div class="camp-option flammes active" data-camp="flammes" onclick="selectCamp('flammes')">
                    <i class="fas fa-fire"></i>
                    <div class="mt-1">Flammes Écarlates</div>
                </div>
                <div class="camp-option glace" data-camp="glace" onclick="selectCamp('glace')">
                    <i class="fas fa-snowflake"></i>
                    <div class="mt-1">Gardiens de Glace</div>
                </div>
            </div>

            <!-- Grille des cartes -->
            <div class="cards-grid" id="cardsGrid">
                @foreach($camps as $camp)
                    @foreach($camp->cards as $card)
                    <div class="mini-card {{ $card->type }}" 
                         data-card-id="{{ $card->id }}"
                         data-card-type="{{ $card->type }}"
                         data-camp="{{ strtolower(str_replace(' ', '-', $camp->name)) }}"
                         draggable="true"
                         ondragstart="dragStart(event)">
                        
                        <div class="mini-card-image">
                            @if($card->image_path)
                                <img src="{{ Storage::url($card->image_path) }}" alt="{{ $card->name }}">
                            @else
                                <i class="fas fa-{{ $card->type == 'lieutenant' ? 'crown' : 'fist-raised' }} text-warning fa-2x"></i>
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
            <div class="formation-title">🛡️ Formation de Combat 🛡️</div>
            
            <div class="deck-formation">
                <!-- Slot Lieutenant -->
                <div class="deck-slot lieutenant-slot" 
                     data-slot="lieutenant" 
                     ondrop="drop(event)" 
                     ondragover="allowDrop(event)"
                     ondragenter="dragEnter(event)"
                     ondragleave="dragLeave(event)">
                    <div class="slot-icon">👑</div>
                    <div class="slot-label">Lieutenant</div>
                    <div class="slot-description">Votre commandant en chef</div>
                </div>

                <!-- Slots Sous-fifres -->
                <div class="deck-slot sous-fifre-1" 
                     data-slot="sous_fifre_1" 
                     ondrop="drop(event)" 
                     ondragover="allowDrop(event)"
                     ondragenter="dragEnter(event)"
                     ondragleave="dragLeave(event)">
                    <div class="slot-icon">⚔️</div>
                    <div class="slot-label">Sous-fifre 1</div>
                    <div class="slot-description">Premier guerrier</div>
                </div>

                <div class="deck-slot sous-fifre-2" 
                     data-slot="sous_fifre_2" 
                     ondrop="drop(event)" 
                     ondragover="allowDrop(event)"
                     ondragenter="dragEnter(event)"
                     ondragleave="dragLeave(event)">
                    <div class="slot-icon">⚔️</div>
                    <div class="slot-label">Sous-fifre 2</div>
                    <div class="slot-description">Deuxième guerrier</div>
                </div>

                <div class="deck-slot sous-fifre-3" 
                     data-slot="sous_fifre_3" 
                     ondrop="drop(event)" 
                     ondragover="allowDrop(event)"
                     ondragenter="dragEnter(event)"
                     ondragleave="dragLeave(event)">
                    <div class="slot-icon">⚔️</div>
                    <div class="slot-label">Sous-fifre 3</div>
                    <div class="slot-description">Troisième guerrier</div>
                </div>

                <div class="deck-slot sous-fifre-4" 
                     data-slot="sous_fifre_4" 
                     ondrop="drop(event)" 
                     ondragover="allowDrop(event)"
                     ondragenter="dragEnter(event)"
                     ondragleave="dragLeave(event)">
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

                    <form id="createGameForm" action="{{ route('admin.game.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="deck_cards" id="deckCardsInput">
                        <input type="text" name="game_name" class="form-control mb-3 bg-dark text-white border-warning" 
                               placeholder="Nom de la partie..." required>
                        
                        <button type="submit" class="start-battle-btn" id="startBattleBtn" disabled>
                            🚀 Partir au Combat !
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
    @foreach($camps as $camp)
        @foreach($camp->cards as $card)
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

    function selectCamp(camp) {
        // Mettre à jour les boutons de camp
        document.querySelectorAll('.camp-option').forEach(option => {
            option.classList.remove('active');
        });
        document.querySelector(`[data-camp="${camp}"]`).classList.add('active');

        // Filtrer les cartes
        document.querySelectorAll('.mini-card').forEach(card => {
            const cardCamp = card.dataset.camp;
            if (camp === 'flammes' && cardCamp.includes('flammes')) {
                card.style.display = 'block';
            } else if (camp === 'glace' && cardCamp.includes('gardiens')) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function dragStart(event) {
        const cardId = event.target.dataset.cardId;
        const cardType = event.target.dataset.cardType;
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

        // Vérifier si le type de carte correspond au slot
        if (slotType === 'lieutenant' && cardType !== 'lieutenant') {
            alert('Seuls les lieutenants peuvent être placés dans ce slot !');
            return;
        }
        if (slotType.startsWith('sous_fifre') && cardType !== 'sous_fifre') {
            alert('Seuls les sous-fifres peuvent être placés dans ce slot !');
            return;
        }

        // Vérifier si la carte n'est pas déjà sélectionnée
        if (Object.values(selectedCards).includes(parseInt(cardId))) {
            alert('Cette carte est déjà sélectionnée !');
            return;
        }

        // Placer la carte
        placeCardInSlot(cardId, slotType, slot);
    }

    function placeCardInSlot(cardId, slotType, slotElement) {
        const card = cardData[cardId];
        
        // Supprimer l'ancienne carte si présente
        if (selectedCards[slotType]) {
            removeCardFromSlot(slotType);
        }

        // Ajouter la nouvelle carte
        selectedCards[slotType] = parseInt(cardId);

        // Créer l'élément carte dans le slot
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

        // Marquer la carte comme sélectionnée
        document.querySelector(`[data-card-id="${cardId}"]`).classList.add('selected');

        updateDeckStats();
    }

    function removeCardFromSlot(slotType) {
        const cardId = selectedCards[slotType];
        if (cardId) {
            // Supprimer de la sélection
            delete selectedCards[slotType];

            // Restaurer le slot vide
            const slot = document.querySelector(`[data-slot="${slotType}"]`);
            const isLieutenant = slotType === 'lieutenant';
            slot.innerHTML = `
                <div class="slot-icon">${isLieutenant ? '👑' : '⚔️'}</div>
                <div class="slot-label">${isLieutenant ? 'Lieutenant' : slotType.replace('_', ' ')}</div>
                <div class="slot-description">${isLieutenant ? 'Votre commandant en chef' : 'Guerrier'}</div>
            `;
            slot.classList.remove('filled');

            // Démarquer la carte
            document.querySelector(`[data-card-id="${cardId}"]`).classList.remove('selected');

            updateDeckStats();
        }
    }

    function updateDeckStats() {
        const cards = Object.values(selectedCards).map(id => cardData[id]);
        const totalCards = cards.length;

        // Calculer les stats
        const totalHp = cards.reduce((sum, card) => sum + card.hp, 0);
        const avgAttack = totalCards > 0 ? Math.round(cards.reduce((sum, card) => sum + card.attack, 0) / totalCards) : 0;
        const avgDefense = totalCards > 0 ? Math.round(cards.reduce((sum, card) => sum + card.defense, 0) / totalCards) : 0;

        // Mettre à jour l'affichage
        document.getElementById('totalHp').textContent = totalHp;
        document.getElementById('avgAttack').textContent = avgAttack;
        document.getElementById('avgDefense').textContent = avgDefense;

        // Mettre à jour le statut
        const deckStatus = document.getElementById('deckStatus');
        const deckProgress = document.getElementById('deckProgress');
        const startBtn = document.getElementById('startBattleBtn');

        deckProgress.textContent = `${totalCards}/5 cartes sélectionnées`;

        if (totalCards === 0) {
            deckStatus.textContent = "Sélectionnez vos cartes";
            startBtn.disabled = true;
        } else if (totalCards < 5) {
            deckStatus.textContent = `Il manque ${5 - totalCards} carte(s)`;
            startBtn.disabled = true;
        } else if (totalCards === 5) {
            // Vérifier qu'on a bien 1 lieutenant et 4 sous-fifres
            const hasLieutenant = selectedCards.lieutenant !== undefined;
            const sousFifresCount = Object.keys(selectedCards).filter(key => key.startsWith('sous_fifre')).length;
            
            if (hasLieutenant && sousFifresCount === 4) {
                deckStatus.textContent = "Formation prête ! 🎯";
                deckStatus.className = "text-success font-weight-bold";
                startBtn.disabled = false;
            } else {
                deckStatus.textContent = "Formation incomplète";
                deckStatus.className = "text-warning font-weight-bold";
                startBtn.disabled = true;
            }
        }

        // Mettre à jour le champ caché pour le formulaire
        document.getElementById('deckCardsInput').value = JSON.stringify(selectedCards);
    }

    // Initialiser l'affichage avec le premier camp
    document.addEventListener('DOMContentLoaded', function() {
        selectCamp('flammes');
        updateDeckStats();
    });

    // Gérer la soumission du formulaire
    document.getElementById('createGameForm').addEventListener('submit', function(e) {
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
        const btn = document.getElementById('startBattleBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création en cours...';
        btn.disabled = true;
    });
</script>
@endsection