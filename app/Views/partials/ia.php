<?php 
$hideIA = isset($hideIA) ? $hideIA : false;
if (!$hideIA): 
?>
<aside class="ia-container" role="complementary" aria-label="Assistant IA ASTRÆA">
    <p class="ia-text">
        Je suis ASTRÆA, votre guide bienveillant. Je vous accompagne dans votre recherche d'harmonie.
    </p>
    
    <!-- Orbe IA lumineuse -->
    <div class="ia-orb-widget">
        <div class="ia-orb-ring-widget ring-1"></div>
        <div class="ia-orb-ring-widget ring-2"></div>
        <div class="ia-orb-ring-widget ring-3"></div>
        
        <div class="ia-orb-core-widget">
            <div class="particle-widget particle-1"></div>
            <div class="particle-widget particle-2"></div>
            <div class="particle-widget particle-3"></div>
            <div class="particle-widget particle-4"></div>
            <div class="particle-widget particle-5"></div>
            <div class="particle-widget particle-6"></div>
        </div>
    </div>
</aside>
<?php endif; ?>

