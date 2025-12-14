<section class="error-404-container">
    <div class="portal-glow"></div>
    
    <!-- IA ASTRÆA au centre -->
    <div class="error-404-ia-container">
        <!-- Orbe lumineux animé -->
        <div class="ia-orb-large" id="ia-orb-narrator" data-narration="Il semblerait que vous vous soyez égaré dans les méandres de l'espace-temps. Cette constellation n'existe pas dans nos archives. Laissez-moi vous guider vers un chemin connu.">
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
            <div class="audio-indicator">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
                </svg>
            </div>
        </div>
        
        <!-- Message d'ASTRÆA -->
        <div class="error-404-message">
            <h1 class="error-404-title">ASTRÆA</h1>
            
            <div class="error-404-code">
                <span class="code-number">404</span>
                <span class="code-label">Route Inconnue</span>
            </div>
            
            <div class="error-404-text">
                <p class="error-main-text">
                    Voyageur·euse, vous vous êtes trompé·e de route cosmique.
                </p>
                <p class="error-sub-text">
                    Cette constellation n'existe pas dans nos archives stellaires.
                </p>
            </div>
        </div>
        
        <!-- Navigation de retour -->
        <div class="error-404-actions">
            <a href="/" class="btn btn-return-home">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Retour à l'Écosystème</span>
            </a>
        </div>
    </div>
</section>

<script>
// Animation de l'orbe au chargement
document.addEventListener('DOMContentLoaded', () => {
    const iaOrb = document.querySelector('.ia-orb-large');
    if (iaOrb) {
        setTimeout(() => {
            iaOrb.classList.add('error-pulse');
        }, 500);
    }
    
    // Démarrer automatiquement la narration après 1 seconde
    setTimeout(() => {
        startNarration();
    }, 1000);
});

// ==========================================
// NARRATEUR VOCAL
// ==========================================

let currentSpeech = null;
let isSpeaking = false;

const iaOrbNarrator = document.getElementById('ia-orb-narrator');

function startNarration() {
    if (!iaOrbNarrator) return;
    
    const narrationText = iaOrbNarrator.getAttribute('data-narration');
    if (!narrationText) return;
    
    if (!('speechSynthesis' in window)) {
        console.warn('Synthèse vocale non disponible');
        return;
    }
    
    stopNarration();
    
    currentSpeech = new SpeechSynthesisUtterance(narrationText);
    currentSpeech.lang = 'fr-FR';
    currentSpeech.rate = 0.9;
    currentSpeech.pitch = 1.1;
    currentSpeech.volume = 1;
    
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

// Toggle narration on click
if (iaOrbNarrator) {
    iaOrbNarrator.addEventListener('click', function(e) {
        if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A') {
            return;
        }
        if (isSpeaking) {
            stopNarration();
        } else {
            startNarration();
        }
    });
}

window.addEventListener('beforeunload', () => {
    stopNarration();
});
</script>

<style>
/* Styles spécifiques à la page 404 */
.error-404-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-lg);
    position: relative;
    overflow: hidden;
}

.error-404-ia-container {
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
    cursor: pointer;
}

.ia-orb-large .ia-orb-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    border: 2px solid var(--primary-green);
    opacity: 0.5;
    box-shadow: 0 0 20px rgba(95, 179, 162, 0.4);
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
    background: radial-gradient(circle, var(--primary-green) 0%, #4CAF50 50%, var(--dark-forest) 100%);
    border-radius: 50%;
    box-shadow: 
        0 0 60px var(--primary-green),
        0 0 120px rgba(95, 179, 162, 0.6),
        0 0 180px rgba(95, 179, 162, 0.4),
        inset 0 0 40px rgba(95, 179, 162, 0.8);
    animation: coreGlow 2s ease-in-out infinite alternate;
    filter: brightness(1.4) contrast(1.2);
}

.ia-orb-large .particle {
    position: absolute;
    width: 6px;
    height: 6px;
    background: var(--primary-soft);
    border-radius: 50%;
    box-shadow: 0 0 15px var(--primary-soft),
                0 0 30px rgba(168, 230, 207, 0.6);
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

/* Animation pulse pour erreur */
.ia-orb-large.error-pulse .ia-orb-core {
    animation: errorPulse 1.5s ease-out;
}

@keyframes errorPulse {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 
            0 0 60px var(--primary-green),
            0 0 120px rgba(95, 179, 162, 0.6);
    }
    50% {
        transform: translate(-50%, -50%) scale(1.2);
        box-shadow: 
            0 0 80px var(--primary-green),
            0 0 160px rgba(95, 179, 162, 0.8);
    }
}

/* Message d'erreur */
.error-404-message {
    max-width: 600px;
    position: relative;
}

.error-404-title {
    font-family: var(--font-title);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: var(--primary-green);
    margin-bottom: var(--spacing-md);
    letter-spacing: 0.05em;
    text-shadow: 0 0 30px rgba(95, 179, 162, 0.6),
                 0 0 60px rgba(95, 179, 162, 0.4);
}

.error-404-code {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-xs);
    margin-bottom: var(--spacing-lg);
}

.code-number {
    font-family: var(--font-title);
    font-size: clamp(4rem, 8vw, 6rem);
    font-weight: 700;
    color: var(--primary-green);
    line-height: 1;
    text-shadow: 0 0 40px rgba(95, 179, 162, 0.6),
                 0 0 80px rgba(95, 179, 162, 0.4);
    animation: codeGlow 3s ease-in-out infinite;
}

.code-label {
    font-size: 1.2rem;
    color: var(--primary-soft);
    text-transform: uppercase;
    letter-spacing: 0.2em;
    opacity: 0.9;
}

@keyframes codeGlow {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.error-404-text {
    background: rgba(42, 74, 58, 0.3);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(95, 179, 162, 0.5);
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.error-main-text {
    font-size: clamp(1.1rem, 2vw, 1.3rem);
    line-height: 1.8;
    color: var(--primary-soft);
    margin-bottom: var(--spacing-sm);
}

.error-sub-text {
    font-size: 1rem;
    font-style: italic;
    color: var(--primary-soft);
    opacity: 0.8;
}

/* Actions */
.error-404-actions {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--spacing-sm);
}

.btn-return-home {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-md) var(--spacing-xl);
    background: linear-gradient(135deg, var(--primary-green), #4CAF50);
    color: white;
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 1.1rem;
    transition: all var(--transition-normal);
    box-shadow: 0 0 30px rgba(95, 179, 162, 0.5);
}

.btn-return-home:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 40px rgba(95, 179, 162, 0.6);
}

.btn-return-home svg {
    flex-shrink: 0;
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
        transform: translateY(-15px);
    }
}

@keyframes pulseRing {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.5;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.1);
        opacity: 0.7;
    }
}

@keyframes coreGlow {
    from {
        filter: brightness(1.2) contrast(1.1);
    }
    to {
        filter: brightness(1.6) contrast(1.3);
    }
}

@keyframes particleOrbit {
    0% {
        transform: rotate(0deg) translateX(40px) rotate(0deg);
    }
    100% {
        transform: rotate(360deg) translateX(40px) rotate(-360deg);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .error-404-ia-container {
        gap: var(--spacing-lg);
    }
    
    .ia-orb-large {
        width: 150px;
        height: 150px;
    }
    
    .ia-orb-large .ia-orb-core {
        width: 80px;
        height: 80px;
    }
    
    .error-404-text {
        padding: var(--spacing-md);
    }
    
    .btn-return-home {
        padding: var(--spacing-sm) var(--spacing-lg);
        font-size: 1rem;
    }
}
</style>

