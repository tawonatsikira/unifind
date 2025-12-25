<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$opportunities = DataService::getOpportunities();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Opportunities - Unifind</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8f8f8;
            color: #222;
            line-height: 1.6;
        }
        h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #000;
            text-align: center;
        }
        .opportunity-list {
            display: grid;
            gap: 1rem;
        }
        
        .opportunity-item {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .opportunity-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .opportunity-item h3 {
            margin: 0 0 0.5rem 0;
            color: #000;
        }
        .opportunity-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        a {
            color: #000;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css" >
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.html">Search</a>
        <a href="UniList.php">Universities</a>
        <a href="ProgramOptions.php">Program Options</a>
        <a href="UsefulResources.php">Useful resources</a>
        <a href="Opportunities.php">Opportunities</a>
        <a href="Us.php">About Us</a>
        <a href="help.php">Help</a>
    </div>

    <span class="menu-btn" onclick="openNav()">&#9776;</span>

    <h1>Opportunities</h1>

    <div class="opportunity-list">
        <?php foreach ($opportunities as $opportunity): ?>
            <div class="opportunity-item">
                <h3><?= htmlspecialchars($opportunity->getTitle()) ?></h3>
                <div class="opportunity-meta">
                    <strong>Type:</strong> <?= htmlspecialchars($opportunity->getType()) ?> |
                    <strong>Deadline:</strong> <?= htmlspecialchars($opportunity->getDeadline()) ?>
                </div>
                <p><?= htmlspecialchars($opportunity->getDescription()) ?></p>
                <a href="<?= htmlspecialchars($opportunity->getLink()) ?>" target="_blank" rel="noopener noreferrer">Learn More</a>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
