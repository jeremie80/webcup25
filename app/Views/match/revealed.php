<section class="portal-entrance-split">
    <div class="portal-glow"></div>
    
    <!-- Partie gauche : IA -->
    <aside class="portal-ia-side">
        <div class="ia-orb-container" id="ia-orb-narrator" data-narration="<?= htmlspecialchars($narration_message) ?>">
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
            <p>Harmonies Révélées</p>
        </div>
        
        <div class="ia-message">
            <p>Les liens mutuels se dévoilent, <strong><?php echo htmlspecialchars($galactic_name); ?></strong>. Ces connexions ont été acceptées des deux côtés.</p>
        </div>
    </aside>
    
    <!-- Partie droite : Contenu -->
    <article class="portal-content-side">
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
        
        <header class="portal-content-header">
            <h1 class="intro-title">Harmonies Révélées</h1>
            <p class="intro-subtitle">Vos connexions mutuelles</p>
        </header>
    
        <?php if (empty($matches)): ?>
            <!-- Aucune révélation -->
            <div class="no-matches">
                <div class="no-matches-icon">✨</div>
                <h2>Aucune harmonie révélée pour le moment</h2>
                <p>Les révélations apparaissent lorsque deux voyageurs s'acceptent mutuellement. Explorez les <a href="/match" class="link-primary">suggestions</a> pour trouver vos harmonies.</p>
            </div>
        <?php else: ?>
            <!-- Grille de cartes révélées -->
            <div class="matches-grid">
            <?php foreach ($matches as $match): ?>
                <?php 
                    $user = $match['user'];
                    $profile = $match['profile'];
                    $compat = $match['compatibility'];
                    
                    // Labels traduits
                    $originLabels = [
                        'earth_renewed' => 'Terre Renouvelée',
                        'oceanic_world' => 'Monde Océanique',
                        'forest_megacity' => 'Mégacité Forestière',
                        'orbital_habitat' => 'Habitat Orbital',
                        'desert_solar' => 'Désert Solaire',
                        'synthetic_collective' => 'Collectif Synthétique',
                        'luminous_dimension' => 'Dimension Lumineuse',
                        'nomadic_fleet' => 'Flotte Nomade'
                    ];
                    
                    $atmosphereLabels = [
                        'oxygen' => 'Oxygène',
                        'methane' => 'Méthane',
                        'vacuum' => 'Vide spatial',
                        'aquatic' => 'Aquatique'
                    ];
                    
                    $commLabels = [
                        'verbal' => 'Verbal',
                        'telepathic' => 'Télépathique',
                        'chemical' => 'Chimique',
                        'luminous' => 'Lumineux'
                    ];
                    
                    $techLabels = [
                        'organic' => 'Organique',
                        'hybrid' => 'Hybride',
                        'advanced' => 'Avancé'
                    ];
                    
                    $valueLabels = [
                        'harmony' => 'Harmonie',
                        'survival' => 'Survie',
                        'expansion' => 'Expansion',
                        'knowledge' => 'Connaissance'
                    ];
                ?>
                
                <div class="match-card match-revealed match-<?php echo $compat['type']; ?>">
                    <!-- Badge de statut révélé -->
                    <div class="revealed-badge">
                        <span class="revealed-icon">✓</span>
                        <span class="revealed-label">Connexion Mutuelle</span>
                    </div>
                    
                    <!-- Badge de compatibilité -->
                    <div class="match-badge">
                        <span class="match-emoji"><?php echo $compat['emoji']; ?></span>
                        <span class="match-label"><?php echo htmlspecialchars($compat['label']); ?></span>
                    </div>
                    
                    <!-- Nom galactique -->
                    <div class="match-name">
                        <h3><?php echo htmlspecialchars($user['galactic_name']); ?></h3>
                        <p class="match-origin"><?php echo htmlspecialchars($originLabels[$user['origin_type']] ?? $user['origin_type']); ?></p>
                    </div>
                    
                    <!-- Caractéristiques -->
                    <div class="match-attributes">
                        <div class="match-attribute">
                            <span class="attr-icon">🌬️</span>
                            <span class="attr-label">Atmosphère</span>
                            <span class="attr-value"><?php echo htmlspecialchars($atmosphereLabels[$profile['atmosphere_type']] ?? $profile['atmosphere_type']); ?></span>
                        </div>
                        
                        <div class="match-attribute">
                            <span class="attr-icon">💬</span>
                            <span class="attr-label">Communication</span>
                            <span class="attr-value"><?php echo htmlspecialchars($commLabels[$profile['communication_mode']] ?? $profile['communication_mode']); ?></span>
                        </div>
                        
                        <div class="match-attribute">
                            <span class="attr-icon">⚙️</span>
                            <span class="attr-label">Technologie</span>
                            <span class="attr-value"><?php echo htmlspecialchars($techLabels[$profile['tech_level']] ?? $profile['tech_level']); ?></span>
                        </div>
                        
                        <div class="match-attribute">
                            <span class="attr-icon">✨</span>
                            <span class="attr-label">Valeur</span>
                            <span class="attr-value"><?php echo htmlspecialchars($valueLabels[$profile['core_value']] ?? $profile['core_value']); ?></span>
                        </div>
                    </div>
                    
                    <!-- Description IA (aléatoire) -->
                    <div class="match-description">
                        <p class="ia-analysis">
                            <strong>ASTRÆA:</strong> <?php echo htmlspecialchars(\App\Core\IALanguage::getCompatibilityDescription($compat['type'])); ?>
                        </p>
                    </div>
                    
                    <!-- Actions révélées -->
                    <div class="match-actions revealed-actions">
                        <a href="/chat?match_id=<?php echo $match['match_id']; ?>" class="btn btn-chat">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span>Échanger</span>
                        </a>
                        
                        <a href="/match/result?match_id=<?php echo $match['match_id']; ?>" class="btn btn-evaluate">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 11l3 3L22 4"></path>
                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                            </svg>
                            <span>Évaluer</span>
                        </a>
                        
                        <a href="/match/detail?id=<?php echo $match['match_id']; ?>" class="btn btn-detail">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span>En savoir plus</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Lien vers suggestions -->
        <div class="navigation-footer">
            <a href="/match" class="btn btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                <span>Retour aux suggestions</span>
            </a>
        </div>
    </article>
</section>

