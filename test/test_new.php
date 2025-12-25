<?php

require_once __DIR__ . '/../bootstrap.php';

use Unifind\Services\DataService;
use Unifind\Services\SearchService;

echo "Testing DataService::getUnisList()...\n";
$unis = DataService::getUnisList();
echo "Found " . count($unis) . " universities.\n";

echo "\nTesting DataService::getProgrammeList()...\n";
$programs = DataService::getProgrammeList();
echo "Found " . count($programs) . " programs.\n";

echo "\nTesting SearchService::searchPrograms('Computer')...\n";
$results = SearchService::searchPrograms('Computer', $programs);
echo "Found " . count($results) . " results for 'Computer'.\n";
foreach ($results as $res) {
    echo "- " . $res['name'] . " (Score: " . $res['score'] . ")\n";
}

echo "\nTesting SearchService::searchUniversities('Zimbabwe')...\n";
$uniResults = SearchService::searchUniversities('Zimbabwe', $unis);
echo "Found " . count($uniResults) . " results for 'Zimbabwe'.\n";
foreach ($uniResults as $res) {
    echo "- " . $res['name'] . " (Score: " . $res['score'] . ")\n";
}
