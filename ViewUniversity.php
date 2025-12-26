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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= htmlspecialchars($uni->getName()) ?> - Unifind</title>
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

    <div class="container">
        <header class="uni-banner" <?= $campusPath ? "style=\"background-image: url('$campusPath');\"" : "" ?>>
            <div class="uni-profile-info">
                <?php if ($logoPath): ?>
                    <img src="<?= htmlspecialchars($logoPath) ?>" alt="<?= htmlspecialchars($uni->getName()) ?> Logo" class="uni-logo-large">
                <?php endif; ?>
                <div class="uni-name-header">
                    <span class="badge-modern badge-primary mb-4">University Profile</span>
                    <h1 style="color: white;"><?= htmlspecialchars($uni->getName()) ?></h1>
                </div>
            </div>
        </header>

        <nav class="tabs-modern" role="tablist">
            <div class="tab-pill active" role="tab" onclick="switchTab('general', this)">Overview</div>
            <div class="tab-pill" role="tab" onclick="switchTab('programs', this)">Programmes</div>
            <div class="tab-pill" role="tab" onclick="switchTab('announcements', this)">Announcements</div>
        </nav>

        <main>
            <!-- General Info Tab -->
            <section id="general" class="tab-content active">
                <div class="card mb-4">
                    <h2 class="mb-4">About the University</h2>
                    <p style="font-size: 1.1rem;"><?= nl2br(htmlspecialchars($uni->getDescription())) ?></p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    <div class="card">
                        <h3 class="mb-4">Contact Details</h3>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div>
                                <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Website</div>
                                <a href="<?= htmlspecialchars($uni->getWebsite()) ?>" target="_blank" style="font-weight: 600;"><?= htmlspecialchars($uni->getWebsite()) ?></a>
                            </div>
                            <div>
                                <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Email</div>
                                <div style="font-weight: 600;"><?= htmlspecialchars($uni->getEmail()) ?></div>
                            </div>
                            <div>
                                <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Student Portal</div>
                                <a href="<?= htmlspecialchars($uni->getPortal()) ?>" target="_blank" style="font-weight: 600;">Access Portal &rarr;</a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h3 class="mb-4">Locations</h3>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <?php foreach ($uni->getAddresses() as $type => $address): ?>
                                <div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700;"><?= htmlspecialchars($type) ?></div>
                                    <div style="font-weight: 600;"><?= htmlspecialchars($address) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Programs Tab -->
            <section id="programs" class="tab-content">
                <div class="card mb-4" style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; justify-content: space-between;">
                    <h2 style="margin: 0;">Programmes Offered</h2>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <label for="facultySelect" style="font-weight: 600; font-size: 0.9rem;">Faculty:</label>
                        <select id="facultySelect" onchange="scrollToFaculty(this.value)" style="padding: 0.6rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border); background: white; font-weight: 500;">
                            <?php foreach (array_keys($programsByFaculty) as $faculty): ?>
                                <option value="<?= htmlspecialchars($faculty) ?>"><?= htmlspecialchars($faculty) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div id="programList" style="max-height: 70vh; overflow-y: auto; padding-right: 0.5rem;">
                    <?php foreach ($programsByFaculty as $faculty => $programs): ?>
                        <div class="faculty-section" id="faculty-<?= htmlspecialchars($faculty) ?>">
                            <h3 style="margin: 2rem 0 1.5rem; display: flex; align-items: center; gap: 1rem;">
                                <?= htmlspecialchars($faculty) ?>
                                <span style="height: 2px; flex: 1; background: var(--border);"></span>
                            </h3>
                            <div class="program-grid-modern">
                                <?php foreach ($programs as $program): ?>
                                    <div class="program-card-modern">
                                        <div class="mb-4">
                                            <span class="badge-modern badge-primary">Degree</span>
                                        </div>
                                        <h4 class="mb-4"><a href="#" class="show-program" data-id="<?= htmlspecialchars($program->getId()) ?>"><?= htmlspecialchars($program->getName()) ?></a></h4>
                                        <p style="font-size: 0.9rem; color: var(--text-muted); flex-grow: 1; margin-bottom: 1.5rem;">
                                            <?= htmlspecialchars(substr($program->getDescription(), 0, 100)) ?>...
                                        </p>
                                        <div style="border-top: 1px solid var(--border); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                                            <span style="font-size: 0.85rem; font-weight: 600;">⏱ <?= htmlspecialchars($program->getDuration()) ?></span>
                                            <button class="show-program" data-id="<?= htmlspecialchars($program->getId()) ?>" style="background: none; border: none; color: var(--primary); font-weight: 700; cursor: pointer; font-size: 0.85rem;">Details &rarr;</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Announcements Tab -->
            <section id="announcements" class="tab-content">
                <?php if (empty($announcements)): ?>
                    <div class="card text-center" style="padding: 4rem;">
                        <p style="color: var(--text-muted);">No announcements available at this time.</p>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <?php foreach ($announcements as $ann): ?>
                            <article class="card announcement">
                                <div class="date"><?= htmlspecialchars($ann->getDate()) ?></div>
                                <h3 class="mb-4"><?= htmlspecialchars($ann->getHeading()) ?></h3>
                                <p style="font-size: 1.05rem;"><?= nl2br(htmlspecialchars($ann->getBody())) ?></p>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
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