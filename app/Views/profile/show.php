<section class="profile-container">
    <div class="portal-glow"></div>
    
    <header class="profile-header">
        <div class="ia-orb-container" id="ia-orb-narrator" data-narration="Bienvenue, <?= htmlspecialchars($galactic_name) ?>. Voici votre signature cosmique, l'empreinte unique de votre essence dans l'univers IAstroMatch.">
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
        <h1 class="profile-title">Mon Profil Cosmique</h1>
        <p class="profile-subtitle">Votre signature unique dans l'écosystème</p>
    </header>
    
    <div class="profile-content">
        <!-- Section identité -->
        <div class="profile-section">
            <h2 class="section-title">Identité Galactique</h2>
            
            <div class="profile-card">
                <div class="profile-avatar-container">
                    <?php if (!empty($profile['avatar_path']) && file_exists(__DIR__ . '/../../../' . $profile['avatar_path'])): ?>
                        <img src="/<?= htmlspecialchars($profile['avatar_path']) ?>" alt="Avatar de <?= htmlspecialchars($user['galactic_name']) ?>" class="profile-avatar">
                    <?php else: ?>
                        <div class="profile-avatar-placeholder">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="profile-identity">
                    <h3 class="galactic-name"><?= htmlspecialchars($user['galactic_name']) ?></h3>
                    <p class="origin-type">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $user['origin_type']))) ?>
                    </p>
                    <p class="bio-signature">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2a10 10 0 1 0 10 10H12V2z"></path>
                        </svg>
                        <code><?= htmlspecialchars(substr($user['bio_signature'], 0, 24)) ?>...</code>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Section attributs cosmiques -->
        <div class="profile-section">
            <h2 class="section-title">Attributs Cosmiques</h2>
            
            <div class="profile-attributes-grid">
                <div class="attribute-card">
                    <div class="attribute-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 16v-4"></path>
                            <path d="M12 8h.01"></path>
                        </svg>
                    </div>
                    <h3 class="attribute-title">Atmosphère</h3>
                    <p class="attribute-value"><?= htmlspecialchars(ucfirst($profile['atmosphere_type'])) ?></p>
                    <p class="attribute-description">
                        <?php
                        $atmosphereDesc = [
                            'oxygen' => 'Respire dans un environnement oxygéné',
                            'methane' => 'Prospère dans une atmosphère méthane',
                            'vacuum' => 'Existe dans le vide spatial',
                            'aquatic' => 'Vit dans un milieu aquatique'
                        ];
                        echo $atmosphereDesc[$profile['atmosphere_type']] ?? '';
                        ?>
                    </p>
                </div>
                
                <div class="attribute-card">
                    <div class="attribute-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                    </div>
                    <h3 class="attribute-title">Communication</h3>
                    <p class="attribute-value"><?= htmlspecialchars(ucfirst($profile['communication_mode'])) ?></p>
                    <p class="attribute-description">
                        <?php
                        $commDesc = [
                            'verbal' => 'Communique par la parole',
                            'telepathic' => 'Échange par télépathie',
                            'chemical' => 'S\'exprime par signaux chimiques',
                            'luminous' => 'Transmet par la lumière'
                        ];
                        echo $commDesc[$profile['communication_mode']] ?? '';
                        ?>
                    </p>
                </div>
                
                <div class="attribute-card">
                    <div class="attribute-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                    <h3 class="attribute-title">Technologie</h3>
                    <p class="attribute-value"><?= htmlspecialchars(ucfirst($profile['tech_level'])) ?></p>
                    <p class="attribute-description">
                        <?php
                        $techDesc = [
                            'organic' => 'Préfère les solutions organiques',
                            'hybrid' => 'Équilibre nature et technologie',
                            'advanced' => 'Maîtrise les technologies avancées'
                        ];
                        echo $techDesc[$profile['tech_level']] ?? '';
                        ?>
                    </p>
                </div>
                
                <div class="attribute-card">
                    <div class="attribute-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </div>
                    <h3 class="attribute-title">Valeur Fondamentale</h3>
                    <p class="attribute-value"><?= htmlspecialchars(ucfirst($profile['core_value'])) ?></p>
                    <p class="attribute-description">
                        <?php
                        $valueDesc = [
                            'harmony' => 'Recherche l\'équilibre et la paix',
                            'survival' => 'Priorité à la préservation',
                            'expansion' => 'Aspire à croître et explorer',
                            'knowledge' => 'Cherche la sagesse et la compréhension'
                        ];
                        echo $valueDesc[$profile['core_value']] ?? '';
                        ?>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Message ASTRÆA -->
        <div class="profile-section">
            <div class="ia-message-card">
                <div class="ia-message-header">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                    <strong>ASTRÆA</strong>
                </div>
                <p class="ia-message-text">
                    Votre profil cosmique est complet et harmonieux. Chaque attribut contribue à votre signature unique dans l'univers IAstroMatch. Continuez à explorer et à tisser des liens authentiques avec d'autres voyageurs.
                </p>
            </div>
        </div>
        
        <!-- Actions -->
        <footer class="profile-actions">
            <a href="/match" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span>Découvrir mes Harmonies</span>
            </a>
            <a href="/match/revealed" class="btn btn-secondary-outline">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Mes Connexions Révélées</span>
            </a>
        </footer>
    </div>
</section>

