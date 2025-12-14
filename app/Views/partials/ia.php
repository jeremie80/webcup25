<?php 
// Masquer ASTRÆA sur la page d'accueil (elle est intégrée dans le contenu)
$hideIA = isset($hideIA) ? $hideIA : false;
if (!$hideIA): 
?>
<aside class="ia-container" role="complementary" aria-label="Assistant IA ASTRÆA">
    <p class="ia-text">
        Je suis ASTRÆA, votre guide bienveillant. Je vous accompagne dans votre recherche d'harmonie.
    </p>
    <button class="ia-circle" aria-label="Ouvrir ASTRÆA">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M12 1v6m0 6v6m6-7h-6m-6 0h6"></path>
        </svg>
    </button>
</aside>
<?php endif; ?>

