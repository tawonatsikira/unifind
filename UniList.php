<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$unis = DataService::getUnisList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Universities - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="nav-header">
        <a href="index.html" class="logo-text">Unifind</a>
        <button class="menu-trigger" onclick="openNav()" aria-label="Open Menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
    </nav>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.html">Home</a>
        <a href="UniList.php">Universities</a>
        <a href="ProgramOptions.php">Programs</a>
        <a href="Opportunities.php">Opportunities</a>
        <a href="UsefulResources.php">Resources</a>
        <a href="Us.php">About</a>
        <a href="help.php">Help</a>
    </div>

    <div class="container" style="padding-top: 100px;">
        <header style="margin-bottom: 4rem; text-align: center;">
            <span class="badge-modern badge-primary mb-4">Higher Education</span>
            <h1>Universities in Zimbabwe</h1>
            <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto 0;">Explore the leading academic institutions across the country and find your future campus.</p>
        </header>

        <main class="program-grid-modern">
            <?php foreach ($unis as $id => $uni): ?>
                <?php
                    $logoPath = "public/assets/logos/{$id}.png";
                    if (!file_exists($logoPath)) $logoPath = "public/assets/logos/{$id}.jpg";
                    if (!file_exists($logoPath)) $logoPath = "public/assets/logos/{$id}.jpeg";
                    
                    $campusPath = "public/assets/campus/{$id}.png";
                    if (!file_exists($campusPath)) $campusPath = "public/assets/campus/{$id}.jpg";
                    if (!file_exists($campusPath)) $campusPath = "public/assets/campus/{$id}.jpeg";
                ?>
                <article class="program-card-modern" style="padding: 0; overflow: hidden;">
                    <div style="height: 180px; background-image: url('<?= file_exists($campusPath) ? $campusPath : 'public/assets/help/Search.png' ?>'); background-size: cover; background-position: center; position: relative;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.6));"></div>
                        <?php if (file_exists($logoPath)): ?>
                            <img src="<?= $logoPath ?>" alt="<?= htmlspecialchars($uni->getName()) ?> Logo" style="position: absolute; bottom: -20px; left: 20px; width: 60px; height: 60px; background: white; padding: 5px; border-radius: 12px; box-shadow: var(--shadow-md); object-fit: contain; z-index: 2;">
                        <?php endif; ?>
                    </div>
                    <div style="padding: 2.5rem 1.5rem 1.5rem;">
                        <h3 style="margin-bottom: 0.75rem;"><?= htmlspecialchars($uni->getName()) ?></h3>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 2rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1;">
                            <?= htmlspecialchars($uni->getDescription()) ?>
                        </p>
                        <div style="border-top: 1px solid var(--border); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                            <a href="ViewUniversity.php?id=<?= $id ?>" style="font-weight: 700; font-size: 0.9rem;">View Profile &rarr;</a>
                            <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">ID: #<?= $id ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
