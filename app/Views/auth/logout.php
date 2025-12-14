<section class="logout-container">
    <div class="portal-glow"></div>
    
    <!-- IA ASTRÆA au centre -->
    <div class="logout-ia-container">
        <!-- Orbe lumineux animé -->
        <div class="ia-orb-large" id="ia-orb-narrator" data-narration="<?= htmlspecialchars($farewell_message . ' ' . $farewell_subtitle) ?>">
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
                <div class="particle particle-7"></div>
                <div class="particle particle-8"></div>
            </div>
        </div>
        
        <!-- Message d'ASTRÆA -->
        <div class="logout-message">
            <h1 class="logout-title">ASTRÆA</h1>
            
            <div class="logout-farewell">
                <p class="farewell-text">
                    <?= htmlspecialchars($farewell_message) ?>
                </p>
                <p class="farewell-subtitle">
                    <?= htmlspecialchars($farewell_subtitle) ?>
                </p>
            </div>
            
            <!-- Animation de particules qui s'élèvent -->
            <div class="farewell-particles">
                <div class="farewell-particle fp-1"></div>
                <div class="farewell-particle fp-2"></div>
                <div class="farewell-particle fp-3"></div>
                <div class="farewell-particle fp-4"></div>
                <div class="farewell-particle fp-5"></div>
            </div>
        </div>
        
        <!-- Redirection automatique -->
        <div class="logout-redirect">
            <p>Redirection vers l'accueil dans <span id="countdown">20</span> secondes...</p>
            <a href="/" class="btn btn-return">Retourner maintenant</a>
        </div>
    </div>
</section>

<script>
// Compte à rebours et redirection automatique
let countdown = 20;
const countdownElement = document.getElementById('countdown');

const interval = setInterval(() => {
    countdown--;
    if (countdownElement) {
        countdownElement.textContent = countdown;
    }
    
    if (countdown <= 0) {
        clearInterval(interval);
        window.location.href = '/';
    }
}, 1000);

// Animation de l'orbe au chargement
document.addEventListener('DOMContentLoaded', () => {
    const iaOrb = document.querySelector('.ia-orb-large');
    if (iaOrb) {
        setTimeout(() => {
            iaOrb.classList.add('farewell-pulse');
        }, 500);
    }
    
    // Démarrer automatiquement la narration après 1 seconde (silencieuse, pas de bouton)
    setTimeout(() => {
        startNarration();
    }, 1000);
});

// ==========================================
// NARRATEUR VOCAL (Synthèse vocale automatique)
// ==========================================

let currentSpeech = null;
let isSpeaking = false;

const iaOrbNarrator = document.getElementById('ia-orb-narrator');

function startNarration() {
    if (!iaOrbNarrator) return;
    
    const narrationText = iaOrbNarrator.getAttribute('data-narration');
    if (!narrationText) return;
    
    // Vérifier si la synthèse vocale est disponible
    if (!('speechSynthesis' in window)) {
        console.warn('Synthèse vocale non disponible dans ce navigateur');
        return;
    }
    
    // Arrêter toute narration en cours
    stopNarration();
    
    // Créer une nouvelle instance
    currentSpeech = new SpeechSynthesisUtterance(narrationText);
    currentSpeech.lang = 'fr-FR';
    currentSpeech.rate = 0.9; // Vitesse légèrement ralentie pour plus de poésie
    currentSpeech.pitch = 1.1; // Voix légèrement plus aiguë
    currentSpeech.volume = 1;
    
    // Événements
    currentSpeech.onstart = () => {
        isSpeaking = true;
        iaOrbNarrator.classList.add('is-narrating');
    };
    
    currentSpeech.onend = () => {
        isSpeaking = false;
        iaOrbNarrator.classList.remove('is-narrating');
    };
    
    currentSpeech.onerror = (event) => {
        console.error('Erreur de narration:', event);
        isSpeaking = false;
        iaOrbNarrator.classList.remove('is-narrating');
    };
    
    // Démarrer la synthèse
    window.speechSynthesis.speak(currentSpeech);
}

function stopNarration() {
    if (window.speechSynthesis) {
        window.speechSynthesis.cancel();
    }
    isSpeaking = false;
    if (iaOrbNarrator) {
        iaOrbNarrator.classList.remove('is-narrating');
    }
}

// Arrêter la narration si l'utilisateur quitte la page
window.addEventListener('beforeunload', () => {
    stopNarration();
});
</script>

<style>
/* Styles spécifiques à la page de déconnexion */
.logout-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-lg);
    position: relative;
    overflow: hidden;
}

.logout-ia-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-xl);
    text-align: center;
    position: relative;
    z-index: 2;
    animation: fadeInUp 0.8s ease-out;
}

/* Orbe IA grande taille */
.ia-orb-large {
    width: 200px;
    height: 200px;
    position: relative;
    animation: gentleFloat 6s ease-in-out infinite;
}

.ia-orb-large .ia-orb-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    border: 2px solid var(--primary-green);
    opacity: 0.3;
}

.ia-orb-large .ring-1 {
    width: 100%;
    height: 100%;
    animation: pulseRing 3s ease-in-out infinite;
}

.ia-orb-large .ring-2 {
    width: 80%;
    height: 80%;
    animation: pulseRing 3s ease-in-out infinite 0.5s;
}

.ia-orb-large .ring-3 {
    width: 60%;
    height: 60%;
    animation: pulseRing 3s ease-in-out infinite 1s;
}

