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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .search-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-top: 2rem;
        }
        .search-box {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .search-input {
            flex: 1;
            padding: 1.2rem 1.5rem;
            border: none;
            font-size: 1.1rem;
            outline: none;
        }
        .search-submit {
            padding: 0 2rem;
            background: var(--primary-color);
            color: white;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .search-submit:hover {
            background: var(--primary-hover);
        }
        .result-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .badge {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-weight: 700;
        }
        .badge-uni { background: #dcfce7; color: #166534; }
        .badge-prog { background: #dbeafe; color: #1e40af; }
    </style>
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
        <header class="search-header">
            <h1>Unifind</h1>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Discover your future academic path</p>
            <form class="search-box" action="search.php" method="get">
                <input type="text" class="search-input" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Search universities or programs..." required>
                <button type="submit" class="search-submit">Search</button>
            </form>
        </header>

        <main class="results-grid">
            <?php if ($query): ?>
                <h2 style="margin-bottom: 1.5rem;">Results for "<?= htmlspecialchars($query) ?>"</h2>
                
                <?php if (empty($results)): ?>
                    <div class="card" style="text-align: center; padding: 4rem;">
                        <p style="font-size: 1.2rem; color: var(--text-muted);">No matching university or program found.</p>
                        <a href="index.html" style="color: var(--primary-color); display: inline-block; margin-top: 1rem;">Try a different search</a>
                    </div>
                <?php else: ?>
                    <div class="program-grid">
                        <?php foreach ($results as $result): ?>
                            <div class="program-card">
                                <div class="result-meta">
                                    <?php if ($result['type'] === 'university'): ?>
                                        <span class="badge badge-uni">University</span>
                                    <?php else: ?>
                                        <span class="badge badge-prog">Program</span>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($result['matched_field'])): ?>
                                        <span style="font-size: 0.8rem; color: var(--text-muted);">Matched in: <?= htmlspecialchars($result['matched_field']) ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($result['type'] === 'university'): ?>
                                    <h4><a href="ViewUniversity.php?id=<?= htmlspecialchars($result['id']) ?>"><?= htmlspecialchars($result['name']) ?></a></h4>
                                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-top: 0.5rem;">
                                        <?= htmlspecialchars(substr($unis[$result['id']]->getDescription(), 0, 150)) ?>...
                                    </p>
                                <?php else: ?>
                                    <h4><a href="#" class="show-program" data-id="<?= htmlspecialchars($result['id']) ?>"><?= htmlspecialchars($result['name']) ?></a></h4>
                                    <?php 
                                        $prog = $programs[$result['id']];
                                        $uniName = isset($unis[$result['university_id']]) ? $unis[$result['university_id']]->getName() : 'Unknown University';
                                    ?>
                                    <p style="font-size: 0.85rem; margin: 0.5rem 0;">
                                        <strong><?= htmlspecialchars($prog->getFaculty()) ?></strong> at 
                                        <a href="ViewUniversity.php?id=<?= htmlspecialchars($result['university_id']) ?>" style="color: var(--primary-color);"><?= htmlspecialchars($uniName) ?></a>
                                    </p>
                                    <p style="font-size: 0.9rem; color: var(--text-muted);">
                                        <?= htmlspecialchars(substr($prog->getDescription(), 0, 120)) ?>...
                                    </p>
                                    <div class="field-list">
                                        <?php foreach ($prog->getFields() as $field): ?>
                                            <span class="field-tag"><?= htmlspecialchars($field) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="card" style="text-align: center; padding: 4rem;">
                    <p style="font-size: 1.2rem; color: var(--text-muted);">Please enter a search query above.</p>
                </div>
            <?php endif; ?>
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
