/**
 * Synthèse vocale ASTRÆA
 * Narration au clic sur les éléments avec data-narration
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('🎙️ ASTRÆA Narration System loaded');
    
    // Vérifier le support de la synthèse vocale
    if (!('speechSynthesis' in window)) {
        console.warn('❌ Synthèse vocale non supportée');
        return;
    }
    
    console.log('✅ Speech synthesis supported');
    
    // Trouver tous les éléments avec data-narration
    const narrativeElements = document.querySelectorAll('[data-narration]');
    
    if (narrativeElements.length === 0) {
        console.log('ℹ️ No narrative elements found on this page');
        return;
    }
    
    console.log(`✅ Found ${narrativeElements.length} narrative element(s)`);
    
    let isPlaying = false;
    let currentUtterance = null;
    
    // Charger les voix
    let voicesLoaded = false;
    let availableVoices = [];
    
    function loadVoices() {
        availableVoices = window.speechSynthesis.getVoices();
        if (availableVoices.length > 0 && !voicesLoaded) {
            voicesLoaded = true;
            console.log('✅ Voices loaded:', availableVoices.length);
        }
    }
    
    // Charger les voix immédiatement et aussi à l'événement
    loadVoices();
    window.speechSynthesis.onvoiceschanged = loadVoices;
    
    // Fonction pour démarrer la narration
    function startNarration(textToSpeak, orbElement) {
        // Si une narration est en cours, l'arrêter
        if (isPlaying) {
            console.log('⏹️ Stopping current narration');
            window.speechSynthesis.cancel();
            isPlaying = false;
            return;
        }
        
        console.log('🎤 Starting narration:', textToSpeak.substring(0, 50) + '...');
        
        // Créer l'utterance
        currentUtterance = new SpeechSynthesisUtterance(textToSpeak);
        
        // Configuration
        currentUtterance.lang = 'fr-FR';
        currentUtterance.rate = 0.85; // Vitesse lente et posée
        currentUtterance.pitch = 1.0;
        currentUtterance.volume = 1.0;
        
        // Sélectionner une voix française féminine si possible
        const frenchFemaleVoice = availableVoices.find(voice => 
            voice.lang.startsWith('fr') && (voice.name.toLowerCase().includes('female') || voice.name.toLowerCase().includes('femme'))
        );
        const frenchVoice = frenchFemaleVoice || availableVoices.find(voice => voice.lang.startsWith('fr'));
        
        if (frenchVoice) {
            currentUtterance.voice = frenchVoice;
            console.log('🎙️ Using voice:', frenchVoice.name);
        } else {
            console.warn('⚠️ No French voice found, using default');
        }
        
        // Trouver l'orbe core pour l'animer
        const orbCore = orbElement ? orbElement.querySelector('.ia-orb-core') : document.querySelector('.ia-orb-core');
        
        // Événements
        currentUtterance.onstart = function() {
            console.log('▶️ Narration started');
            isPlaying = true;
            if (orbCore) {
                orbCore.style.animation = 'pulse 1.2s ease-in-out infinite';
                orbCore.style.boxShadow = '0 0 40px rgba(95, 179, 162, 0.8), 0 0 80px rgba(95, 179, 162, 0.6)';
            }
        };
        
        currentUtterance.onend = function() {
            console.log('⏹️ Narration ended');
            isPlaying = false;
            if (orbCore) {
                orbCore.style.animation = 'pulse 3s ease-in-out infinite';
                orbCore.style.boxShadow = '0 0 30px rgba(95, 179, 162, 0.6), 0 0 60px rgba(95, 179, 162, 0.4)';
            }
        };
        
        currentUtterance.onerror = function(event) {
            console.error('❌ Speech error:', event.error);
            isPlaying = false;
            if (orbCore) {
                orbCore.style.animation = 'pulse 3s ease-in-out infinite';
                orbCore.style.boxShadow = '0 0 30px rgba(95, 179, 162, 0.6), 0 0 60px rgba(95, 179, 162, 0.4)';
            }
        };
        
        // Lancer la narration
        window.speechSynthesis.speak(currentUtterance);
    }
    
    // Ajouter les listeners de clic sur tous les éléments avec data-narration
    narrativeElements.forEach(function(element) {
        const textToSpeak = element.getAttribute('data-narration');
        
        if (!textToSpeak || textToSpeak.trim() === '') {
            console.warn('⚠️ Empty data-narration attribute found');
            return;
        }
        
        // Rendre l'élément cliquable
        element.style.cursor = 'pointer';
        
        // Ajouter un indicateur visuel
        element.setAttribute('title', 'Cliquez pour écouter ASTRÆA');
        element.classList.add('has-narration');
        
        // Créer l'icône audio si c'est un orbe IA
        if (element.classList.contains('ia-orb-container')) {
            const audioIcon = document.createElement('div');
            audioIcon.className = 'audio-indicator';
            audioIcon.innerHTML = `
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
                </svg>
            `;
            element.appendChild(audioIcon);
        }
        
        // Ajouter le listener
        element.addEventListener('click', function(e) {
            // Ne pas interférer avec les clics sur les boutons/liens à l'intérieur
            if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target.tagName === 'INPUT') {
                return;
            }
            
            console.log('🖱️ Narrative element clicked');
            startNarration(textToSpeak, element);
        });
        
        console.log('✅ Narration listener added to element');
    });
    
    // Arrêter la narration si l'utilisateur quitte la page
    window.addEventListener('beforeunload', function() {
        if (isPlaying) {
            window.speechSynthesis.cancel();
        }
    });
});

