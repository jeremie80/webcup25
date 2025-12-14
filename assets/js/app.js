/**
 * WebCup 2025 - JavaScript Principal
 */

$(document).ready(function() {
    console.log('🚀 WebCup 2025 - Application chargée !');
    
    // Initialiser les fonctionnalités
    initApp();
});

/**
 * Initialisation de l'application
 */
function initApp() {
    console.log('✅ Application initialisée');
    
    // Ajouter des animations au scroll
    initScrollAnimations();
    
    // Initialiser les formulaires
    initForms();
}

/**
 * Animations au scroll
 */
function initScrollAnimations() {
    $('.feature').each(function(index) {
        $(this).css({
            'opacity': '0',
            'transform': 'translateY(20px)'
        });
        
        setTimeout(() => {
            $(this).css({
                'opacity': '1',
                'transform': 'translateY(0)',
                'transition': 'all 0.5s ease'
            });
        }, index * 100);
    });
}

/**
 * Validation des formulaires
 */
function initForms() {
    $('form').on('submit', function(e) {
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        
        // Désactiver le bouton pendant la soumission
        submitBtn.prop('disabled', true).text('Chargement...');
        
        // Réactiver après 2 secondes (sécurité)
        setTimeout(() => {
            submitBtn.prop('disabled', false).text('Envoyer');
        }, 2000);
    });
}

/**
 * Fonction AJAX générique
 */
function ajax(url, method = 'GET', data = {}, callback = null) {
    $.ajax({
        url: url,
        method: method,
        data: JSON.stringify(data),
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if (callback) callback(response);
        },
        error: function(xhr, status, error) {
            console.error('Erreur AJAX:', error);
        }
    });
}

