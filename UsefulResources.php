<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$resources = DataService::getUsefulResources();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Useful Resources - Unifind</title>
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
            <span class="badge-modern badge-primary mb-4">Academic Toolkit</span>
            <h1>Useful Resources</h1>
            <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto 0;">Handy links, guides, and documents to support your academic journey.</p>
        </header>

        <main>
            <div class="program-grid-modern">
                <?php foreach ($resources as $res): ?>
                    <article class="card" style="display: flex; flex-direction: column; padding: 2.5rem;">
                        <div style="font-size: 2rem; margin-bottom: 1.5rem;">🔗</div>
                        <h2 style="font-size: 1.25rem; margin-bottom: 1rem;"><?= htmlspecialchars($res->getTitle()) ?></h2>
                        <p style="flex-grow: 1; font-size: 0.95rem; color: var(--text-muted); margin-bottom: 2rem; line-height: 1.7;">
                            <?= htmlspecialchars($res->getDescription()) ?>
                        </p>
                        <a href="<?= htmlspecialchars($res->getLink()) ?>" target="_blank" style="font-weight: 700; color: var(--primary); display: inline-flex; align-items: center; gap: 0.5rem;">
                            Access Resource 
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
