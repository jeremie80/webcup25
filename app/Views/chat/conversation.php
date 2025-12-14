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
            <div class="user-avatar-small">
                <?php if (!empty($other_profile['avatar_path']) && file_exists(__DIR__ . '/../../../' . $other_profile['avatar_path'])): ?>
                    <img src="/<?= htmlspecialchars($other_profile['avatar_path']) ?>" alt="Avatar">
                <?php else: ?>
                    <div class="avatar-placeholder-small">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <h2 class="conversation-user-name"><?= htmlspecialchars($other_user['galactic_name']) ?></h2>
                <p class="conversation-user-origin"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $other_user['origin_type']))) ?></p>
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
            <?php foreach ($messages as $msg): ?>
                <?php 
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
            <?php endforeach; ?>
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
function createMessageElement(msg) {
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
                    data.messages.forEach(msg => {
                        if (!existingIds.includes(msg.id)) {
                            const messageElement = createMessageElement(msg);
                            messagesContainer.appendChild(messageElement);
                        }
                    });
                    
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

