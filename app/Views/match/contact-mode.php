<section class="portal-entrance-split">
    <div class="portal-glow"></div>
    
    <!-- Partie gauche : IA -->
    <aside class="portal-ia-side">
        <a href="/match/detail?id=<?= $match['id'] ?>" class="back-button">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"></path>
            </svg>
        </a>
        
        <div class="ia-orb-container" id="ia-orb-narrator" data-narration="Choisissez la manière dont vous souhaitez engager cette connexion avec <?= htmlspecialchars($other_user['galactic_name']) ?>. Chaque mode reflète une intention, une énergie particulière.">
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
            <p>Choix du Mode de Contact</p>
        </div>
        
        <div class="ia-message">
            <p>Chaque mode reflète une intention. Choisissez celui qui résonne avec votre essence.</p>
        </div>
    </aside>
    
    <!-- Partie droite : Contenu -->
    <article class="portal-content-side">
        <header class="portal-content-header">
            <h1 class="intro-title">Mode de Contact</h1>
            <p class="intro-subtitle">Comment souhaitez-vous établir cette connexion avec <strong><?= htmlspecialchars($other_user['galactic_name']) ?></strong> ?</p>
        </header>
        <!-- Les 3 modes de contact -->
        <div class="contact-modes-grid">
            <!-- Mode 1 : Message émotionnel -->
            <div class="mode-card mode-emotional">
                <div class="mode-icon">
                    <span class="mode-emoji">💌</span>
                </div>
                
                <h3 class="mode-title">Message Émotionnel</h3>
                
                <div class="mode-description">
                    <p>
                        Exprimez votre ressenti authentique, partagez ce qui résonne en vous. 
                        Un message du cœur, direct et sincère, sans filtre ni protocole.
                    </p>
                </div>
                
                <div class="mode-characteristics">
                    <div class="characteristic">
                        <strong>Niveau d'engagement :</strong>
                        <div class="engagement-bar">
                            <div class="engagement-fill high"></div>
                        </div>
                        <span class="engagement-label">Élevé</span>
                    </div>
                    
                    <div class="characteristic">
                        <strong>Niveau de risque :</strong>
                        <div class="risk-bar">
                            <div class="risk-fill medium"></div>
                        </div>
                        <span class="risk-label">Modéré</span>
                    </div>
                </div>
                
                <div class="mode-note">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>Recommandé pour les connexions harmonieuses et authentiques</span>
                </div>
                
                <form action="/match/accept" method="POST" class="mode-select-form">
                    <input type="hidden" name="match_id" value="<?= $match['id'] ?>">
                    <input type="hidden" name="contact_mode" value="emotional">
                    <button type="submit" class="btn btn-select-mode">
                        <span>Choisir ce mode</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- Mode 2 : Protocole diplomatique -->
            <div class="mode-card mode-diplomatic">
                <div class="mode-icon">
                    <span class="mode-emoji">🕊️</span>
                </div>
                
                <h3 class="mode-title">Protocole Diplomatique</h3>
                
                <div class="mode-description">
                    <p>
                        Établissez un contact respectueux et structuré, en suivant les codes de courtoisie cosmique. 
                        Une approche prudente, élégante et progressive.
                    </p>
                </div>
                
                <div class="mode-characteristics">
                    <div class="characteristic">
                        <strong>Niveau d'engagement :</strong>
                        <div class="engagement-bar">
                            <div class="engagement-fill medium"></div>
                        </div>
                        <span class="engagement-label">Modéré</span>
                    </div>
                    
                    <div class="characteristic">
                        <strong>Niveau de risque :</strong>
                        <div class="risk-bar">
                            <div class="risk-fill low"></div>
                        </div>
                        <span class="risk-label">Faible</span>
                    </div>
                </div>
                
                <div class="mode-note">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>Idéal pour les connexions complexes ou instables</span>
                </div>
                
                <form action="/match/accept" method="POST" class="mode-select-form">
                    <input type="hidden" name="match_id" value="<?= $match['id'] ?>">
                    <input type="hidden" name="contact_mode" value="diplomatic">
                    <button type="submit" class="btn btn-select-mode">
                        <span>Choisir ce mode</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- Mode 3 : Dialogue guidé par l'IA -->
            <div class="mode-card mode-guided">
                <div class="mode-icon">
                    <span class="mode-emoji">🌱</span>
                </div>
                
                <h3 class="mode-title">Dialogue Guidé par l'IA</h3>
                
                <div class="mode-description">
                    <p>
                        Laissez ASTRÆA faciliter vos premiers échanges. Elle proposera des sujets, 
                        des questions et veillera à l'harmonie de la conversation.
                    </p>
                </div>
                
                <div class="mode-characteristics">
                    <div class="characteristic">
                        <strong>Niveau d'engagement :</strong>
                        <div class="engagement-bar">
                            <div class="engagement-fill low"></div>
                        </div>
                        <span class="engagement-label">Progressif</span>
                    </div>
                    
                    <div class="characteristic">
                        <strong>Niveau de risque :</strong>
                        <div class="risk-bar">
                            <div class="risk-fill minimal"></div>
                        </div>
                        <span class="risk-label">Minimal</span>
                    </div>
                </div>
                
                <div class="mode-note">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>Parfait pour découvrir sereinement une entité inconnue</span>
                </div>
                
                <form action="/match/accept" method="POST" class="mode-select-form">
                    <input type="hidden" name="match_id" value="<?= $match['id'] ?>">
                    <input type="hidden" name="contact_mode" value="guided">
                    <button type="submit" class="btn btn-select-mode">
                        <span>Choisir ce mode</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Message ASTRÆA -->
        <footer class="contact-mode-footer">
            <div class="ia-advice-card">
                <div class="ia-advice-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                </div>
                <div class="ia-advice-content">
                    <strong>ASTRÆA :</strong>
                    <p>
                        Quel que soit le mode choisi, rappelez-vous que toute connexion authentique nécessite 
                        du temps, de l'écoute et du respect mutuel. Il n'y a pas de mauvais choix, 
                        seulement celui qui résonne avec votre intention du moment.
                    </p>
                </div>
            </div>
        </footer>
    </article>
</section>

