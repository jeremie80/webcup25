<section class="match-container">
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
    
    <!-- En-tête avec IA -->
    <header class="match-header">
        <div class="ia-orb-container" data-narration="<?= htmlspecialchars($narration_message) ?>">
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
        
        <div class="match-header-text">
            <h1 class="match-title">Harmonies Cosmiques</h1>
            <p class="match-subtitle">Découvrez les voyageurs compatibles avec votre essence, <strong><?php echo htmlspecialchars($galactic_name); ?></strong></p>
        </div>
    </header>
    
    <?php if (empty($matches)): ?>
        <!-- Aucun match disponible -->
        <article class="no-matches">
            <div class="no-matches-icon">🌌</div>
            <h2><?= htmlspecialchars($no_match_message['title']) ?></h2>
            <p><?= htmlspecialchars($no_match_message['description']) ?></p>
        </article>
    <?php else: ?>
        <!-- Grille de cartes de profils -->
        <article class="matches-grid">
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
                
                <div class="match-card match-<?php echo $compat['type']; ?>">
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
                    
                    <!-- Actions -->
                    <div class="match-actions">
                        <a href="/match/detail?id=<?php echo $match['match_id']; ?>" class="btn btn-detail">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <span>En savoir plus</span>
                        </a>
                        
                        <form method="POST" action="/match/reject" style="display: inline;">
                            <input type="hidden" name="match_id" value="<?php echo $match['match_id']; ?>">
                            <button type="submit" class="btn btn-reject">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                                <span>Rejeter</span>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>
</section>

