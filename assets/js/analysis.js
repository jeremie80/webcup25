/**
 * Animation de l'analyse IA
 * Affichage progressif des messages avec timing
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('🔬 IA Analysis System loaded');
    
    const messages = document.querySelectorAll('.analysis-message');
    const orbCore = document.querySelector('.ia-orb-core-large');
    const iaName = document.querySelector('.ia-name-centered p');
    
    if (messages.length === 0) {
        console.log('❌ No analysis messages found');
        return;
    }
    
    console.log(`✅ Found ${messages.length} analysis messages`);
    
    // Fonction pour afficher un message avec animation
    function showMessage(message) {
        message.style.opacity = '0';
        message.style.transform = 'translateY(20px)';
        message.style.display = 'block';
        
        // Forcer le reflow pour l'animation
        message.offsetHeight;
        
        // Animer l'apparition
        setTimeout(() => {
            message.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            message.style.opacity = '1';
            message.style.transform = 'translateY(0)';
        }, 50);
        
        console.log('📝 Message displayed:', message.textContent.trim().substring(0, 40) + '...');
    }
    
    // Fonction pour accélérer les anneaux pendant l'analyse
    function accelerateRings() {
        const rings = document.querySelectorAll('.analysis-ring');
        rings.forEach((ring, index) => {
            ring.style.animationDuration = (2 - index * 0.3) + 's';
        });
    }
    
    // Fonction pour ralentir les anneaux à la fin
    function slowDownRings() {
        const rings = document.querySelectorAll('.analysis-ring');
        rings.forEach((ring, index) => {
            ring.style.animationDuration = (6 + index * 2) + 's';
        });
    }
    
    // Cacher tous les messages au départ
    messages.forEach(msg => {
        msg.style.display = 'none';
        msg.style.opacity = '0';
    });
    
    // Accélérer les anneaux au début
    accelerateRings();
    
    // Afficher les messages progressivement
    messages.forEach((message, index) => {
        const delay = parseInt(message.getAttribute('data-delay')) || (index * 2500);
        
        setTimeout(() => {
            // Masquer le message précédent (sauf pour le dernier)
            if (index > 0 && index < messages.length - 1) {
                const prevMessage = messages[index - 1];
                prevMessage.style.transition = 'opacity 0.5s ease';
                prevMessage.style.opacity = '0';
                setTimeout(() => {
                    prevMessage.style.display = 'none';
                }, 500);
            }
            
            showMessage(message);
            
            // Si c'est le message final
            if (message.classList.contains('analysis-final')) {
                console.log('✅ Analysis complete!');
                
                // Ralentir les anneaux
                slowDownRings();
                
                // Changer le texte de l'IA
                if (iaName) {
                    iaName.textContent = 'Analyse terminée - Cliquez sur l\'orbe pour écouter';
                }
                
                // Intensifier le glow de l'orbe
                if (orbCore) {
                    orbCore.style.boxShadow = '0 0 60px rgba(95, 179, 162, 0.9), 0 0 120px rgba(95, 179, 162, 0.6)';
                    orbCore.style.animation = 'pulse 2s ease-in-out infinite';
                }
            }
        }, delay);
    });
    
    // Animation du bouton final
    const continueBtn = document.getElementById('continue-btn');
    if (continueBtn) {
        continueBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        continueBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
});


