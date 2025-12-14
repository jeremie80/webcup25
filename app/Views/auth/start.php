<?php $hideHeader = true; ?>
<section class="portal-entrance-split">
    <div class="portal-glow"></div>
    
    <!-- Partie gauche : IA (toujours visible) -->
    <aside class="portal-ia-side">
        <div class="ia-orb-container" id="ia-orb-narrator" data-narration="Ensemble, nous allons créer votre signature galactique, le reflet unique de votre essence. Attention : votre nom galactique doit être absolument unique dans tout l'écosystème. Si un autre voyageur porte déjà ce nom, il ne pourra pas être accepté. Chaque nom résonne avec une énergie particulière. Prenez le temps de choisir celui qui vous représente vraiment.">
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
            <p>Chaque nom résonne avec une énergie unique. Prenez le temps de choisir celui qui vous représente.</p>
        </div>
    </aside>
    
    <!-- Partie droite : Formulaire -->
    <article class="portal-content-side">
        <header class="form-header">
            <h1 class="form-title">Votre Identité Galactique</h1>
            <p class="form-subtitle">Commençons par créer votre signature cosmique</p>
        </header>
        
        <form method="POST" action="/auth/register" class="profile-form" id="profileForm">
            
            <div class="form-group">
                <label for="galactic_name">Nom Galactique</label>
                <input 
                    type="text" 
                    id="galactic_name" 
                    name="galactic_name" 
                    placeholder="Comment souhaitez-vous être appelé ?" 
                    required
                    maxlength="200"
                >
                <small class="form-help">ASTRÆA: Votre nom doit être unique dans l'écosystème. Il est la première note de votre symphonie.</small>
            </div>
            
            <div class="form-group">
                <label for="origin_type">Origine Cosmique</label>
                <select id="origin_type" name="origin_type" required>
                    <option value="">Choisissez votre origine...</option>
                    <option value="earth_renewed">🌍 Terre Renouvelée</option>
                    <option value="oceanic_world">🌊 Monde Océanique</option>
                    <option value="forest_megacity">🌳 Mégacité Forestière</option>
                    <option value="orbital_habitat">🛸 Habitat Orbital</option>
                    <option value="desert_solar">☀️ Désert Solaire</option>
                    <option value="synthetic_collective">🤖 Collectif Synthétique</option>
                    <option value="luminous_dimension">✨ Dimension Lumineuse</option>
                    <option value="nomadic_fleet">🚀 Flotte Nomade</option>
                </select>
                <small class="form-help">ASTRÆA: Votre origine influence les harmonies que nous découvrirons ensemble.</small>
            </div>
            
            <div class="form-actions form-actions-split">
                <button type="submit" class="btn btn-primary">
                    <span>Créer ma Signature</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <a href="/auth/login" class="btn btn-secondary-outline">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    <span>Se connecter</span>
                </a>
            </div>
            
        </form>
        
        <div class="auth-helper-text">
            <p>Créez votre signature ou connectez-vous si vous en possédez déjà une</p>
        </div>
        
        <p class="form-note">
            Votre signature biologique sera générée automatiquement de manière unique et sécurisée.
        </p>
    </article>
</section>
