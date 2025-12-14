/**
 * IAstroMatch - Portail d'Entrée avec Synthèse Vocale
 */

document.addEventListener('DOMContentLoaded', function() {
    initPortal();
});

function initPortal() {
    const audioBtn = document.getElementById('toggleAudio');
    const textLines = document.querySelectorAll('.text-line');
    
    let isPlaying = false;
    let currentUtterance = null;
    
    // Vérifier si la synthèse vocale est disponible
    if (!('speechSynthesis' in window)) {
        console.warn('Synthèse vocale non supportée par ce navigateur');
        audioBtn.style.display = 'none';
        return;
    }
    
    // Configuration de la synthèse vocale
    function speak(text) {
        // Annuler toute narration en cours
        window.speechSynthesis.cancel();
        
        // Créer une nouvelle utterance
        currentUtterance = new SpeechSynthesisUtterance(text);
        
        // Configuration de la voix
        currentUtterance.lang = 'fr-FR';
        currentUtterance.rate = 0.9; // Vitesse lente et posée
        currentUtterance.pitch = 1.0; // Ton neutre
        currentUtterance.volume = 1.0; // Volume max
        
        // Sélectionner une voix féminine si disponible
        const voices = window.speechSynthesis.getVoices();
        const frenchVoice = voices.find(voice => 
            voice.lang.startsWith('fr') && voice.name.includes('Female')
        ) || voices.find(voice => voice.lang.startsWith('fr'));
        
        if (frenchVoice) {
            currentUtterance.voice = frenchVoice;
        }
        
        // Événements
        currentUtterance.onend = function() {
            console.log('Narration terminée');
        };
        
        currentUtterance.onerror = function(event) {
            console.error('Erreur de synthèse vocale:', event);
        };
        
        // Lancer la synthèse
        window.speechSynthesis.speak(currentUtterance);
    }
    
    // Fonction pour lire tout le texte
    function speakAllText() {
        const allText = Array.from(textLines)
            .map(line => line.textContent.trim())
            .join(' ... '); // Pause entre les paragraphes
        
        speak(allText);
    }
    
    // Gestionnaire du bouton audio
    audioBtn.addEventListener('click', function() {
        if (isPlaying) {
            // Arrêter la narration
            window.speechSynthesis.cancel();
            audioBtn.classList.remove('active');
            document.querySelector('.audio-icon-on').style.display = 'block';
            document.querySelector('.audio-icon-off').style.display = 'none';
            isPlaying = false;
        } else {
            // Démarrer la narration
            speakAllText();
            audioBtn.classList.add('active');
            document.querySelector('.audio-icon-on').style.display = 'none';
            document.querySelector('.audio-icon-off').style.display = 'block';
            isPlaying = true;
            
            // Animation de l'orbe pendant la lecture
            const orbCore = document.querySelector('.ia-orb-core');
            orbCore.style.animation = 'pulse 1.5s ease-in-out infinite';
        }
    });
    
    // Arrêter la narration quand on quitte la page
    window.addEventListener('beforeunload', function() {
        window.speechSynthesis.cancel();
    });
    
    // Animation de scroll automatique synchronisé (optionnel)
    const prompterText = document.querySelector('.prompter-text');
    let scrollInterval;
    
    function autoScroll() {
        if (isPlaying && prompterText) {
            scrollInterval = setInterval(() => {
                prompterText.scrollTop += 1;
                
                // Arrêter si on arrive en bas
                if (prompterText.scrollTop + prompterText.clientHeight >= prompterText.scrollHeight) {
                    clearInterval(scrollInterval);
                }
            }, 50); // Vitesse de scroll
        }
    }
    
    // Effet de "highlighting" du texte en cours de lecture (optionnel)
    if (currentUtterance) {
        currentUtterance.onboundary = function(event) {
            // On pourrait surligner le mot en cours
            console.log('Boundary:', event);
        };
    }
    
    // Animation douce des particules au clic sur l'orbe
    const orbCore = document.querySelector('.ia-orb-core');
    if (orbCore) {
        orbCore.addEventListener('click', function() {
            const particles = document.querySelectorAll('.particle');
            particles.forEach(particle => {
                particle.style.animation = 'none';
                setTimeout(() => {
                    particle.style.animation = 'float 8s ease-in-out infinite';
                }, 10);
            });
        });
    }
    
    // Charger les voix disponibles
    window.speechSynthesis.onvoiceschanged = function() {
        const voices = window.speechSynthesis.getVoices();
        console.log('Voix disponibles:', voices.length);
        voices.forEach(voice => {
            if (voice.lang.startsWith('fr')) {
                console.log('Voix FR:', voice.name, voice.lang);
            }
        });
    };
}