.ia-orb-large .ia-orb-core {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, var(--primary-soft) 0%, var(--primary-green) 50%, transparent 100%);
    border-radius: 50%;
    box-shadow: 
        0 0 40px var(--primary-green),
        0 0 80px rgba(95, 179, 162, 0.4),
        inset 0 0 40px rgba(168, 230, 207, 0.6);
    animation: coreGlow 2s ease-in-out infinite alternate;
}

.ia-orb-large .particle {
    position: absolute;
    width: 6px;
    height: 6px;
    background: var(--solar-glow);
    border-radius: 50%;
    box-shadow: 0 0 10px var(--solar-glow);
    animation: particleOrbit 4s linear infinite;
}

.ia-orb-large .particle-1 { animation-delay: 0s; }
.ia-orb-large .particle-2 { animation-delay: 0.5s; }
.ia-orb-large .particle-3 { animation-delay: 1s; }
.ia-orb-large .particle-4 { animation-delay: 1.5s; }
.ia-orb-large .particle-5 { animation-delay: 2s; }
.ia-orb-large .particle-6 { animation-delay: 2.5s; }
.ia-orb-large .particle-7 { animation-delay: 3s; }
.ia-orb-large .particle-8 { animation-delay: 3.5s; }

/* Animation pulse pour l'adieu */
.ia-orb-large.farewell-pulse .ia-orb-core {
    animation: farewellPulse 1.5s ease-out;
}

@keyframes farewellPulse {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 
            0 0 40px var(--primary-green),
            0 0 80px rgba(95, 179, 162, 0.4);
    }
    50% {
        transform: translate(-50%, -50%) scale(1.2);
        box-shadow: 
            0 0 80px var(--primary-green),
            0 0 120px rgba(95, 179, 162, 0.6);
    }
}

/* Message de déconnexion */
.logout-message {
    max-width: 600px;
    position: relative;
}

.logout-title {
    font-family: var(--font-title);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-soft), var(--primary-green));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: var(--spacing-md);
    letter-spacing: 0.05em;
}

.logout-farewell {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(95, 179, 162, 0.3);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
}

.farewell-text {
    font-size: clamp(1.1rem, 2vw, 1.3rem);
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: var(--spacing-md);
}

.farewell-subtitle {
    font-size: 1rem;
    font-style: italic;
    color: var(--primary-soft);
    opacity: 0.8;
}

/* Particules d'adieu qui s'élèvent */
.farewell-particles {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.farewell-particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: var(--primary-soft);
    border-radius: 50%;
    opacity: 0;
    animation: particleRise 3s ease-out infinite;
}

.farewell-particle.fp-1 {
    left: 20%;
    animation-delay: 0s;
}

.farewell-particle.fp-2 {
    left: 40%;
    animation-delay: 0.6s;
}

.farewell-particle.fp-3 {
    left: 50%;
    animation-delay: 1.2s;
}

.farewell-particle.fp-4 {
    left: 60%;
    animation-delay: 1.8s;
}

.farewell-particle.fp-5 {
    left: 80%;
    animation-delay: 2.4s;
}

@keyframes particleRise {
    0% {
        bottom: 0;
        opacity: 0;
        transform: translateY(0) scale(1);
    }
    20% {
        opacity: 1;
    }
    100% {
        bottom: 100%;
        opacity: 0;
        transform: translateY(-50px) scale(0.5);
    }
}

/* Redirection */
.logout-redirect {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-sm);
}

.logout-redirect p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
}

#countdown {
    font-weight: 700;
    color: var(--primary-green);
}

.btn-return {
    padding: var(--spacing-sm) var(--spacing-lg);
    background: linear-gradient(135deg, var(--primary-soft), var(--primary-green));
    color: white;
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid rgba(95, 179, 162, 0.3);
}

.btn-return:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(95, 179, 162, 0.3);
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes gentleFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes pulseRing {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.3;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.1);
        opacity: 0.5;
    }
}

@keyframes coreGlow {
    from {
        box-shadow: 
            0 0 40px var(--primary-green),
            0 0 80px rgba(95, 179, 162, 0.4),
            inset 0 0 40px rgba(168, 230, 207, 0.6);
    }
    to {
        box-shadow: 
            0 0 60px var(--primary-green),
            0 0 100px rgba(95, 179, 162, 0.6),
            inset 0 0 60px rgba(168, 230, 207, 0.8);
    }
}

@keyframes particleOrbit {
    from {
        transform: rotate(0deg) translateX(50px) rotate(0deg);
    }
    to {
        transform: rotate(360deg) translateX(50px) rotate(-360deg);
    }
}

/* Animation de l'orbe pendant la narration */
.ia-orb-large.is-narrating .ia-orb-core {
    animation: coreGlow 0.8s ease-in-out infinite alternate;
}

.ia-orb-large.is-narrating .ia-orb-ring {
    animation: pulseRing 1.5s ease-in-out infinite !important;
}

/* Responsive */
@media (max-width: 768px) {
    .logout-ia-container {
        gap: var(--spacing-lg);
    }
    
    .ia-orb-large {
        width: 150px;
        height: 150px;
    }
    
    .ia-orb-large .ia-orb-core {
        width: 75px;
        height: 75px;
    }
    
    .logout-farewell {
        padding: var(--spacing-md);
    }
}
</style>

