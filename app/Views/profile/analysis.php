<section class="analysis-container">
    <div class="portal-glow"></div>
    
    <!-- Orbe IA centrale avec animations -->
    <div class="analysis-orb-wrapper">
        <div class="ia-orb-container-large" id="ia-orb-analyzer" data-narration="   Votre profil est stable et harmonieux. Vous êtes prêt à rencontrer d'autres formes de vie. L'écosystème vous accueille.">
            <!-- Anneaux d'analyse -->
            <div class="analysis-ring ring-1"></div>
            <div class="analysis-ring ring-2"></div>
            <div class="analysis-ring ring-3"></div>
            <div class="analysis-ring ring-4"></div>
            
            <!-- Cœur de l'orbe -->
            <div class="ia-orb-core-large">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
                <div class="particle particle-5"></div>
                <div class="particle particle-6"></div>
                <div class="particle particle-7"></div>
                <div class="particle particle-8"></div>
            </div>
        </div>
        
        <!-- Nom de l'IA -->
        <div class="ia-name-centered">
            <h2>ASTRÆA</h2>
            <p>Analyse en cours...</p>
        </div>
    </div>
    
    <!-- Messages évolutifs -->
    <article class="analysis-messages">
        <div class="analysis-message" id="message-1" data-delay="1000">
            <p class="analysis-text">Analyse des compatibilités biologiques...</p>
        </div>
        
        <div class="analysis-message" id="message-2" data-delay="3500">
            <p class="analysis-text">Évaluation des tensions potentielles...</p>
        </div>
        
        <div class="analysis-message" id="message-3" data-delay="6000">
            <p class="analysis-text">Calibrage des harmonies cosmiques...</p>
        </div>
        
        <div class="analysis-message" id="message-4" data-delay="8500">
            <p class="analysis-text">Vérification de la stabilité du profil...</p>
        </div>
        
        <!-- Message final -->
        <div class="analysis-message analysis-final" id="message-final" data-delay="11000">
            <div class="final-icon">✓</div>
            <h3 class="final-title">Validation Complète</h3>
            <p class="final-text">
                <strong><?php echo htmlspecialchars($galactic_name); ?></strong>, votre profil est <em>stable et harmonieux</em>.<br>
                Vous êtes prêt à rencontrer d'autres formes de vie.
            </p>
            <p class="final-subtitle">L'écosystème vous accueille 🌟</p>
            
            <div class="final-actions">
                <a href="/match" class="btn btn-primary" id="continue-btn">
                    <span>Découvrir vos Harmonies</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </article>
</section>

