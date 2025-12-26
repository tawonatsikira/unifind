<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$opportunities = DataService::getOpportunities();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Opportunities - Unifind</title>
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
            <span class="badge-modern badge-primary mb-4">Career & Growth</span>
            <h1>Opportunities</h1>
            <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto 0;">Scholarships, internships, and special programs to help you succeed.</p>
        </header>

        <main>
            <?php if (empty($opportunities)): ?>
                <div class="card text-center" style="padding: 5rem 2rem;">
                    <p style="color: var(--text-muted);">No opportunities listed at the moment. Check back later!</p>
                </div>
            <?php else: ?>
                <div style="display: grid; gap: 2rem; max-width: 800px; margin: 0 auto;">
                    <?php foreach ($opportunities as $opp): ?>
                        <article class="card" style="border-left: 4px solid var(--primary); padding: 2.5rem;">
                            <div class="mb-4">
                                <span class="badge-modern badge-secondary"><?= htmlspecialchars($opp->getType()) ?></span>
                            </div>
                            <h2 class="mb-4"><?= htmlspecialchars($opp->getTitle()) ?></h2>
                            <p style="font-size: 1.1rem; color: var(--text-body); margin-bottom: 2rem;"><?= nl2br(htmlspecialchars($opp->getDescription())) ?></p>
                            
                            <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; color: #dc2626; font-weight: 700; font-size: 0.9rem;">
                                    <span>📅 Deadline:</span>
                                    <span><?= htmlspecialchars($opp->getDeadline()) ?></span>
                                </div>
                                
                                <?php if ($opp->getLink()): ?>
                                    <a href="<?= htmlspecialchars($opp->getLink()) ?>" target="_blank" class="search-btn-modern" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; height: 44px; padding: 0 2rem;">Apply Now &rarr;</a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
