<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

$uniId = $_GET['id'] ?? null;

if (!$uniId) {
    header("Location: UniList.php");
    exit;
}

$unis = DataService::getUnisList();
if (!isset($unis[$uniId])) {
    die('University not found');
}
$uni = $unis[$uniId];

// Determine logo and campus paths
$logoPath = null;
$logoExtensions = ['png', 'jpg', 'jpeg'];
foreach ($logoExtensions as $ext) {
    $path = "public/assets/logos/{$uniId}.{$ext}";
    if (file_exists($path)) {
        $logoPath = $path;
        break;
    }
}

$campusPath = null;
foreach ($logoExtensions as $ext) {
    $path = "public/assets/campus/{$uniId}.{$ext}";
    if (file_exists($path)) {
        $campusPath = $path;
        break;
    }
}

$allPrograms = DataService::getProgrammeList();
$announcements = DataService::getAnnouncements($uniId);
$uniPrograms = array_filter($allPrograms, function ($p) use ($uniId) {
    return $p->getUniId() == $uniId;
});

// Group programs by faculty
$programsByFaculty = [];
foreach ($uniPrograms as $program) {
    $faculty = $program->getFaculty() ?: 'Other';
    $programsByFaculty[$faculty][] = $program;
}
ksort($programsByFaculty);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($uni->getName()) ?> - Unifind</title>
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
        <header class="uni-header" <?= $campusPath ? "style=\"background-image: url('$campusPath');\"" : "" ?>>
            <?php if ($logoPath): ?>
                <img src="<?= htmlspecialchars($logoPath) ?>" alt="<?= htmlspecialchars($uni->getName()) ?> Logo" class="uni-logo">
            <?php endif; ?>
            <h1><?= htmlspecialchars($uni->getName()) ?></h1>
        </header>

        <nav class="tabs" role="tablist">
            <div class="tab active" role="tab" onclick="switchTab('general', this)">General Information</div>
            <div class="tab" role="tab" onclick="switchTab('programs', this)">Programmes</div>
            <div class="tab" role="tab" onclick="switchTab('announcements', this)">Announcements</div>
        </nav>

        <main>
            <!-- General Info Tab -->
            <section id="general" class="tab-content active card">
                <h2>About the University</h2>
                <p><?= nl2br(htmlspecialchars($uni->getDescription())) ?></p>

                <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    <div>
                        <h3>Contact Details</h3>
                        <p><strong>Website:</strong> <a href="<?= htmlspecialchars($uni->getWebsite()) ?>" target="_blank" style="color: var(--primary-color)"><?= htmlspecialchars($uni->getWebsite()) ?></a></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($uni->getEmail()) ?></p>
                        <p><strong>Portal:</strong> <a href="<?= htmlspecialchars($uni->getPortal()) ?>" target="_blank" style="color: var(--primary-color)">Student Portal</a></p>
                    </div>
                    <div>
                        <h3>Locations</h3>
                        <?php foreach ($uni->getAddresses() as $type => $address): ?>
                            <p><strong><?= htmlspecialchars($type) ?>:</strong> <?= htmlspecialchars($address) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <!-- Programs Tab -->
            <section id="programs" class="tab-content">
                <div class="card" style="margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                    <h2 style="margin: 0;">Programmes Offered</h2>
                    <div style="flex-grow: 1;"></div>
                    <label for="facultySelect" style="font-weight: 600;">Jump to Faculty:</label>
                    <select id="facultySelect" onchange="scrollToFaculty(this.value)" style="padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border-color);">
                        <?php foreach (array_keys($programsByFaculty) as $faculty): ?>
                            <option value="<?= htmlspecialchars($faculty) ?>"><?= htmlspecialchars($faculty) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="program-list card" id="programList" style="max-height: 70vh; overflow-y: auto; padding: 2rem;">
                    <?php foreach ($programsByFaculty as $faculty => $programs): ?>
                        <div class="faculty-section" id="faculty-<?= htmlspecialchars($faculty) ?>">
                            <h3><?= htmlspecialchars($faculty) ?></h3>
                            <div class="program-grid">
                                <?php foreach ($programs as $program): ?>
                                    <div class="program-card">
                                        <h4><a href="#" class="show-program" data-id="<?= htmlspecialchars($program->getId()) ?>"><?= htmlspecialchars($program->getName()) ?></a></h4>
                                        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0.5rem 0;"><?= htmlspecialchars(substr($program->getDescription(), 0, 120)) ?>...</p>
                                        <p><strong>Duration:</strong> <?= htmlspecialchars($program->getDuration()) ?></p>
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
                </div>
            </section>

            <!-- Announcements Tab -->
            <section id="announcements" class="tab-content card">
                <h2>Latest Announcements</h2>
                <?php if (empty($announcements)): ?>
                    <p>No announcements available at this time.</p>
                <?php else: ?>
                    <?php foreach ($announcements as $ann): ?>
                        <article class="announcement">
                            <div class="date"><?= htmlspecialchars($ann->getDate()) ?></div>
                            <h3><?= htmlspecialchars($ann->getHeading()) ?></h3>
                            <p><?= nl2br(htmlspecialchars($ann->getBody())) ?></p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
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