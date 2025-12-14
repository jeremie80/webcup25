<?php 
// Masquer le header sur la page d'accueil (portail)
$hideHeader = isset($hideHeader) ? $hideHeader : false;
if (!$hideHeader): 
?>
<header class="main-header" role="banner">
    <nav class="navbar" role="navigation" aria-label="Navigation principale">
        <div class="logo">
            <a href="/" aria-label="Retour à l'accueil">IAstroMatch</a>
        </div>
        
        <ul class="nav-menu" role="list">
            <li><a href="/">Accueil</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="/match">Harmonies</a></li>
                <li><a href="/chat">Échanges</a></li>
                <li><a href="/profile">Profil</a></li>
                <li><a href="/auth/logout">Se déconnecter</a></li>
            <?php else: ?>
                <li><a href="/auth/start">Commencer</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<?php endif; ?>
