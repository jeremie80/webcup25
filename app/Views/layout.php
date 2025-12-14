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
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- jQuery depuis CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <?php if (isset($showHeader) && $showHeader !== false): ?>
        <?php include __DIR__ . '/partials/header.php'; ?>
    <?php endif; ?>
    
    <main class="container">
        <?= $content ?>
    </main>

    <!-- IA ASTRÆA - Toujours présente -->
    <?php include __DIR__ . '/partials/ia.php'; ?>
    
    <!-- JavaScript -->
    <script src="/assets/js/app.js"></script>
</body>
</html>

