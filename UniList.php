<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$unis = DataService::getUnisList();
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Universities - Unifind</title>
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
        .uni-list {
            display: grid;
            gap: 1rem;
        }
        .uni-item {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #eee;
        }
        .uni-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .uni-item h3 {
            margin: 0 0 0.5rem 0;
            color: #000;
        }
        .uni-meta {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #666;
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
    
    <h1>All Universities</h1>
    
    <div class="uni-list">
        <?php foreach ($unis as $uni): ?>
            <div class="uni-item">
                <h3><a href="ViewUniversity.php?id=<?= htmlspecialchars($uni->getId()) ?>">
                    <?= htmlspecialchars($uni->getName()) ?>
                </a></h3>
                <p><?= htmlspecialchars($uni->getDescription() ?? 'No description available') ?></p>
                <div class="uni-meta">
                    <span>Website: <a href="<?= htmlspecialchars($uni->getWebsite()) ?>" target="_blank"><?=$uni->getWebsite() ?></a></span>
                    <span>Email: <?= htmlspecialchars($uni->getEmail()) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
