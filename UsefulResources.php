<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$resources = DataService::getUsefulResources();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Useful Resources - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
            <h1>Useful Resources</h1>
            <p style="color: var(--text-muted);">Handy links and documents for your academic journey</p>
        </header>

        <main>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
                <?php foreach ($resources as $res): ?>
                    <article class="card" style="display: flex; flex-direction: column;">
                        <h2 style="font-size: 1.25rem; margin-bottom: 1rem;"><?= htmlspecialchars($res->getTitle()) ?></h2>
                        <p style="flex-grow: 1; font-size: 0.95rem; color: var(--text-muted); margin-bottom: 1.5rem;">
                            <?= htmlspecialchars($res->getDescription()) ?>
                        </p>
                        <a href="<?= htmlspecialchars($res->getLink()) ?>" target="_blank" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Access Resource &rarr;</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
