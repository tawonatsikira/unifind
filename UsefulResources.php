<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$resources = DataService::getUsefulResources();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Useful Resources - Unifind</title>
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
        .resource-list {
            display: grid;
            gap: 1.5rem;
        }
        .resource-item {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }
        .resource-item h3 {
            margin: 0 0 0.5rem 0;
        }
        .resource-link {
            display: inline-block;
            margin-top: 1rem;
            font-weight: 600;
            color: #000;
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

    <h1>Useful Resources</h1>

    <div class="resource-list">
        <?php foreach ($resources as $resource): ?>
            <div class="resource-item">
                <h3><?= htmlspecialchars($resource->getTitle()) ?></h3>
                <p><?= htmlspecialchars($resource->getDescription()) ?></p>
                <a href="<?= htmlspecialchars($resource->getLink()) ?>" class="resource-link" target="_blank">Access Resource &rarr;</a>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
