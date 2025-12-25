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
    
    $sortedResults = SearchService::sortResults($allResults);
    
    return $sortedResults ?: [
        'type' => 'none',
        'message' => 'No matching university or program found'
    ];
}

// Handle search request
if (isset($_GET['q'])) {
    $mode = $_GET['mode'] ?? 'search';
    $results = searchQuery($_GET['q']);
    
    if ($mode === 'test') {
        header('Content-Type: application/json');
        if (count($results) === 1 && isset($results[0]['score']) && $results[0]['score'] == 100) {
            echo json_encode($results[0]);
        } else {
            echo json_encode($results);
        }
    } elseif ($mode === 'search') {
        header('Content-Type: text/html');
        // The rest of the HTML remains mostly the same, but we use the new $unis and $programs
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Unifind</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <style>
                body {
                    font-family: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
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
                .search-container {
                    margin-bottom: 2.5rem;
                    display: flex;
                    justify-content: center;
                }
                .search-form {
                    width: 100%;
                    max-width: 600px;
                    display: flex;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                }
                .search-bar {
                    flex: 1;
                    padding: 1rem 1.5rem;
                    font-size: 1rem;
                    border: none;
                    border-radius: 8px 0 0 8px;
                    outline: none;
                }
                .search-btn {
                    padding: 0 1.5rem;
                    background: #000;
                    color: white;
                    border: none;
                    border-radius: 0 8px 8px 0;
                    cursor: pointer;
                    font-weight: 500;
                    transition: all 0.2s;
                }
                .search-btn:hover {
                    background: #333;
                }
                .results {
                    display: grid;
                    gap: 1rem;
                }
                .result-item {
                    background: white;
                    padding: 1.5rem;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                    transition: transform 0.2s, box-shadow 0.2s;
                }
                .result-item:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                }
                .result-item h3 {
                    margin: 0 0 0.5rem 0;
                    color: #000;
                }
                .result-type {
                    display: inline-block;
                    background: #eee;
                    padding: 0.25rem 0.5rem;
                    border-radius: 4px;
                    font-size: 0.8rem;
                    margin-bottom: 0.5rem;
                }
                .result-score {
                    color: #666;
                    font-size: 0.9rem;
                }
                .no-results {
                    text-align: center;
                    color: #666;
                    margin-top: 2rem;
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
                    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
                }
                .close-modal {
                    float: right;
                    cursor: pointer;
                    font-size: 1.5rem;
                    font-weight: bold;
                }
                .program-details {
                    margin-top: 1rem;
                }
                .program-detail {
                    margin-bottom: 0.5rem;
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
            <h1>Unifind</h1>
            <div class="search-container">
                <form class="search-form" action="search.php" method="get">
                    <input type="text" class="search-bar" name="q" value="<?php echo htmlspecialchars($_GET['q']); ?>" placeholder="Search universities or programs...">
                    <input type="hidden" name="mode" value="search">
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>
            <div class="results">
                <?php
                $hasResults = !empty($results) && (!isset($results['type']) || $results['type'] !== 'none');
                if ($hasResults) {
                    foreach ($results as $result) {
                        echo '<div class="result-item">';
                        if ($result['type'] === 'university') {
                            echo '<h3><a href="ViewUniversity.php?id='.htmlspecialchars($result['id']).'">'.htmlspecialchars($result['name']).'</a></h3> ';
                            $Description = $unis[$result['id']]->getDescription();
                            echo '<p>'.htmlspecialchars($Description).'</p>';
                        } else {
                            echo '<h3><a href="#" class="show-program" data-id="'.htmlspecialchars($result['id']).'">'.htmlspecialchars($result['name']).'</a></h3>';
                            $uniName = $unis[$result["university_id"]]->getName();
                            $faculty = $programs[$result["id"]]->getFaculty();
                            $Description = $programs[$result["id"]]->getDescription();
                            echo "<p>".htmlspecialchars($Description) ."</p>";
                            echo '<p><i>    '.htmlspecialchars($faculty) . ' <a href="ViewUniversity.php?id='.htmlspecialchars($result['university_id']).'">'.htmlspecialchars("[$uniName]").'</a><i></p>';
                            echo "<div class='field-list'>";
                            foreach($programs[$result["id"]]->getFields() as $fields){
                                echo " <span class='field-tag'>". htmlspecialchars($fields) ."</span>";
                            }
                            echo '</div>';
                        }
                        echo '<div class="result-meta">';
                        if (isset($result['matched_field'])) {
                            echo '<span>Field: '.htmlspecialchars($result['matched_field']).'</span>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="no-results">No results found for "'.htmlspecialchars($_GET['q']).'"</div>';
                }
                ?>
            </div>
            <div id="programModal" class="modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <div id="programDetails" class="program-details"></div>
                </div>
            </div>
            <script src="script.js"></script>
        </body>
        </html>
        <?php
    }
}
?>
