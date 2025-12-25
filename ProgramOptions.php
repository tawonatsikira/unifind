<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$programs = DataService::getProgrammeList();
$unis = DataService::getUnisList();

// Group programs by faculty for a better overview
$programsByFaculty = [];
foreach ($programs as $program) {
    $faculty = $program->getFaculty();
    if (!isset($programsByFaculty[$faculty])) {
        $programsByFaculty[$faculty] = [];
    }
    $programsByFaculty[$faculty][] = $program;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Program Options - Unifind</title>
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
        .faculty-section {
            margin-bottom: 3rem;
        }
        .faculty-title {
            border-bottom: 2px solid #000;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .program-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
        }
        .program-card h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.2rem;
        }
        .uni-link {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }
        .field-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: auto;
            padding-top: 1rem;
        }
        .field-tag {
            background: #f0f0f0;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
        }
        a {
            color: #000;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        .close-modal {
            float: right;
            cursor: pointer;
            font-size: 1.5rem;
            font-weight: bold;
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

    <h1>Program Options</h1>

    <?php foreach ($programsByFaculty as $faculty => $facultyPrograms): ?>
        <div class="faculty-section">
            <h2 class="faculty-title"><?= htmlspecialchars($faculty) ?></h2>
            <div class="program-grid">
                <?php foreach ($facultyPrograms as $program): ?>
                    <div class="program-card">
                        <h3><a href="#" class="show-program" data-id="<?= htmlspecialchars($program->getId()) ?>">
                            <?= htmlspecialchars($program->getName()) ?>
                        </a></h3>
                        <div class="uni-link">
                            <?php 
                            $uni = $unis[$program->getUniId()] ?? null;
                            if ($uni): ?>
                                <a href="ViewUniversity.php?id=<?= htmlspecialchars($uni->getId()) ?>">
                                    <?= htmlspecialchars($uni->getName()) ?>
                                </a>
                            <?php else: ?>
                                Unknown University
                            <?php endif; ?>
                        </div>
                        <p><?= htmlspecialchars(substr($program->getDescription(), 0, 100)) ?>...</p>
                        <div class="field-list">
                            <?php foreach ($program->getFields() as $field): ?>
                                <span class="field-tag"><?= htmlspecialchars($field) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div id="programModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div id="programDetails" class="program-details"></div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
