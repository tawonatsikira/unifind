<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$programs = DataService::getProgrammeList();
$unis = DataService::getUnisList();

// Group programs by faculty for the overview
$faculties = [];
foreach ($programs as $prog) {
    $faculty = $prog->getFaculty() ?: 'Other';
    $faculties[$faculty][] = $prog;
}
ksort($faculties);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Options - Unifind</title>
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
            <h1>Program Options</h1>
            <p style="color: var(--text-muted);">Browse programs by faculty across all universities</p>
        </header>

        <main>
            <div class="tabs" style="overflow-x: auto; white-space: nowrap; display: block;">
                <?php foreach (array_keys($faculties) as $index => $faculty): ?>
                    <div class="tab <?= $index === 0 ? 'active' : '' ?>" 
                         style="display: inline-block; width: auto;" 
                         onclick="switchTab('faculty-<?= md5($faculty) ?>', this)">
                        <?= htmlspecialchars($faculty) ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php foreach ($faculties as $faculty => $facultyPrograms): ?>
                <section id="faculty-<?= md5($faculty) ?>" class="tab-content <?= array_key_first($faculties) === $faculty ? 'active' : '' ?>">
                    <div class="card">
                        <h2 style="margin-bottom: 2rem;"><?= htmlspecialchars($faculty) ?></h2>
                        <div class="program-grid">
                            <?php foreach ($facultyPrograms as $prog): ?>
                                <article class="program-card">
                                    <h4><a href="#" class="show-program" data-id="<?= htmlspecialchars($prog->getId()) ?>"><?= htmlspecialchars($prog->getName()) ?></a></h4>
                                    <?php 
                                        $uniName = isset($unis[$prog->getUniId()]) ? $unis[$prog->getUniId()]->getName() : 'Unknown University';
                                    ?>
                                    <p style="font-size: 0.85rem; margin: 0.5rem 0;">
                                        at <a href="ViewUniversity.php?id=<?= htmlspecialchars($prog->getUniId()) ?>" style="color: var(--primary-color);"><?= htmlspecialchars($uniName) ?></a>
                                    </p>
                                    <p style="font-size: 0.9rem; color: var(--text-muted);">
                                        <?= htmlspecialchars(substr($prog->getDescription(), 0, 100)) ?>...
                                    </p>
                                    <div class="field-list">
                                        <?php foreach ($prog->getFields() as $field): ?>
                                            <span class="field-tag"><?= htmlspecialchars($field) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </main>
    </div>

    <!-- Program Detail Modal -->
    <div id="programModal" class="modal" role="dialog" aria-modal="true">
        <div class="modal-content">
            <span class="close-modal" aria-label="Close">&times;</span>
            <div id="programDetails"></div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
