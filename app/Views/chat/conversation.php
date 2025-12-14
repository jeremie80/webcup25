<section class="conversation-container">
    <div class="portal-glow"></div>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="flash-message flash-success">
            <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="flash-message flash-error">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <header class="conversation-header">
        <a href="/chat" class="back-button">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
        </a>
        
        <div class="conversation-user-info">
            <!-- Forme abstraite ou avatar selon révélation -->
            <div class="entity-visual-container" id="entity-visual-container" data-revealed="<?= $is_revealed ? 'true' : 'false' ?>">
                <?php if ($is_revealed): ?>
                    <!-- Avatar révélé avec animation -->
                    <div class="revealed-avatar">
                        <?php if (!empty($other_profile['avatar_path']) && file_exists(__DIR__ . '/../../../' . $other_profile['avatar_path'])): ?>
                            <img src="/<?= htmlspecialchars($other_profile['avatar_path']) ?>" alt="Avatar révélé" class="avatar-image-revealed">
                        <?php else: ?>
                            <div class="avatar-placeholder-revealed">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Forme abstraite (pré-révélation) -->
                    <div class="entity-abstract-icon">
                        <div class="abstract-entity-shape shape-1"></div>
                        <div class="abstract-entity-shape shape-2"></div>
                        <div class="abstract-entity-shape shape-3"></div>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <h2 class="conversation-user-name"><?= htmlspecialchars($other_user['galactic_name']) ?></h2>
                <p class="conversation-user-origin"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $other_user['origin_type']))) ?></p>
                
                <!-- Jauge de confiance interespèce -->
                <div class="trust-gauge">
                    <div class="trust-gauge-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                        <span>Niveau de confiance interespèce</span>
                    </div>
                    <div class="trust-gauge-bar">
                        <div class="trust-gauge-fill trust-stage-<?= $trust_level['stage'] ?>" style="width: <?= $trust_level['percentage'] ?>%;"></div>
                    </div>
                    <span class="trust-gauge-status"><?= htmlspecialchars($trust_level['label']) ?> — <?= $trust_level['percentage'] ?>%</span>
                </div>
                
                <?php if ($is_revealed && $message_count >= 10): ?>
                    <!-- Bouton d'évaluation du lien (après révélation) -->
                    <a href="/match/result?match_id=<?= $match_id ?>" class="btn-evaluate-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 11l3 3L22 4"></path>
                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                        </svg>
                        <span>Évaluer ce lien</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="ia-orb-container-small" id="ia-orb-narrator" data-narration="Vous êtes en conversation avec <?= htmlspecialchars($other_user['galactic_name']) ?>. Échangez librement et respectueusement.">
            <div class="ia-orb-ring ring-1"></div>
            <div class="ia-orb-ring ring-2"></div>
            <div class="ia-orb-core">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
            </div>
        </div>
    </header>
    
    <article class="messages-container" id="messages-container">
        <?php if (empty($messages)): ?>
            <div class="no-messages">
                <p>Aucun message pour le moment. Commencez la conversation !</p>
            </div>
        <?php else: ?>
            <!-- Message de révélation (si déclenchée) -->
            <?php if ($revelation_triggered): ?>
                <div class="revelation-message" id="revelation-message">
                    <div class="revelation-glow"></div>
                    <div class="revelation-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 16v-4"></path>
                            <path d="M12 8h.01"></path>
                        </svg>
                    </div>
                    <div class="revelation-content">
                        <h3 class="revelation-title">✨ Révélation Cosmique ✨</h3>
                        <p class="revelation-text">
                            <strong>ASTRÆA :</strong> <?= \App\Core\IALanguage::getChatIntervention('revelation') ?>
                        </p>
                        <p class="revelation-subtext">
                            La forme véritable de <?= htmlspecialchars($other_user['galactic_name']) ?> vous est maintenant accessible.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php 
            $messageIndex = 0;
            foreach ($messages as $msg): 
                $messageIndex++;
                $isSender = ($msg['sender_profile_id'] == $current_profile_id);
                $messageClass = $isSender ? 'message-sent' : 'message-received';
            ?>
                <div class="message <?= $messageClass ?>">
                    <div class="message-header">
                        <span class="message-author"><?= htmlspecialchars($msg['galactic_name']) ?></span>
                        <span class="message-time"><?= date('d/m/Y H:i', $msg['created_at']) ?></span>
                    </div>
                    <div class="message-content">
                        <?= nl2br(htmlspecialchars($msg['content'])) ?>
                    </div>
                </div>
                
                <?php 
                // Interventions IA contextuelles à des moments clés
                $iaInterventions = [];
                
                if ($messageIndex === 1) {
                    $iaInterventions[] = \App\Core\IALanguage::getChatIntervention('welcome');
                } elseif ($messageIndex === 3) {
                    $iaInterventions[] = \App\Core\IALanguage::getChatIntervention('progress_early');
                } elseif ($messageIndex === 6) {
                    $iaInterventions[] = \App\Core\IALanguage::getChatIntervention('progress_mid');
                } elseif ($messageIndex === 10) {
                    $iaInterventions[] = \App\Core\IALanguage::getChatIntervention('progress_complete');
                }
                
                // Détection de mots potentiellement problématiques
                $content = strtolower($msg['content']);
                $warningWords = ['guerre', 'conflit', 'détruire', 'haïr', 'attaquer', 'ennemi', 'violent', 'hostile'];
                foreach ($warningWords as $word) {
                    if (strpos($content, $word) !== false) {
                        $iaInterventions[] = \App\Core\IALanguage::getChatIntervention('warning_hostile');
                        break;
                    }
                }
                
                // Afficher les interventions IA
                foreach ($iaInterventions as $intervention):
                ?>
                    <div class="ia-intervention">
                        <div class="ia-intervention-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                <line x1="15" y1="9" x2="15.01" y2="9"></line>
                            </svg>
                        </div>
                        <div class="ia-intervention-content">
                            <strong>ASTRÆA :</strong> <?= htmlspecialchars($intervention) ?>
                        </div>
                    </div>
                <?php 
                endforeach;
            endforeach; ?>
        <?php endif; ?>
    </article>
    
    <footer class="message-form-container">
        <form method="POST" action="/chat/send" class="message-form" id="message-form">
            <input type="hidden" name="match_id" value="<?= $match_id ?>">
            
            <div class="message-input-wrapper">
                <textarea 
                    name="content" 
                    id="message-input" 
                    placeholder="Écrivez votre message..." 
                    required
                    maxlength="5000"
                    rows="2"
                ></textarea>
                
                <button type="submit" class="btn btn-send">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    <span>Envoyer</span>
                </button>
            </div>
        </form>
    </footer>
