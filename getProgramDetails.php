<?php

require_once 'bootstrap.php';

use Unifind\Services\DataService;

header('Content-Type: application/json');

$programId = $_GET['id'] ?? null;

if (!$programId || !is_numeric($programId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Valid program ID is required']);
    exit;
}

try {
    $programs = DataService::getProgrammeList();
    if (!isset($programs[$programId])) {
        http_response_code(404);
        echo json_encode(['error' => 'Program not found']);
        exit;
    }
    $program = $programs[$programId];

    $unis = DataService::getUnisList();
    $universityName = isset($unis[$program->getUniId()]) 
        ? $unis[$program->getUniId()]->getName() 
        : 'Unknown University';

    $response = [
        'name' => $program->getName(),
        'description' => $program->getDescription(),
        'duration' => $program->getDuration(),
        'faculty' => $program->getFaculty(),
        'university' => $universityName,
        'requirements' => $program->getRequirements(),
        'fields' => $program->getFields()
    ];

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load program data: ' . $e->getMessage()]);
}
