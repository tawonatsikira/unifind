<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$opportunities = DataService::getOpportunities();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opportunities - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .opp-card {
            border-left: 5px solid var(--primary-color);
            transition: all 0.2s;
        }
        .opp-card:hover {
            border-left-width: 10px;
        }
        .opp-type {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        .opp-deadline {
            font-size: 0.9rem;
            color: #dc2626;
            font-weight: 600;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.html">Search</a>
        <a href="UniList.php">Universities</a>
        <a href="ProgramOptions.php">Program Options</a>
        <a href="UsefulResources.php">Useful Resources</a>
        <a href="Opportunities.php">Opportunities</a>
        <a href="Us.php">About Us</a>
        <a href="help.php">Help</a>
    </div>

    <button class="menu-btn" onclick="openNav()" aria-label="Open Menu">&#9776;</button>

    <div class="container">
        <header style="margin-bottom: 3rem;">
            <h1>Opportunities</h1>
            <p style="color: var(--text-muted);">Scholarships, Internships, and Academic Programs</p>
        </header>

        <main>
            <?php if (empty($opportunities)): ?>
                <div class="card" style="text-align: center; padding: 4rem;">
                    <p style="color: var(--text-muted);">No opportunities listed at the moment. Check back later!</p>
                </div>
            <?php else: ?>
                <div style="display: grid; gap: 1.5rem;">
                    <?php foreach ($opportunities as $opp): ?>
                        <article class="card opp-card">
                            <span class="opp-type"><?= htmlspecialchars($opp->getType()) ?></span>
                            <h2 style="margin-bottom: 1rem;"><?= htmlspecialchars($opp->getTitle()) ?></h2>
                            <p><?= nl2br(htmlspecialchars($opp->getDescription())) ?></p>
                            
                            <div class="opp-deadline">
                                <span>📅 Deadline:</span>
                                <span><?= htmlspecialchars($opp->getDeadline()) ?></span>
                            </div>
                            
                            <?php if ($opp->getLink()): ?>
                                <a href="<?= htmlspecialchars($opp->getLink()) ?>" target="_blank" class="tab active" style="display: inline-block; margin-top: 1.5rem; text-decoration: none; width: auto; flex: none; padding: 0.8rem 2rem;">Apply Now &rarr;</a>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
