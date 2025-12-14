<section class="result-container">
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
    <header class="result-header">
        <div class="ia-orb-container" data-narration="Après analyse approfondie de votre connexion avec <?= htmlspecialchars($other_user['galactic_name']) ?>, j'ai établi un diagnostic complet de votre relation.">
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
        
        <div class="result-header-text">
            <h1 class="result-title">Évaluation du Lien</h1>
            <p class="result-subtitle">Diagnostic de votre connexion avec <strong><?= htmlspecialchars($other_user['galactic_name']) ?></strong></p>
        </div>
    </header>
    
    <!-- Carte de résultat -->
    <article class="result-card result-<?= $link_result['color'] ?>">
        <div class="result-icon">
            <span class="result-emoji"><?= $link_result['emoji'] ?></span>
        </div>
        
        <div class="result-content">
            <h2 class="result-verdict"><?= htmlspecialchars($link_result['title']) ?></h2>
            
            <p class="result-description">
                <?= htmlspecialchars($link_result['description']) ?>
            </p>
            
            <!-- Message IA -->
            <div class="result-ia-analysis">
                <div class="ia-analysis-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                </div>
                <div class="ia-analysis-content">
                    <strong>ASTRÆA :</strong> <?= htmlspecialchars($link_result['ia_message']) ?>
                </div>
            </div>
            
            <!-- Statistiques -->
            <div class="result-stats">
                <div class="stat-item">
                    <span class="stat-label">Messages échangés</span>
                    <span class="stat-value"><?= $message_count ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Type de compatibilité</span>
                    <span class="stat-value"><?= htmlspecialchars(ucfirst($match['compatibility_type'])) ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Statut</span>
                    <span class="stat-value">Révélé</span>
                </div>
            </div>
        </div>
    </article>
    
    <!-- Actions (CTA) -->
    <footer class="result-actions">
        <h3 class="actions-title">Quelle est la suite ?</h3>
        
        <div class="actions-grid">
            <!-- CTA Primaire -->
            <div class="action-card action-primary">
                <div class="action-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h4 class="action-title"><?= htmlspecialchars($link_result['cta_primary']) ?></h4>
                <p class="action-description">Maintenir le lien et poursuivre les échanges.</p>
                <a href="/chat?match_id=<?= $match_id ?>" class="btn btn-action-primary">
                    <span>Continuer</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            <!-- CTA Secondaire (si disponible) -->
            <?php if ($link_result['cta_secondary']): ?>
                <div class="action-card action-secondary">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            <path d="M12 7v6M9 10h6"></path>
                        </svg>
                    </div>
                    <h4 class="action-title"><?= htmlspecialchars($link_result['cta_secondary']) ?></h4>
                    <p class="action-description">ASTRÆA peut faciliter vos échanges futurs.</p>
                    <form action="/match/request-mediation" method="POST" style="display: inline;">
                        <input type="hidden" name="match_id" value="<?= $match_id ?>">
                        <button type="submit" class="btn btn-action-secondary">
                            <span>Demander</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            <?php endif; ?>
            
            <!-- CTA Tertiaire -->
            <?php if ($link_result['cta_tertiary']): ?>
                <div class="action-card action-tertiary">
                    <div class="action-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </div>
                    <h4 class="action-title"><?= htmlspecialchars($link_result['cta_tertiary']) ?></h4>
                    <p class="action-description">Clore ce lien de manière respectueuse et consciente.</p>
                    <form action="/match/end-peacefully" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir mettre fin à cette relation ?');">
                        <input type="hidden" name="match_id" value="<?= $match_id ?>">
                        <button type="submit" class="btn btn-action-tertiary">
                            <span>Confirmer</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="result-footer-links">
            <a href="/match/revealed" class="link-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                Retour aux harmonies révélées
            </a>
        </div>
    </footer>
</section>

