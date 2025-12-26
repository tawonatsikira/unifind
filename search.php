<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;
use Unifind\Services\SearchService;

// Load university and program data
$unis = DataService::getUnisList();
$programs = DataService::getProgrammeList();

function searchQuery($query) {
    global $unis, $programs;
    
    $uniResults = SearchService::searchUniversities($query, $unis);
    $programResults = SearchService::searchPrograms($query, $programs);
    $allResults = array_merge($uniResults, $programResults);
    
    return SearchService::sortResults($allResults);
}

// Handle search request
$query = $_GET['q'] ?? '';
$mode = $_GET['mode'] ?? 'search';
$results = $query ? searchQuery($query) : [];

if ($mode === 'test') {
    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Search Results - Unifind</title>
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
            <h1 class="mb-4">Search Results</h1>
            <div class="search-wrapper">
                <form class="search-container-modern" action="search.php" method="get">
                    <input type="text" class="search-input-modern" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Search universities or programs..." required>
                    <button type="submit" class="search-btn-modern">Search</button>
                </form>
            </div>
        </header>

        <main>
            <?php if ($query): ?>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                    <h2 style="font-size: 1.25rem;">Found <?= count($results) ?> results for "<?= htmlspecialchars($query) ?>"</h2>
                </div>
                
                <?php if (empty($results)): ?>
                    <div class="card text-center" style="padding: 5rem 2rem;">
                        <div style="font-size: 3rem; margin-bottom: 1.5rem;">🔍</div>
                        <h3>No matches found</h3>
                        <p style="color: var(--text-muted); margin-top: 1rem;">Try adjusting your keywords or browsing by faculty.</p>
                        <a href="ProgramOptions.php" class="tab-pill active" style="display: inline-block; margin-top: 2rem; width: auto; padding: 0.8rem 2rem;">Browse Programs</a>
                    </div>
                <?php else: ?>
                    <div class="program-grid-modern">
                        <?php foreach ($results as $result): ?>
                            <div class="program-card-modern">
                                <div class="mb-4">
                                    <?php if ($result['type'] === 'university'): ?>
                                        <span class="badge-modern badge-secondary">University</span>
                                    <?php else: ?>
                                        <span class="badge-modern badge-primary">Program</span>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($result['matched_field'])): ?>
                                        <span style="font-size: 0.75rem; color: var(--text-muted); margin-left: 0.5rem;">Match: <?= htmlspecialchars($result['matched_field']) ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($result['type'] === 'university'): ?>
                                    <h4 class="mb-4"><a href="ViewUniversity.php?id=<?= htmlspecialchars($result['id']) ?>"><?= htmlspecialchars($result['name']) ?></a></h4>
                                    <p style="font-size: 0.9rem; color: var(--text-muted); flex-grow: 1; margin-bottom: 1.5rem;">
                                        <?= htmlspecialchars(substr($unis[$result['id']]->getDescription(), 0, 150)) ?>...
                                    </p>
                                    <div style="border-top: 1px solid var(--border); padding-top: 1rem;">
                                        <a href="ViewUniversity.php?id=<?= htmlspecialchars($result['id']) ?>" style="font-weight: 700; font-size: 0.85rem;">View Profile &rarr;</a>
                                    </div>
                                <?php else: ?>
                                    <h4 class="mb-4"><a href="#" class="show-program" data-id="<?= htmlspecialchars($result['id']) ?>"><?= htmlspecialchars($result['name']) ?></a></h4>
                                    <?php 
                                        $prog = $programs[$result['id']];
                                        $uniName = isset($unis[$result['university_id']]) ? $unis[$result['university_id']]->getName() : 'Unknown University';
                                    ?>
                                    <p style="font-size: 0.85rem; margin-bottom: 1rem;">
                                        <strong><?= htmlspecialchars($prog->getFaculty()) ?></strong> at 
                                        <a href="ViewUniversity.php?id=<?= htmlspecialchars($result['university_id']) ?>" style="font-weight: 600;"><?= htmlspecialchars($uniName) ?></a>
                                    </p>
                                    <p style="font-size: 0.9rem; color: var(--text-muted); flex-grow: 1; margin-bottom: 1.5rem;">
                                        <?= htmlspecialchars(substr($prog->getDescription(), 0, 120)) ?>...
                                    </p>
                                    <div style="border-top: 1px solid var(--border); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                                        <div class="field-list" style="display: flex; gap: 0.25rem; overflow: hidden;">
                                            <?php foreach (array_slice($prog->getFields(), 0, 2) as $field): ?>
                                                <span class="badge-modern" style="background: #f1f5f9; font-size: 0.65rem;"><?= htmlspecialchars($field) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        <button class="show-program" data-id="<?= htmlspecialchars($result['id']) ?>" style="background: none; border: none; color: var(--primary); font-weight: 700; cursor: pointer; font-size: 0.85rem;">Details &rarr;</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="card text-center" style="padding: 5rem 2rem;">
                    <p style="font-size: 1.1rem; color: var(--text-muted);">Please enter a search query above to find universities or programs.</p>
                </div>
            <?php endif; ?>
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
