<section class="portal-entrance-split">
    <div class="portal-glow"></div>
    
    <!-- Partie gauche : IA (toujours visible) -->
    <aside class="portal-ia-side">
        <div class="ia-orb-container" id="ia-orb-narrator" data-narration="Nous allons maintenant créer votre profil cosmique. Ces informations nous aideront à trouver les harmonies qui vous correspondent. Chaque choix reflète une facette de votre être.">
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
            <p>Bienvenue, <strong><?php echo htmlspecialchars($galactic_name ?? 'Voyageur'); ?></strong> 🌟<br>
            Créons ensemble votre profil cosmique.</p>
        </div>
    </aside>
    
    <!-- Partie droite : Formulaire de profil -->
    <article class="portal-content-side">
        <header class="form-header">
            <h1 class="form-title">Votre Profil Cosmique</h1>
            <p class="form-subtitle">Complétez ces informations pour affiner vos harmonies</p>
        </header>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="/profile/store" enctype="multipart/form-data" class="profile-form" id="profileForm">
            
            <!-- Atmosphere Type -->
            <div class="form-group">
                <label for="atmosphere_type">Type d'Atmosphère</label>
                <select id="atmosphere_type" name="atmosphere_type" required>
                    <option value="">Choisissez votre atmosphère...</option>
                    <option value="oxygen" <?php echo (isset($atmosphere_type) && $atmosphere_type === 'oxygen') ? 'selected' : ''; ?>>🌬️ Oxygène (Respiration terrestre)</option>
                    <option value="methane" <?php echo (isset($atmosphere_type) && $atmosphere_type === 'methane') ? 'selected' : ''; ?>>🔥 Méthane (Environnements extrêmes)</option>
                    <option value="vacuum" <?php echo (isset($atmosphere_type) && $atmosphere_type === 'vacuum') ? 'selected' : ''; ?>>🌌 Vide spatial (Synthétique)</option>
                    <option value="aquatic" <?php echo (isset($atmosphere_type) && $atmosphere_type === 'aquatic') ? 'selected' : ''; ?>>🌊 Aquatique (Monde sous-marin)</option>
                </select>
                <small class="form-help">ASTRÆA: Votre environnement naturel influence vos compatibilités.</small>
            </div>
            
            <!-- Communication Mode -->
            <div class="form-group">
                <label for="communication_mode">Mode de Communication</label>
                <select id="communication_mode" name="communication_mode" required>
                    <option value="">Choisissez votre mode...</option>
                    <option value="verbal" <?php echo (isset($communication_mode) && $communication_mode === 'verbal') ? 'selected' : ''; ?>>💬 Verbal (Langage parlé)</option>
                    <option value="telepathic" <?php echo (isset($communication_mode) && $communication_mode === 'telepathic') ? 'selected' : ''; ?>>🧠 Télépathique (Connexion mentale)</option>
                    <option value="chemical" <?php echo (isset($communication_mode) && $communication_mode === 'chemical') ? 'selected' : ''; ?>>🧪 Chimique (Phéromones)</option>
                    <option value="luminous" <?php echo (isset($communication_mode) && $communication_mode === 'luminous') ? 'selected' : ''; ?>>✨ Lumineux (Bioluminescence)</option>
                </select>
                <small class="form-help">ASTRÆA: Comment préférez-vous échanger avec les autres ?</small>
            </div>
            
            <!-- Tech Level -->
            <div class="form-group">
                <label for="tech_level">Niveau Technologique</label>
                <select id="tech_level" name="tech_level" required>
                    <option value="">Choisissez votre niveau...</option>
                    <option value="organic" <?php echo (isset($tech_level) && $tech_level === 'organic') ? 'selected' : ''; ?>>🌿 Organique (Technologie naturelle)</option>
                    <option value="hybrid" <?php echo (isset($tech_level) && $tech_level === 'hybrid') ? 'selected' : ''; ?>>⚙️ Hybride (Bio-tech)</option>
                    <option value="advanced" <?php echo (isset($tech_level) && $tech_level === 'advanced') ? 'selected' : ''; ?>>🤖 Avancé (Cybernétique)</option>
                </select>
                <small class="form-help">ASTRÆA: Votre rapport à la technologie définit votre quotidien.</small>
            </div>
            
            <!-- Core Value -->
            <div class="form-group">
                <label for="core_value">Valeur Fondamentale</label>
                <select id="core_value" name="core_value" required>
                    <option value="">Choisissez votre valeur...</option>
                    <option value="harmony" <?php echo (isset($core_value) && $core_value === 'harmony') ? 'selected' : ''; ?>>☯️ Harmonie (Équilibre et paix)</option>
                    <option value="survival" <?php echo (isset($core_value) && $core_value === 'survival') ? 'selected' : ''; ?>>🛡️ Survie (Adaptation et résilience)</option>
                    <option value="expansion" <?php echo (isset($core_value) && $core_value === 'expansion') ? 'selected' : ''; ?>>🚀 Expansion (Exploration et croissance)</option>
                    <option value="knowledge" <?php echo (isset($core_value) && $core_value === 'knowledge') ? 'selected' : ''; ?>>📚 Connaissance (Sagesse et apprentissage)</option>
                </select>
                <small class="form-help">ASTRÆA: Quelle est votre quête existentielle ?</small>
            </div>
            
            <!-- Avatar Upload -->
            <div class="form-group">
                <label for="avatar">Avatar (Optionnel)</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
                <small class="form-help">ASTRÆA: Votre représentation visuelle dans l'écosystème.</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <span>Créer mon Profil</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            
        </form>
        
        <p class="form-note">
            Ces informations permettront à ASTRÆA de calculer vos affinités cosmiques.
        </p>
    </article>
</section>

