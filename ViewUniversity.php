<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

// Get university ID from URL
$uniId = $_GET['id'] ?? null;

if (!$uniId) {
    die('University ID is required');
}

// Get university data
$unis = DataService::getUnisList();
if (!isset($unis[$uniId])) {
    die('University not found');
}
$uni = $unis[$uniId];

// Determine logo path if exists
$logoPath = null;
$logoPng = "extras/{$uniId}/logo.png";
$logoJpg = "extras/{$uniId}/logo.jpg";
if (file_exists($logoPng)) {
    $logoPath = $logoPng;
} elseif (file_exists($logoJpg)) {
    $logoPath = $logoJpg;
}

// Get all programs for this university
$allPrograms = DataService::getProgrammeList();
$announcements = DataService::getAnnouncements($uniId);
$uniPrograms = array_filter($allPrograms, function ($p) use ($uniId) {
    return $p->getUniId() == $uniId;
});

// Group programs by faculty
$programsByFaculty = [];
foreach ($uniPrograms as $program) {
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
    <title><?= htmlspecialchars($uni->getName()) ?> - Unifind</title>
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

        .uni-header {
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            position: relative;
            color: white;
            padding: 6rem 2rem;
            border-radius: 8px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .uni-header::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            border-radius: 8px;
            z-index: 0;
        }

        .uni-logo {
            max-height: 60px;
            max-width: 60px;
            object-fit: contain;
            border-radius: 8px;
            position: relative;
            z-index: 1;
        }

        .uni-header h1 {
            position: relative;
            z-index: 1;
            margin: 0;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 1.5rem;
        }

        .tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
            margin-right: 0.5rem;
        }

        .tab.active {
            background: white;
            border-bottom: 1px solid white;
            margin-bottom: -1px;
        }

        .tab-content {
            display: none;
            padding: 1.5rem;
            background: white;
            border-radius: 0 8px 8px 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .tab-content.active {
            display: block;
        }

        .faculty-nav {
            margin-bottom: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .faculty-nav button {
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .faculty-nav button.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .program-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 4px;
        }

        .faculty-section {
            scroll-margin-top: 80px;
        }

        .program-item {
            padding: 1rem;
            border: 1px solid #eee;
            border-radius: 4px;
        }

        .field-tag {
            background: #f0f0f0;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .field-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        a {
            color: inherit;
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
            background-color: rgba(0, 0, 0, 0.5);
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .close-modal {
            float: right;
            cursor: pointer;
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
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
    <?php
    $campusPng = "extras/{$uniId}/campus.png";
    $campusJpg = "extras/{$uniId}/campus.jpg";
    $campusImagePath = null;
    if (file_exists($campusPng)) {
        $campusImagePath = $campusPng;
    } elseif (file_exists($campusJpg)) {
        $campusImagePath = $campusJpg;
    }
    ?>
    <div class="uni-header" <?php if ($campusImagePath): ?> style="background-image: url('<?= htmlspecialchars($campusImagePath) ?>');" <?php endif; ?>>
        <?php if ($logoPath): ?>
            <img src="<?= htmlspecialchars($logoPath) ?>" alt="<?= htmlspecialchars($uni->getName()) ?> Logo" class="uni-logo">
        <?php endif; ?>
        <h1><?= htmlspecialchars($uni->getName()) ?></h1>
    </div>

    <div class="tabs">
        <div class="tab active" onclick="switchTab('general')">General Information</div>
        <div class="tab" onclick="switchTab('programs')">Programmes</div>
        <div class="tab" onclick="switchTab('announcements')">Announcements</div>
    </div>

    <div id="general" class="tab-content active">
        <h2>About <?= htmlspecialchars($uni->getName()) ?></h2>
        <p><?= htmlspecialchars($uni->getDescription()) ?></p>

        <h3>Contact Information</h3>
        <p>Website: <a href="<?= htmlspecialchars($uni->getWebsite()) ?>"><?= htmlspecialchars($uni->getWebsite()) ?></a></p>
        <p>Email: <?= htmlspecialchars($uni->getEmail()) ?></p>
        <p>Student Portal: <a href="<?= htmlspecialchars($uni->getPortal()) ?>"><?= htmlspecialchars($uni->getPortal()) ?></a></p>

        <h3>Location</h3>
        <?php
        foreach ($uni->getAddresses() as $key => $address) {
            echo "<p> $key at " . $address . "</p>";
        }
        ?>
    </div>

    <div id="programs" class="tab-content">
        <h2>Programmes Offered</h2>
        <div class="faculty-nav" id="facultyNav">
            <label for="facultySelect" style="font-weight: 600; margin-right: 0.5rem;">Select Faculty:</label>
            <select id="facultySelect" onchange="scrollToFaculty(this.value)" style="padding: 0.4rem 0.6rem; border-radius: 4px; border: 1px solid #ddd; font-size: 1rem; cursor: pointer;">
                <?php foreach (array_keys($programsByFaculty) as $faculty): ?>
                    <option value="<?= htmlspecialchars(addslashes($faculty)) ?>"><?= htmlspecialchars($faculty) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="program-list" id="programList">
            <?php foreach ($programsByFaculty as $faculty => $programs): ?>
                <div class="faculty-section" id="faculty-<?= htmlspecialchars(addslashes($faculty)) ?>">
                    <h3><?= htmlspecialchars($faculty) ?></h3>
                    <?php foreach ($programs as $program): ?>
                        <div class="program-item">
                            <h4><a href="#" class="show-program" data-id='<?= htmlspecialchars($program->getId()) ?>'><?= htmlspecialchars($program->getName()) ?></a></h4>
                            <p><?= htmlspecialchars($program->getDescription()) ?></p>
                            <p>Duration: <?= htmlspecialchars($program->getDuration()) ?></p>
                            <div class="field-list">
                                <?php foreach ($program->getFields() as $field): ?>
                                    <span class="field-tag"><?= htmlspecialchars($field) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="announcements" class="tab-content">
        <h2>Latest Announcements</h2>
        <?php foreach ($announcements as $announcement): ?>
            <div class="announcement">
                <h3><?= htmlspecialchars($announcement->getHeading()) ?></h3>
                <div class="date"><?= htmlspecialchars($announcement->getDate()) ?></div>
                <p><?= htmlspecialchars($announcement->getBody()) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="programModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div id="programDetails" class="program-details"></div>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        function scrollToFaculty(faculty) {
            const section = document.getElementById('faculty-' + faculty);
            if (section) {
                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        let ticking = false;
        const programList = document.getElementById('programList');
        const facultySelect = document.getElementById('facultySelect');

        function updateFacultySelectOnScroll() {
            if (!facultySelect || !programList) return;

            const faculties = Array.from(facultySelect.options).map(opt => opt.value);
            let currentFaculty = faculties[0];

            const containerRect = programList.getBoundingClientRect();
            for (const faculty of faculties) {
                const section = document.getElementById('faculty-' + faculty);
                if (section) {
                    const rect = section.getBoundingClientRect();
                    if (rect.top <= containerRect.top + 50) {
                        currentFaculty = faculty;
                    } else {
                        break;
                    }
                }
            }

            if (facultySelect.value !== currentFaculty) {
                facultySelect.value = currentFaculty;
            }
        }

        if (programList) {
            programList.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        updateFacultySelectOnScroll();
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        }
    </script>
</body>
</html>