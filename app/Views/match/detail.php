<section class="portal-entrance-split">
    <div class="portal-glow"></div>
    
    <!-- Partie gauche : IA -->
    <aside class="portal-ia-side">
        <a href="<?= ($match['status'] === 'revealed' || $match['status'] === 'accepted') ? '/match/revealed' : '/match' ?>" class="back-button">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
        </a>
        
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
            <p>Analyse Pré-Rencontre</p>
        </div>
        
        <div class="ia-message">
            <p>Observez l'essence avant l'apparence. Chaque détail révèle une facette de cette conscience.</p>
        </div>
    </aside>
    
    <!-- Partie droite : Contenu -->
    <article class="portal-content-side">
        <header class="portal-content-header">
            <h1 class="intro-title">Entité en Observation</h1>
            <p class="intro-subtitle">Pré-rencontre — L'essence avant l'apparence</p>
        </header>
        <!-- Indicateur de compatibilité visuel (sans %) -->
        <div class="compatibility-visual match-<?= $compatibility['type'] ?>">
            <div class="compat-rings">
                <div class="compat-ring ring-outer"></div>
                <div class="compat-ring ring-middle"></div>
                <div class="compat-ring ring-inner"></div>
            </div>
            <div class="compat-center">
                <span class="compat-emoji-large"><?= $compatibility['emoji'] ?></span>
            </div>
            <p class="compat-visual-label"><?= htmlspecialchars($compatibility['label']) ?></p>
        </div>
        
        <!-- Description narrative de l'entité -->
        <div class="detail-section narrative-section">
            <h3 class="section-title">Portrait Narratif</h3>
            
            <div class="narrative-card">
                <div class="narrative-icon-abstract">
                    <div class="abstract-shape shape-1"></div>
                    <div class="abstract-shape shape-2"></div>
                    <div class="abstract-shape shape-3"></div>
                </div>
                
                <div class="narrative-content">
                    <h4 class="narrative-name"><?= htmlspecialchars($other_user['galactic_name']) ?></h4>
                    <p class="narrative-origin-tag">
                        <?php 
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
                        echo htmlspecialchars($originLabels[$other_user['origin_type']] ?? $other_user['origin_type']);
                        ?>
                    </p>
                    
                    <div class="narrative-description">
                        <?php
                        // Génération narrative basée sur les attributs
                        $atmosphereNarrative = [
                            'oxygen' => "Cette entité respire l'air pur des mondes vivants, son existence rythmée par les cycles naturels de la vie.",
                            'methane' => "Évoluant dans des atmosphères exotiques, cette forme de vie a développé une résilience extraordinaire face aux environnements les plus extrêmes.",
                            'vacuum' => "Habitant le vide spatial, cette conscience défie les lois conventionnelles de l'existence. Sa nature transcende la matière ordinaire.",
                            'aquatic' => "Les profondeurs océaniques sont son royaume. Cette entité vit en symbiose avec les flux aquatiques, ondulant entre les courants cosmiques."
                        ];
                        
                        $commNarrative = [
                            'verbal' => "La parole est son vecteur de connexion, chaque mot choisi avec soin pour tisser des ponts entre les consciences.",
                            'telepathic' => "Au-delà des mots, cette entité communique par résonance mentale directe. Les pensées deviennent un langage partagé.",
                            'chemical' => "Par des signaux subtils et des essences volatiles, cette conscience s'exprime dans un langage invisible mais profondément ressenti.",
                            'luminous' => "La lumière est son alphabet. Chaque variation, chaque éclat porte un sens, une émotion, une intention."
                        ];
                        
                        $techNarrative = [
                            'organic' => "En harmonie avec les cycles naturels, cette entité privilégie les solutions vivantes, respirantes, évolutives.",
                            'hybrid' => "À la croisée des chemins, elle fusionne l'organique et le synthétique dans une danse équilibrée entre nature et innovation.",
                            'advanced' => "Maîtrisant des technologies que peu comprennent, elle navigue dans des dimensions conceptuelles où la science devient art."
                        ];
                        
                        $valueNarrative = [
                            'harmony' => "L'équilibre guide chacune de ses décisions. Pour elle, le conflit n'est qu'un déséquilibre temporaire à résoudre.",
                            'survival' => "Forgée par l'adversité, la préservation est gravée dans son essence. Chaque action vise la continuité, la persistance.",
                            'expansion' => "Son regard se tourne toujours vers l'horizon suivant. Grandir, explorer, conquérir de nouveaux territoires de pensée et d'espace.",
                            'knowledge' => "La quête de compréhension anime son existence. Chaque question est une porte, chaque réponse ouvre mille chemins."
                        ];
                        ?>
                        
                        <p class="narrative-paragraph">
                            <?= $atmosphereNarrative[$other_profile['atmosphere_type']] ?? '' ?>
                        </p>
                        
                        <p class="narrative-paragraph">
                            <?= $commNarrative[$other_profile['communication_mode']] ?? '' ?>
                        </p>
                        
                        <p class="narrative-paragraph">
                            <?= $techNarrative[$other_profile['tech_level']] ?? '' ?>
                        </p>
                        
                        <p class="narrative-paragraph">
                            <?= $valueNarrative[$other_profile['core_value']] ?? '' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Analyse IA : Points de convergence et de tension -->
        <div class="detail-section analysis-section">
            <h3 class="section-title">Analyse de Compatibilité — ASTRÆA</h3>
            
            <div class="analysis-grid">
                <!-- Points de convergence -->
                <div class="analysis-card convergence-card">
                    <div class="analysis-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </div>
                    <h4 class="analysis-title">Points de Convergence</h4>
                    <ul class="analysis-list">
                        <?php
                        // Générer des points de convergence basés sur la compatibilité
                        $convergencePoints = [];
                        
                        // Logique de convergence (à adapter selon votre algorithme)
                        if ($compatibility['type'] === 'harmonious') {
                            $convergencePoints = [
                                "Vos valeurs fondamentales résonnent en harmonie naturelle",
                                "Une compréhension mutuelle facilitée par des modes de pensée similaires",
                                "Potentiel d'enrichissement mutuel sans friction majeure"
                            ];
                        } elseif ($compatibility['type'] === 'unstable') {
                            $convergencePoints = [
                                "Curiosité mutuelle pour des perspectives différentes",
                                "Possibilité d'apprentissage par la différence",
                                "Complémentarité potentielle dans certains domaines"
                            ];
                        } elseif ($compatibility['type'] === 'improbable') {
                            $convergencePoints = [
                                "Une rencontre qui défie les probabilités habituelles",
                                "Potentiel de découverte de territoires inexplorés",
                                "La différence comme source d'innovation"
                            ];
                        } else { // dangerous
                            $convergencePoints = [
                                "Une intensité qui peut créer des liens profonds",
                                "La tension comme catalyseur de transformation",
                                "Possibilité de croissance par le défi"
                            ];
                        }
                        
                        foreach ($convergencePoints as $point):
                        ?>
                            <li class="convergence-point">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <?= htmlspecialchars($point) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- Points de tension -->
                <div class="analysis-card tension-card">
                    <div class="analysis-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </div>
                    <h4 class="analysis-title">Points de Tension</h4>
                    <ul class="analysis-list">
                        <?php
                        // Générer des points de tension
                        $tensionPoints = [];
                        
                        if ($compatibility['type'] === 'harmonious') {
                            $tensionPoints = [
                                "Risque de stagnation dans une zone de confort",
                                "Nécessité de cultiver la nouveauté activement",
                                "Attention à ne pas perdre son individualité dans l'harmonie"
                            ];
                        } elseif ($compatibility['type'] === 'unstable') {
                            $tensionPoints = [
                                "Des ajustements constants seront nécessaires",
                                "Communication cruciale pour éviter les malentendus",
                                "Équilibre délicat entre proximité et distance"
                            ];
                        } elseif ($compatibility['type'] === 'improbable') {
                            $tensionPoints = [
                                "Visions du monde potentiellement divergentes",
                                "Efforts importants requis pour maintenir la connexion",
                                "Risque d'incompréhension malgré les bonnes intentions"
                            ];
                        } else { // dangerous
                            $tensionPoints = [
                                "Intensité émotionnelle élevée, potentiellement déstabilisante",
                                "Risque de conflit si les différences ne sont pas respectées",
                                "Nécessite maturité et conscience de soi de part et d'autre"
                            ];
                        }
                        
                        foreach ($tensionPoints as $point):
                        ?>
                            <li class="tension-point">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                <?= htmlspecialchars($point) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Synthèse ASTRÆA -->
            <div class="ia-synthesis-card">
                <div class="ia-synthesis-header">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                    <strong>ASTRÆA — Synthèse</strong>
                </div>
                <p class="ia-synthesis-text">
                    <?= nl2br(htmlspecialchars($compatibility['description'])) ?>
                </p>
            </div>
        </div>
        
        <!-- CTA -->
        <footer class="match-detail-actions">
            <?php if ($match['status'] === 'suggested'): ?>
                <a href="/match/contact-mode?match_id=<?= $match['id'] ?>" class="btn btn-initiate-contact">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Initier un premier contact</span>
                </a>
                
                <form action="/match/reject" method="POST" class="cta-form">
                    <input type="hidden" name="match_id" value="<?= $match['id'] ?>">
                    <button type="submit" class="btn btn-reject-diplomatic">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                            <path d="M21 3v5h-5"></path>
                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                            <path d="M3 21v-5h5"></path>
                        </svg>
                        <span>Rejeter diplomatiquement</span>
                    </button>
                </form>
            <?php elseif ($match['status'] === 'revealed' || $match['status'] === 'accepted'): ?>
                <a href="/chat?match_id=<?= $match['id'] ?>" class="btn btn-continue-dialogue">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Poursuivre le dialogue</span>
                </a>
            <?php endif; ?>
        </footer>
    </article>
</section>
