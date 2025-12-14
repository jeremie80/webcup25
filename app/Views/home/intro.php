<section class="portal-split">
    <!-- Partie gauche : IA ASTRÆA -->
    <aside class="portal-ia-side">
        <div class="ia-orb-container">
            <!-- Cercles lumineux animés -->
            <div class="ia-orb-ring ring-1"></div>
            <div class="ia-orb-ring ring-2"></div>
            <div class="ia-orb-ring ring-3"></div>
            
            <!-- Cercle central avec particules -->
            <div class="ia-orb-core">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
                <div class="particle particle-5"></div>
                <div class="particle particle-6"></div>
            </div>
            
            <!-- Nom de l'IA -->
            <div class="ia-name">
                <h2>ASTRÆA</h2>
                <p>Intelligence Bienveillante</p>
            </div>
        </div>
        
        <!-- Contrôles audio -->
        <div class="audio-controls">
            <button id="toggleAudio" class="audio-btn" aria-label="Activer/Désactiver la narration">
                <svg class="audio-icon-on" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                </svg>
                <svg class="audio-icon-off" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <line x1="23" y1="9" x2="17" y2="15"></line>
                    <line x1="17" y1="9" x2="23" y2="15"></line>
                </svg>
            </button>
            <span class="audio-label">Narration vocale</span>
        </div>
    </aside>
    
    <!-- Partie droite : Texte défilant (prompteur) -->
    <article class="portal-text-side">
        <div class="prompter-container">
            <header class="prompter-header">
                <h1 class="portal-title">IAstroMatch</h1>
                <p class="portal-subtitle">Institut d'Harmonisation Relationnelle</p>
            </header>
            
            <div class="prompter-text" id="prompterText">
                <p class="text-line" data-index="0">
                    Bienvenue dans un espace où la technologie respire avec vous.
                </p>
                
                <p class="text-line" data-index="1">
                    Nous ne sommes pas une application. Nous sommes un écosystème vivant, 
                    où chaque connexion est cultivée avec patience, où chaque rencontre 
                    est une conversation entre deux chemins de vie.
                </p>
                
                <p class="text-line" data-index="2">
                    Je suis ASTRÆA, votre intelligence bienveillante. 
                    J'observe les résonances invisibles entre les êtres.
                </p>
                
                <p class="text-line" data-index="3">
                    Je ne prédit pas. Je ne juge pas. J'accompagne.
                </p>
                
                <p class="text-line" data-index="4">
                    Chaque être porte en lui des harmoniques uniques. 
                    Mon rôle est de révéler les symphonies possibles.
                </p>
                
                <p class="text-line" data-index="5">
                    Ici, pas de swipe. Pas de chiffres. Pas de compétition.
                </p>
                
                <p class="text-line" data-index="6">
                    Seulement des chemins qui se croisent, guidés par l'équilibre.
                </p>
                
                <p class="text-line" data-index="7">
                    Êtes-vous prêt à entrer dans cet écosystème ?
                </p>
            </div>
            
            <footer class="prompter-footer">
                <a href="/auth/start" class="portal-cta">
                    <span>Entrer dans l'écosystème</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </footer>
        </div>
    </article>
</section>