</section>

<script>
// Configuration
const MATCH_ID = <?= $match_id ?>;
const CURRENT_PROFILE_ID = <?= $current_profile_id ?>;
const REFRESH_INTERVAL = 10000; // 10 secondes

let lastMessageCount = <?= count($messages) ?>;
let isScrolledToBottom = true;
let refreshTimer = null;

// Helper: Formater la date
function formatDate(timestamp) {
    const date = new Date(timestamp * 1000);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}

// Helper: Échapper le HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Helper: Convertir \n en <br>
function nl2br(text) {
    return text.replace(/\n/g, '<br>');
}

// Auto-scroll vers le bas
function scrollToBottom(smooth = false) {
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.scrollTo({
            top: messagesContainer.scrollHeight,
            behavior: smooth ? 'smooth' : 'auto'
        });
    }
}

// Vérifier si l'utilisateur est en bas de la liste
function checkIfScrolledToBottom() {
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        const threshold = 100; // 100px de marge
        isScrolledToBottom = messagesContainer.scrollHeight - messagesContainer.scrollTop - messagesContainer.clientHeight < threshold;
    }
}

// Créer un élément message
function createMessageElement(msg, messageIndex) {
    const messageClass = msg.is_current_user ? 'message-sent' : 'message-received';
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${messageClass}`;
    messageDiv.dataset.messageId = msg.id;
    
    messageDiv.innerHTML = `
        <div class="message-header">
            <span class="message-author">${escapeHtml(msg.galactic_name)}</span>
            <span class="message-time">${formatDate(msg.created_at)}</span>
        </div>
        <div class="message-content">
            ${nl2br(escapeHtml(msg.content))}
        </div>
    `;
    
    return messageDiv;
}

// Créer une intervention IA
function createIAIntervention(text) {
    const interventionDiv = document.createElement('div');
    interventionDiv.className = 'ia-intervention';
    
    interventionDiv.innerHTML = `
        <div class="ia-intervention-icon">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                <line x1="15" y1="9" x2="15.01" y2="9"></line>
            </svg>
        </div>
        <div class="ia-intervention-content">
            <strong>ASTRÆA :</strong> ${escapeHtml(text)}
        </div>
    `;
    
    return interventionDiv;
}

// Messages IA disponibles (synchronisés avec le backend)
const iaMessages = {
    welcome: [
        "Bienvenue dans cet espace d'échange. Prenez le temps de vous découvrir mutuellement.",
        "Cet espace est dédié à votre connexion. Laissez la conversation se déployer naturellement.",
        "Vous entrez dans un lieu d'échange authentique. ASTRÆA veille à l'harmonie de vos échanges.",
        "Le dialogue s'ouvre entre vos deux essences. Exprimez-vous avec authenticité et ouverture.",
        "Ce canal de communication est maintenant actif. Que vos mots reflètent votre véritable nature."
    ],
    progress_early: [
        "Les premiers échanges sont prometteurs. Continuez à cultiver cette connexion avec authenticité.",
        "Votre dialogue s'établit harmonieusement. Les bases d'une connexion solide se dessinent.",
        "Je perçois une résonance positive entre vous. Cette relation a du potentiel.",
        "Les premières vibrations sont encourageantes. Vous créez ensemble un espace de confiance.",
        "Votre communication trouve naturellement son rythme. C'est un excellent signe de compatibilité."
    ],
    progress_mid: [
        "Votre dialogue s'approfondit. La confiance se construit progressivement.",
        "Les échanges gagnent en profondeur. Vous apprenez à vous connaître mutuellement.",
        "Une compréhension mutuelle émerge. Cette connexion se renforce à chaque message.",
        "Je constate une évolution remarquable dans vos échanges. Les barrières s'estompent naturellement.",
        "Vos fréquences s'harmonisent. Le dialogue atteint un niveau de qualité notable."
    ],
    progress_complete: [
        "Vous avez établi un lien significatif. L'harmonie entre vous atteint son apogée.",
        "Cette connexion a mûri admirablement. Vous avez franchi un seuil important.",
        "Votre relation témoigne d'une harmonie profonde. C'est un modèle d'échange interespèce.",
        "Le niveau de compréhension atteint est remarquable. Vous avez co-créé une connexion d'exception.",
        "Votre dialogue a transcendé les différences. Cette alliance est maintenant pleinement établie."
    ],
    warning_hostile: [
        "⚠️ Attention : certaines expressions peuvent être perçues comme hostiles. Privilégiez un langage constructif.",
        "⚠️ Je détecte une tension dans les mots. Reformulez avec bienveillance pour préserver l'harmonie.",
        "⚠️ Cette formulation pourrait créer un malentendu. Optez pour une communication plus douce.",
        "⚠️ Alerte diplomatique : le ton employé risque de générer un conflit. Recentrez-vous sur l'intention positive.",
        "⚠️ Je perçois une dissonance potentielle. Reformulez pour favoriser la compréhension mutuelle."
    ],
    revelation: [
        "La compréhension mutuelle atteint un seuil suffisant. Révélation autorisée.",
        "Le niveau de confiance permet désormais la révélation. Vous êtes prêt·e·s.",
        "Les échanges ont prouvé la solidité de votre connexion. La révélation est accordée.",
        "Le voile peut maintenant tomber. Vous avez démontré une harmonie suffisante pour cette étape.",
        "La maturité de votre dialogue justifie la révélation. Le moment est venu."
    ]
};

// Fonction utilitaire pour obtenir un message aléatoire
function getRandomIAMessage(context) {
    if (!iaMessages[context]) return null;
    const messages = iaMessages[context];
    return messages[Math.floor(Math.random() * messages.length)];
}

// Générer les interventions IA contextuelles
function generateIAInterventions(msg, messageIndex) {
    const interventions = [];
    
    // Interventions basées sur le nombre de messages
    if (messageIndex === 1) {
        interventions.push(getRandomIAMessage('welcome'));
    } else if (messageIndex === 3) {
        interventions.push(getRandomIAMessage('progress_early'));
    } else if (messageIndex === 6) {
        interventions.push(getRandomIAMessage('progress_mid'));
    } else if (messageIndex === 10) {
        interventions.push(getRandomIAMessage('progress_complete'));
    }
    
    // Détection de mots potentiellement problématiques
    const content = msg.content.toLowerCase();
    const warningWords = ['guerre', 'conflit', 'détruire', 'haïr', 'attaquer', 'ennemi', 'violent', 'hostile'];
    
    for (const word of warningWords) {
        if (content.includes(word)) {
            interventions.push(getRandomIAMessage('warning_hostile'));
            break;
        }
    }
    
    return interventions.filter(i => i !== null);
}

// Créer le message de révélation
function createRevelationMessage(otherUserName) {
    const revelationDiv = document.createElement('div');
    revelationDiv.className = 'revelation-message';
    revelationDiv.id = 'revelation-message';
    
    // Sélectionner un message de révélation aléatoire
    const revelationMessage = getRandomIAMessage('revelation') || "La compréhension mutuelle atteint un seuil suffisant. Révélation autorisée.";
    
    revelationDiv.innerHTML = `
        <div class="revelation-glow"></div>
        <div class="revelation-icon">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 16v-4"></path>
                <path d="M12 8h.01"></path>
            </svg>
        </div>
        <div class="revelation-content">
            <h3 class="revelation-title">✨ Révélation Cosmique ✨</h3>
            <p class="revelation-text">
                <strong>ASTRÆA :</strong> ${escapeHtml(revelationMessage)}
            </p>
            <p class="revelation-subtext">
                La forme véritable de ${escapeHtml(otherUserName)} vous est maintenant accessible.
            </p>
        </div>
    `;
    
    return revelationDiv;
}

// Déclencher la révélation (animation)
function triggerRevelation(otherUserName, avatarPath) {
    const entityVisualContainer = document.getElementById('entity-visual-container');
    if (!entityVisualContainer) return;
    
    // Marquer comme révélé
    entityVisualContainer.setAttribute('data-revealed', 'true');
    
    // Remplacer la forme abstraite par l'avatar
    const abstractIcon = entityVisualContainer.querySelector('.entity-abstract-icon');
    if (abstractIcon) {
        // Créer le nouvel avatar
        const revealedAvatar = document.createElement('div');
        revealedAvatar.className = 'revealed-avatar';
        
        if (avatarPath) {
            revealedAvatar.innerHTML = `<img src="${avatarPath}" alt="Avatar révélé" class="avatar-image-revealed">`;
        } else {
            revealedAvatar.innerHTML = `
                <div class="avatar-placeholder-revealed">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
            `;
        }
        
        // Transition douce
        abstractIcon.style.opacity = '0';
        abstractIcon.style.transform = 'scale(0.5)';
        
        setTimeout(() => {
            entityVisualContainer.innerHTML = '';
            entityVisualContainer.appendChild(revealedAvatar);
        }, 500);
    }
    
    // Ajouter le message de révélation dans le chat
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer && !document.getElementById('revelation-message')) {
        const revelationMsg = createRevelationMessage(otherUserName);
        // Insérer au début des messages (après le premier message si il y en a)
        const firstMessage = messagesContainer.querySelector('.message');
        if (firstMessage) {
            firstMessage.insertAdjacentElement('afterend', revelationMsg);
        } else {
            messagesContainer.insertBefore(revelationMsg, messagesContainer.firstChild);
        }
        
        // Scroll pour montrer le message
        setTimeout(() => {
            revelationMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }
}

// Rafraîchir les messages via AJAX
function refreshMessages() {
    fetch(`/chat/messages?match_id=${MATCH_ID}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.messages) {
                const messagesContainer = document.getElementById('messages-container');
                const currentMessages = messagesContainer.querySelectorAll('.message');
                
                // Si le nombre de messages a changé, mettre à jour
                if (data.messages.length !== lastMessageCount) {
                    // Supprimer le message "Aucun message" s'il existe
                    const noMessages = messagesContainer.querySelector('.no-messages');
                    if (noMessages) {
                        noMessages.remove();
                    }
                    
                    // Récupérer les IDs des messages existants
                    const existingIds = Array.from(currentMessages).map(el => parseInt(el.dataset.messageId));
                    
                    // Ajouter les nouveaux messages
                    data.messages.forEach((msg, index) => {
                        if (!existingIds.includes(msg.id)) {
                            const messageIndex = index + 1;
                            const messageElement = createMessageElement(msg, messageIndex);
                            messagesContainer.appendChild(messageElement);
                            
                            // Générer et ajouter les interventions IA
                            const interventions = generateIAInterventions(msg, messageIndex);
                            interventions.forEach(text => {
                                const interventionElement = createIAIntervention(text);
                                messagesContainer.appendChild(interventionElement);
                            });
                        }
                    });
                    
                    // Vérifier si la révélation doit être déclenchée
                    const entityVisualContainer = document.getElementById('entity-visual-container');
                    const isRevealed = entityVisualContainer && entityVisualContainer.getAttribute('data-revealed') === 'true';
                    
                    if (data.messages.length >= 10 && !isRevealed && !document.getElementById('revelation-message')) {
                        // Déclencher la révélation
                        const otherUserName = '<?= htmlspecialchars($other_user['galactic_name']) ?>';
                        const avatarPath = '<?= !empty($other_profile['avatar_path']) ? '/' . htmlspecialchars($other_profile['avatar_path']) : '' ?>';
                        
                        setTimeout(() => {
                            triggerRevelation(otherUserName, avatarPath);
                        }, 1000);
                    }
                    
                    // Scroll automatique si l'utilisateur était en bas
                    if (isScrolledToBottom) {
                        scrollToBottom(true);
                    }
                    
                    lastMessageCount = data.messages.length;
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors du rafraîchissement des messages:', error);
        });
}

