<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$unis = DataService::getUnisList();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universities - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .uni-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        .uni-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .uni-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }
        .uni-card-image {
            height: 160px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .uni-card-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.4));
        }
        .uni-card-logo {
            position: absolute;
            bottom: -20px;
            left: 20px;
            width: 60px;
            height: 60px;
            background: white;
            padding: 5px;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            z-index: 2;
            object-fit: contain;
        }
        .uni-card-content {
            padding: 2rem 1.5rem 1.5rem;
            flex-grow: 1;
        }
        .uni-card-content h3 {
            margin-bottom: 0.75rem;
            font-size: 1.25rem;
        }
        .uni-card-content p {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .uni-card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: #f8fafc;
        }
        .btn-view {
            display: inline-block;
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
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
            <h1>Universities</h1>
            <p style="color: var(--text-muted);">Explore higher education institutions in Zimbabwe</p>
        </header>

        <main class="uni-grid">
            <?php foreach ($unis as $id => $uni): ?>
                <?php
                    $logoPath = "public/assets/logos/{$id}.png";
                    if (!file_exists($logoPath)) $logoPath = "public/assets/logos/{$id}.jpg";
                    if (!file_exists($logoPath)) $logoPath = "public/assets/logos/{$id}.jpeg";
                    
                    $campusPath = "public/assets/campus/{$id}.png";
                    if (!file_exists($campusPath)) $campusPath = "public/assets/campus/{$id}.jpg";
                    if (!file_exists($campusPath)) $campusPath = "public/assets/campus/{$id}.jpeg";
                ?>
                <article class="uni-card">
                    <div class="uni-card-image" style="background-image: url('<?= file_exists($campusPath) ? $campusPath : 'public/assets/help/Search.png' ?>');">
                        <?php if (file_exists($logoPath)): ?>
                            <img src="<?= $logoPath ?>" alt="<?= htmlspecialchars($uni->getName()) ?> Logo" class="uni-card-logo">
                        <?php endif; ?>
                    </div>
                    <div class="uni-card-content">
                        <h3><?= htmlspecialchars($uni->getName()) ?></h3>
                        <p><?= htmlspecialchars($uni->getDescription()) ?></p>
                    </div>
                    <div class="uni-card-footer">
                        <a href="ViewUniversity.php?id=<?= $id ?>" class="btn-view">View Profile &rarr;</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
