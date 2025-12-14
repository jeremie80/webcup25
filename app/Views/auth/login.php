<?php $hideHeader = true; ?>
<section class="portal-entrance-split">
    <div class="portal-glow"></div>
    
    <!-- Partie gauche : IA (toujours visible) -->
    <aside class="portal-ia-side">
        <div class="ia-orb-container" id="ia-orb-narrator" data-narration="Bienvenue à nouveau, voyageur. Saisissez votre nom galactique pour retrouver votre essence cosmique et reprendre votre voyage parmi les harmonies.">
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
            <p>Intelligence Bienveillante</p>
        </div>
        
        <div class="ia-message">
            <p>ASTRÆA: Votre nom galactique est la clé de votre identité cosmique.</p>
        </div>
    </aside>
    
    <!-- Partie droite : Formulaire de connexion -->
    <article class="portal-content-side">
        <header class="form-header">
            <h1 class="form-title">Connexion</h1>
            <p class="form-subtitle">Retrouvez votre signature cosmique</p>
        </header>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="/auth/authenticate" class="profile-form" id="loginForm">
            
            <div class="form-group">
                <label for="galactic_name">Nom Galactique</label>
                <input 
                    type="text" 
                    id="galactic_name" 
                    name="galactic_name" 
                    placeholder="Saisissez votre nom galactique" 
                    required
                    maxlength="200"
                    value="<?php echo htmlspecialchars($galactic_name ?? ''); ?>"
                >
                <small class="form-help">ASTRÆA: Votre nom galactique unique vous identifie dans l'écosystème.</small>
            </div>
            
            <div class="form-actions form-actions-split">
                <button type="submit" class="btn btn-primary">
                    <span>Se connecter</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                </button>
                
                <a href="/auth/start" class="btn btn-secondary-outline">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    <span>Créer ma signature</span>
                </a>
            </div>
            
        </form>
        
        <div class="auth-helper-text">
            <p>Connectez-vous ou créez une nouvelle signature si c'est votre première visite</p>
        </div>
        
        <p class="form-note">
            La connexion est sécurisée par votre signature galactique unique.
        </p>
    </article>
</section>

