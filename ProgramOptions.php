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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Program Options - Unifind</title>
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
            <span class="badge-modern badge-primary mb-4">Academic Catalog</span>
            <h1>Browse Programs</h1>
            <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto 0;">Explore hundreds of degrees across all faculties and universities in Zimbabwe.</p>
        </header>

        <main>
            <nav class="tabs-modern" style="overflow-x: auto; padding-bottom: 0.5rem;">
                <?php foreach (array_keys($faculties) as $index => $faculty): ?>
                    <div class="tab-pill <?= $index === 0 ? 'active' : '' ?>" 
                         style="min-width: 150px;" 
                         onclick="switchTab('faculty-<?= md5($faculty) ?>', this)">
                        <?= htmlspecialchars($faculty) ?>
                    </div>
                <?php endforeach; ?>
            </nav>

            <?php foreach ($faculties as $faculty => $facultyPrograms): ?>
                <section id="faculty-<?= md5($faculty) ?>" class="tab-content <?= array_key_first($faculties) === $faculty ? 'active' : '' ?>">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                        <h2 style="margin: 0;"><?= htmlspecialchars($faculty) ?></h2>
                        <span style="height: 2px; flex: 1; background: var(--border);"></span>
                        <span class="badge-modern badge-primary"><?= count($facultyPrograms) ?> Programs</span>
                    </div>
                    
                    <div class="program-grid-modern">
                        <?php foreach ($facultyPrograms as $prog): ?>
                            <article class="program-card-modern">
                                <div class="mb-4">
                                    <span class="badge-modern badge-secondary">Degree</span>
                                </div>
                                <h4 class="mb-4"><a href="#" class="show-program" data-id="<?= htmlspecialchars($prog->getId()) ?>"><?= htmlspecialchars($prog->getName()) ?></a></h4>
                                <?php 
                                    $uniName = isset($unis[$prog->getUniId()]) ? $unis[$prog->getUniId()]->getName() : 'Unknown University';
                                ?>
                                <p style="font-size: 0.85rem; margin-bottom: 1rem;">
                                    at <a href="ViewUniversity.php?id=<?= htmlspecialchars($prog->getUniId()) ?>" style="font-weight: 600;"><?= htmlspecialchars($uniName) ?></a>
                                </p>
                                <p style="font-size: 0.9rem; color: var(--text-muted); flex-grow: 1; margin-bottom: 1.5rem;">
                                    <?= htmlspecialchars(substr($prog->getDescription(), 0, 100)) ?>...
                                </p>
                                <div style="border-top: 1px solid var(--border); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                                    <div class="field-list" style="display: flex; gap: 0.25rem; overflow: hidden;">
                                        <?php foreach (array_slice($prog->getFields(), 0, 2) as $field): ?>
                                            <span class="badge-modern" style="background: #f1f5f9; font-size: 0.65rem;"><?= htmlspecialchars($field) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="show-program" data-id="<?= htmlspecialchars($prog->getId()) ?>" style="background: none; border: none; color: var(--primary); font-weight: 700; cursor: pointer; font-size: 0.85rem;">Details &rarr;</button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </main>
    </div>

    <!-- Program Detail Modal -->
    <div id="programModal" class="modal-modern" role="dialog" aria-modal="true">
        <div class="modal-content-modern">
            <span class="close-modal" aria-label="Close" onclick="document.getElementById('programModal').style.display='none'">&times;</span>
            <div id="programDetails"></div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
