/**
 * Validation et interactions du formulaire de profil
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    
    if (!form) return;
    
    // Animation des champs au focus
    const inputs = form.querySelectorAll('input, select');
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 300ms ease';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });
    
    // Validation du formulaire
    form.addEventListener('submit', function(e) {
        const galacticName = document.getElementById('galactic_name').value.trim();
        const originType = document.getElementById('origin_type').value;
        
        if (!galacticName) {
            e.preventDefault();
            alert('ASTRÆA: Votre nom galactique est nécessaire pour continuer.');
            return;
        }
        
        if (!originType) {
            e.preventDefault();
            alert('ASTRÆA: Partagez votre origine pour que je puisse vous guider.');
            return;
        }
        
        // Animation du bouton pendant l'envoi
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.6';
        submitBtn.querySelector('span').textContent = 'Création en cours...';
    });
    
    // Suggestion de noms galactiques au focus
    const nameInput = document.getElementById('galactic_name');
    if (nameInput) {
        nameInput.addEventListener('focus', function() {
            console.log('💫 Suggestions: Aurora, Vega, Solara, Liora, Zephyr, Elara');
        });
    }
});

