<?php

namespace Unifind\Services;

use Unifind\Models\University;
use Unifind\Models\Programme;
use Unifind\Models\Announcement;
use Unifind\Models\Subject;
use Unifind\Models\Requirements;
use Unifind\Models\Opportunity;
use Unifind\Models\UsefulResource;
use Exception;

class DataService {
    private static $basePath = __DIR__ . '/../../data/';

    /**
     * Helper to load and decode JSON with error handling
     */
    private static function loadJson($filename) {
        $path = self::$basePath . $filename;
        if (!file_exists($path)) {
            error_log("DataService: File not found - $path");
            return [];
        }

        $content = file_get_contents($path);
        if ($content === false) {
            error_log("DataService: Failed to read file - $path");
            return [];
        }

        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("DataService: JSON decode error in $filename - " . json_last_error_msg());
            return [];
        }

        return $data ?? [];
    }

    /**
     * Helper to encode and save JSON with error handling
     */
    private static function saveJson($filename, $data) {
        $path = self::$basePath . $filename;
        $content = json_encode($data, JSON_PRETTY_PRINT);
        
        if ($content === false) {
            error_log("DataService: JSON encode error for $filename - " . json_last_error_msg());
            return false;
        }

        if (file_put_contents($path, $content) === false) {
            error_log("DataService: Failed to write to file - $path");
            return false;
        }

        return true;
    }

    public static function getUnisList() {
        $unisData = self::loadJson('universities.json');
        $uniObjects = [];
        
        foreach ($unisData as $uniName => $uniData) {
            if (!isset($uniData['Id'])) continue;
            
            $uniObjects[$uniData['Id']] = new University(
                $uniData['Name'] ?? $uniName,
                $uniData['Id'],
                $uniData['Website'] ?? '',
                $uniData['Portal'] ?? '',
                $uniData['Email'] ?? '',
                $uniData['Contacts'] ?? [],
                $uniData['AltNames'] ?? [],
                $uniData['Addresses'] ?? [],
                $uniData['Description'] ?? ''
            );
        }
        
        return $uniObjects;
    }

    public static function getProgrammeList() {
        $programmesData = self::loadJson('programs.json');
        $programmeObjects = [];
        
        foreach ($programmesData as $programName => $programData) {
            if (!isset($programData['id']) || !isset($programData['Name'])) {
                continue;
            }
            $programmeObjects[$programData['id']] = new Programme(
                $programData['id'],
                $programData['Name'],
                $programData['Description'] ?? '',
                $programData['Duration'] ?? '',
                $programData['Faculty'] ?? '',
                $programData['University'] ?? 0,
                $programData['Requirements'] ?? '',
                $programData['Fields'] ?? []
            );
        }
        
        return $programmeObjects;
    }

    public static function getAnnouncements($uniId) {
        $announcementsData = self::loadJson("announcements/$uniId.json");
        $announcements = [];

        foreach($announcementsData as $announcementData){
            if (!isset($announcementData['id'])) continue;
            
            $announcements[] = new Announcement(
                $announcementData["id"],
                $announcementData["date"] ?? '',
                $announcementData["heading"] ?? 'No Heading',
                $announcementData["body"] ?? ''
            );
        }
        return array_reverse($announcements);
    }

    public static function getSubjects() {
        $subjectsData = self::loadJson("subjects.json");
        $subjects = [];

        foreach($subjectsData as $subjectName => $subjectdata){
            if (!isset($subjectdata['Id'])) continue;
            
            $subjects[$subjectdata["Id"]] = new Subject(
                $subjectdata["Id"],
                $subjectdata["Name"] ?? $subjectName,
                $subjectdata["Class"] ?? ''
            );
        }

        return $subjects;
    }

    public static function getOpportunities() {
        $opportunitiesData = self::loadJson('opportunities.json');
        $opportunities = [];

        foreach($opportunitiesData as $opportunityData){
            if (!isset($opportunityData['id'])) continue;
            
            $opportunities[] = new Opportunity(
                $opportunityData['id'],
                $opportunityData['type'] ?? '',
                $opportunityData['title'] ?? 'Untitled',
                $opportunityData['description'] ?? '',
                $opportunityData['deadline'] ?? '',
                $opportunityData['link'] ?? ''
            );
        }
        return $opportunities;
    }

    public static function getUsefulResources() {
        $resourcesData = self::loadJson('resources.json');
        $resources = [];

        foreach($resourcesData as $resourceData){
            if (!isset($resourceData['id'])) continue;
            
            $resources[] = new UsefulResource(
                $resourceData['id'],
                $resourceData['title'] ?? 'Untitled',
                $resourceData['description'] ?? '',
                $resourceData['link'] ?? ''
            );
        }
        return $resources;
    }

    public static function addAnnouncement($uniId, $announcement) {
        $filename = "announcements/$uniId.json";
        $announcementsData = self::loadJson($filename);
        
        $announcementsData[] = [
            "id" => $announcement->getId(),
            "date" => $announcement->getDate(),
            "heading" => $announcement->getHeading(),
            "body" => $announcement->getBody()
        ];

        return self::saveJson($filename, $announcementsData);
    }

    public static function addOpportunity($opportunity) {
        $filename = 'opportunities.json';
        $opportunitiesData = self::loadJson($filename);
        
        $opportunitiesData[] = [
            "id" => $opportunity->getId(),
            "type" => $opportunity->getType(),
            "title" => $opportunity->getTitle(),
            "description" => $opportunity->getDescription(),
            "deadline" => $opportunity->getDeadline(),
            "link" => $opportunity->getLink()
        ];

        return self::saveJson($filename, $opportunitiesData);
    }
}
