<section class="dashboard-container">
    <div class="portal-glow"></div>
    
    <?php if (isset($flash_success)): ?>
        <div class="flash-message flash-success">
            <?php echo htmlspecialchars($flash_success); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($flash_error)): ?>
        <div class="flash-message flash-error">
            <?php echo htmlspecialchars($flash_error); ?>
        </div>
    <?php endif; ?>
    
    <!-- En-tête avec IA -->
    <header class="dashboard-header">
        <div class="ia-orb-container" data-narration="Bienvenue sur votre tableau de bord, <?= htmlspecialchars($galactic_name) ?>. J'ai compilé un rapport complet de votre activité diplomatique dans l'écosystème.">
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
        
        <div class="dashboard-header-text">
            <h1 class="dashboard-title">Tableau de Bord Galactique</h1>
            <p class="dashboard-subtitle">Vue d'ensemble de votre parcours, <strong><?= htmlspecialchars($galactic_name) ?></strong></p>
        </div>
    </header>
    
    <!-- Message de l'IA (personnalisé selon le score) -->
    <article class="ia-global-message ia-message-<?= $ia_message['type'] ?>">
        <div class="ia-message-icon">
            <span class="ia-message-emoji"><?= $ia_message['icon'] ?></span>
        </div>
        <div class="ia-message-content">
            <h2 class="ia-message-title"><?= htmlspecialchars($ia_message['title']) ?></h2>
            <p class="ia-message-text"><?= $ia_message['message'] ?></p>
        </div>
    </article>
    
    <!-- État diplomatique global -->
    <article class="diplomatic-state">
        <h2 class="section-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 6v6l4 2"></path>
            </svg>
            État Diplomatique Global
        </h2>
        
        <!-- Score diplomatique -->
        <div class="diplomatic-score-container">
            <div class="score-visual">
                <svg class="score-circle" viewBox="0 0 200 200">
                    <circle class="score-bg" cx="100" cy="100" r="85" fill="none" stroke-width="20" stroke="rgba(95, 179, 162, 0.1)"></circle>
                    <circle class="score-fill" cx="100" cy="100" r="85" fill="none" stroke-width="20" 
                            stroke="url(#scoreGradient)" 
                            stroke-dasharray="534" 
                            stroke-dashoffset="<?= 534 - ($stats['diplomatic_score'] / 100 * 534) ?>"
                            transform="rotate(-90 100 100)"></circle>
                    <defs>
                        <linearGradient id="scoreGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:var(--primary-soft);stop-opacity:1" />
                            <stop offset="100%" style="stop-color:var(--primary-green);stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
                <div class="score-value">
                    <span class="score-number"><?= $stats['diplomatic_score'] ?></span>
                    <span class="score-label">Score</span>
                </div>
            </div>
            <div class="score-description">
                <h3>Indice de Contribution Galactique</h3>
                <p>Ce score reflète votre engagement dans l'écosystème, la qualité de vos interactions et votre impact sur l'harmonie collective.</p>
            </div>
        </div>
        
        <!-- Statistiques détaillées -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-value"><?= $stats['total_matches'] ?></span>
                    <span class="stat-label">Rencontres totales</span>
                </div>
            </div>
            
            <div class="stat-card stat-highlighted">
                <div class="stat-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-value"><?= $stats['revealed'] ?></span>
                    <span class="stat-label">Révélations</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-value"><?= $stats['total_messages'] ?></span>
                    <span class="stat-label">Messages échangés</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <div class="stat-info">
                    <span class="stat-value"><?= $stats['accepted'] ?></span>
                    <span class="stat-label">Acceptations</span>
                </div>
            </div>
        </div>
    </article>
    
    <!-- Historique des rencontres récentes -->
    <article class="recent-encounters">
        <h2 class="section-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v20M2 12h20"></path>
            </svg>
            Historique des Rencontres
        </h2>
        
        <?php if (empty($recent_matches)): ?>
            <div class="no-encounters">
                <div class="no-encounters-icon">🌌</div>
                <p>Aucune rencontre révélée pour le moment.</p>
                <a href="/match" class="btn btn-primary-inline">
                    <span>Découvrir les suggestions</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        <?php else: ?>
            <div class="encounters-list">
                <?php foreach ($recent_matches as $match): ?>
                    <?php
                        // Déterminer la couleur selon le type de compatibilité
                        $compatColors = [
                            'harmonious' => 'var(--harmonious)',
                            'unstable' => 'var(--unstable)',
                            'improbable' => 'var(--improbable)',
                            'dangerous' => 'var(--dangerous)'
                        ];
                        $borderColor = $compatColors[$match['compatibility_type']] ?? 'var(--primary-green)';
                    ?>
                    <div class="encounter-card" style="border-left-color: <?= $borderColor ?>;">
                        <div class="encounter-avatar">
                            <?php if (!empty($match['avatar_path']) && file_exists(__DIR__ . '/../../../' . $match['avatar_path'])): ?>
                                <img src="/<?= htmlspecialchars($match['avatar_path']) ?>" alt="Avatar">
                            <?php else: ?>
                                <div class="avatar-placeholder-dash">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="encounter-info">
                            <h3 class="encounter-name"><?= htmlspecialchars($match['galactic_name']) ?></h3>
                            <p class="encounter-origin"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $match['origin_type']))) ?></p>
                            <span class="encounter-compat-badge compat-<?= $match['compatibility_type'] ?>">
                                <?php
                                    $labels = [
                                        'harmonious' => 'Harmonieux',
                                        'unstable' => 'Instable',
                                        'improbable' => 'Improbable',
                                        'dangerous' => 'Risqué'
                                    ];
                                    echo htmlspecialchars($labels[$match['compatibility_type']] ?? $match['compatibility_type']);
                                ?>
                            </span>
                        </div>
                        <div class="encounter-actions">
                            <a href="/chat?match_id=<?= $match['match_id'] ?>" class="btn-encounter-action" title="Échanger">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </a>
                            <a href="/match/result?match_id=<?= $match['match_id'] ?>" class="btn-encounter-action" title="Évaluer">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 11l3 3L22 4"></path>
                                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="encounters-footer">
                <a href="/match/revealed" class="link-view-all">
                    <span>Voir toutes les révélations</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        <?php endif; ?>
    </article>
    
    <!-- Actions rapides -->
    <footer class="dashboard-actions">
        <h2 class="section-title">Actions Rapides</h2>
        <div class="quick-actions-grid">
            <a href="/match" class="action-quick-card">
                <div class="action-quick-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M16 12l-4-4-4 4M12 16V8"></path>
                    </svg>
                </div>
                <h3>Nouvelles Suggestions</h3>
                <span class="quick-badge"><?= $stats['suggested'] ?></span>
            </a>
            
            <a href="/match/revealed" class="action-quick-card">
                <div class="action-quick-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M12 1v6M12 17v6M4.22 4.22l4.24 4.24M15.54 15.54l4.24 4.24M1 12h6M17 12h6M4.22 19.78l4.24-4.24M15.54 8.46l4.24-4.24"></path>
                    </svg>
                </div>
                <h3>Révélations</h3>
                <span class="quick-badge"><?= $stats['revealed'] ?></span>
            </a>
            
            <a href="/chat" class="action-quick-card">
                <div class="action-quick-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <h3>Échanges</h3>
            </a>
            
            <a href="/profile" class="action-quick-card">
                <div class="action-quick-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <h3>Mon Profil</h3>
            </a>
        </div>
    </footer>
</section>