// Démarrer le polling
function startPolling() {
    refreshTimer = setInterval(refreshMessages, REFRESH_INTERVAL);
}

// Arrêter le polling
function stopPolling() {
    if (refreshTimer) {
        clearInterval(refreshTimer);
        refreshTimer = null;
    }
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    const messageInput = document.getElementById('message-input');
    const messageForm = document.getElementById('message-form');
    
    // Auto-scroll initial
    scrollToBottom();
    
    // Détecter le scroll pour savoir si on doit auto-scroll
    if (messagesContainer) {
        messagesContainer.addEventListener('scroll', checkIfScrolledToBottom);
    }
    
    // Auto-resize du textarea
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
    
    // Soumettre le formulaire et rafraîchir immédiatement
    if (messageForm) {
        messageForm.addEventListener('submit', function() {
            // Rafraîchir les messages 1 seconde après l'envoi
            setTimeout(() => {
                refreshMessages();
            }, 1000);
        });
    }
    
    // Démarrer le polling automatique
    startPolling();
    
    // Arrêter le polling quand l'utilisateur quitte la page
    window.addEventListener('beforeunload', stopPolling);
    
    // Arrêter le polling si la page devient invisible (économie de ressources)
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopPolling();
        } else {
            startPolling();
            refreshMessages(); // Rafraîchir immédiatement au retour
        }
    });
});
</script>

