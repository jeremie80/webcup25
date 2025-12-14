<section class="portal-entrance-split">
    <div class="portal-glow"></div>
    
    <!-- Partie gauche : IA -->
    <aside class="portal-ia-side">
        <div class="ia-orb-container" id="ia-orb-narrator" data-narration="Bienvenue dans l'espace d'échanges, <?= htmlspecialchars($galactic_name) ?>. Ici, vous pouvez converser avec les voyageurs avec qui vous avez établi une connexion mutuelle.">
            <div class="ia-orb-ring ring-1"></div>
            <div class="ia-orb-ring ring-2"></div>
            <div class="ia-orb-ring ring-3"></div>
            <div class="ia-orb-core">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
                <div class="particle particle-5"></div>
                <div class="particle particle-6"></div>
            </div>
        </div>
        
        <div class="ia-name">
            <h2>ASTRÆA</h2>
            <p>Échanges Cosmiques</p>
        </div>
        
        <div class="ia-message">
            <p>Vos conversations avec les harmonies révélées, <strong><?= htmlspecialchars($galactic_name) ?></strong>.</p>
        </div>
    </aside>
    
    <!-- Partie droite : Contenu -->
    <article class="portal-content-side">
        <header class="portal-content-header">
            <h1 class="intro-title">Échanges Cosmiques</h1>
            <p class="intro-subtitle">Vos conversations avec les harmonies révélées</p>
        </header>
    
        <?php if (empty($conversations)): ?>
            <div class="no-conversations">
            <div class="no-conversations-icon">💬</div>
            <h2>Aucune conversation pour le moment</h2>
            <p>Les conversations apparaissent lorsque vous acceptez mutuellement une harmonie. Explorez les <a href="/match" class="link-primary">suggestions</a> pour trouver vos connexions.</p>
            </div>
        <?php else: ?>
            <div class="conversations-list">
            <?php foreach ($conversations as $conv): ?>
                <a href="/chat?match_id=<?= $conv['match_id'] ?>" class="conversation-card">
                    <div class="conversation-avatar">
                        <?php if (!empty($conv['other_avatar_path']) && file_exists(__DIR__ . '/../../../' . $conv['other_avatar_path'])): ?>
                            <img src="/<?= htmlspecialchars($conv['other_avatar_path']) ?>" alt="Avatar">
                        <?php else: ?>
                            <div class="avatar-placeholder">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="conversation-info">
                        <h3 class="conversation-name"><?= htmlspecialchars($conv['other_galactic_name']) ?></h3>
                        <p class="conversation-origin"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $conv['other_origin_type']))) ?></p>
                        <?php if (!empty($conv['last_message'])): ?>
                            <p class="conversation-last-message"><?= htmlspecialchars(substr($conv['last_message'], 0, 60)) ?><?= strlen($conv['last_message']) > 60 ? '...' : '' ?></p>
                        <?php else: ?>
                            <p class="conversation-last-message empty">Aucun message encore</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="conversation-meta">
                        <?php if (!empty($conv['last_message_time'])): ?>
                            <span class="conversation-time"><?= date('d/m/Y H:i', $conv['last_message_time']) ?></span>
                        <?php endif; ?>
                        <span class="conversation-count"><?= $conv['message_count'] ?? 0 ?> message<?= ($conv['message_count'] ?? 0) > 1 ? 's' : '' ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <footer class="navigation-footer">
        <a href="/match/revealed" class="btn btn-secondary-outline">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Voir mes Révélations</span>
        </a>
        </footer>
    </article>
</section>

