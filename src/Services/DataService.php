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
    private static $basePath = __DIR__ . '/../../';

    public static function getUnisList() {
        $path = self::$basePath . 'unis.json';
        if (!file_exists($path)) return [];
        
        $unisData = json_decode(file_get_contents($path), true);
        $uniObjects = [];
        
        foreach ($unisData as $uniName => $uniData) {
            $uniObjects[$uniData['Id']] = new University(
                $uniData['Name'],
                $uniData['Id'],
                $uniData['Website'],
                $uniData['Portal'],
                $uniData['Email'],
                $uniData['Contacts'],
                $uniData['AltNames'],
                $uniData['Addresses'],
                $uniData['Description']
            );
        }
        
        return $uniObjects;
    }

    public static function getProgrammeList() {
        $path = self::$basePath . 'programs2.json';
        if (!file_exists($path)) return [];

        $programmesData = json_decode(file_get_contents($path), true);
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
        $path = self::$basePath . "extras/$uniId/announcements.json";
        if (!file_exists($path)) return [];

        $announcementsData = json_decode(file_get_contents($path), true);
        $announcements = [];

        foreach($announcementsData as $announcementData){
            $announcements[] = new Announcement(
                $announcementData["id"],
                $announcementData["date"],
                $announcementData["heading"],
                $announcementData["body"]
            );
        }
        return array_reverse($announcements);
    }

    public static function getSubjects() {
        $path = self::$basePath . "Subjects.json";
        if (!file_exists($path)) return [];

        $subjectsData = json_decode(file_get_contents($path), true);
        $subjects = [];

        foreach($subjectsData as $subjectName => $subjectdata){
            $subjects[$subjectdata["Id"]] = new Subject(
                $subjectdata["Id"],
                $subjectdata["Name"],
                $subjectdata["Class"]
            );
        }

        return $subjects;
    }

    public static function getOpportunities() {
        $path = self::$basePath . 'opportunities.json';
        if (!file_exists($path)) return [];

        $opportunitiesData = json_decode(file_get_contents($path), true);
        $opportunities = [];

        foreach($opportunitiesData as $opportunityData){
            $opportunities[] = new Opportunity(
                $opportunityData['id'],
                $opportunityData['type'],
                $opportunityData['title'],
                $opportunityData['description'],
                $opportunityData['deadline'],
                $opportunityData['link']
            );
        }
        return $opportunities;
    }

    public static function getUsefulResources() {
        $path = self::$basePath . 'useful_resources.json';
        if (!file_exists($path)) return [];

        $resourcesData = json_decode(file_get_contents($path), true);
        $resources = [];

        foreach($resourcesData as $resourceData){
            $resources[] = new UsefulResource(
                $resourceData['id'],
                $resourceData['title'],
                $resourceData['description'],
                $resourceData['link']
            );
        }
        return $resources;
    }

    public static function addAnnouncement($uniId, $announcement) {
        $path = self::$basePath . "extras/$uniId/announcements.json";
        if(!file_exists($path)) return false;

        $announcementsData = json_decode(file_get_contents($path), true);
        $announcementsData[] = [
            "id" => $announcement->getId(),
            "date" => $announcement->getDate(),
            "heading" => $announcement->getHeading(),
            "body" => $announcement->getBody()
        ];

        return file_put_contents($path, json_encode($announcementsData, JSON_PRETTY_PRINT)) !== false;
    }

    public static function addOpportunity($opportunity) {
        $path = self::$basePath . 'opportunities.json';
        if(!file_exists($path)) return false;

        $opportunitiesData = json_decode(file_get_contents($path), true);
        $opportunitiesData[] = [
            "id" => $opportunity->getId(),
            "type" => $opportunity->getType(),
            "title" => $opportunity->getTitle(),
            "description" => $opportunity->getDescription(),
            "deadline" => $opportunity->getDeadline(),
            "link" => $opportunity->getLink()
        ];

        return file_put_contents($path, json_encode($opportunitiesData, JSON_PRETTY_PRINT)) !== false;
    }
}
