<header class="main-header" role="banner">
    <nav class="navbar" role="navigation" aria-label="Navigation principale">
        <div class="logo">
            <a href="/" aria-label="Retour à l'accueil">IAstroMatch</a>
        </div>
        
        <!-- Menu burger (mobile uniquement) -->
        <button class="burger-menu" id="burger-menu" aria-label="Menu de navigation" aria-expanded="false">
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
        </button>
        
        <ul class="nav-menu" id="nav-menu" role="list">
            <li><a href="/">Accueil</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="/dashboard">Tableau de bord</a></li>
                <li><a href="/match">Suggestions</a></li>
                <li><a href="/match/revealed">Révélations</a></li>
                <li><a href="/chat">Échanges</a></li>
                <li><a href="/profile">Profil</a></li>
                <li><a href="/auth/logout">Se déconnecter</a></li>
            <?php else: ?>
                <li><a href="/auth/start">Commencer</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <!-- Overlay pour fermer le menu mobile -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>
</header>

<script>
// Gestion du menu burger mobile
document.addEventListener('DOMContentLoaded', () => {
    const burgerMenu = document.getElementById('burger-menu');
    const navMenu = document.getElementById('nav-menu');
    const overlay = document.getElementById('mobile-menu-overlay');
    
    if (burgerMenu && navMenu && overlay) {
        // Toggle menu
        burgerMenu.addEventListener('click', () => {
            const isOpen = navMenu.classList.contains('is-open');
            
            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });
        
        // Fermer avec overlay
        overlay.addEventListener('click', closeMenu);
        
        // Fermer avec escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && navMenu.classList.contains('is-open')) {
                closeMenu();
            }
        });
        
        // Fermer au clic sur un lien
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    }
    
    function openMenu() {
        navMenu.classList.add('is-open');
        burgerMenu.classList.add('is-open');
        overlay.classList.add('is-visible');
        burgerMenu.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden'; // Empêcher le scroll
    }
    
    function closeMenu() {
        navMenu.classList.remove('is-open');
        burgerMenu.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        burgerMenu.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = ''; // Restaurer le scroll
    }
});
</script>
