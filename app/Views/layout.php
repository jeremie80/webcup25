<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'IAstroMatch - Rencontres en Harmonie' ?></title>
    
    <!-- Google Fonts - Solarpunk Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&family=DM+Sans:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/responsive.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/layout-unified.css?v=<?= time() ?>">
    
    <!-- jQuery depuis CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body <?php if(isset($hideHeader) && $hideHeader): ?>data-hide-header="true"<?php endif; ?>>
    <?php 
    // Afficher le header sauf si explicitement masqué
    $hideHeader = isset($hideHeader) ? $hideHeader : false;
    if (!$hideHeader): 
        include __DIR__ . '/partials/header.php'; 
    endif; 
    ?>
    
    <main class="container">
        <?= $content ?>
    </main>
    
    <!-- JavaScript -->
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/narration.js"></script>
    <script src="/assets/js/form.js"></script>
    <script src="/assets/js/analysis.js"></script>
</body>
</html>

