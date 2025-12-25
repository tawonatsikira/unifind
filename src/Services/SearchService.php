<?php

namespace Unifind\Services;

class SearchService {
    public static function searchUniversities($query, $unis) {
        $results = [];
        $query = strtolower(trim($query));
        $foundUnis = [];
        
        foreach ($unis as $uni) {
            $uniId = $uni->getId();
            
            if (isset($foundUnis[$uniId])) continue;
            
            $nameMatches = self::searchUniversityByName($uni, $query);
            $altMatches = self::searchUniversityByAltNames($uni, $query);
            
            $allMatches = array_merge($nameMatches, $altMatches);
            if (!empty($allMatches)) {
                $results[] = $allMatches[0];
                $foundUnis[$uniId] = true;
            }
        }
        
        return $results;
    }

    private static function searchUniversityByName($uni, $query) {
        $results = [];
        $uniName = strtolower($uni->getName());
        $score = 0;

        similar_text($uniName, $query, $score);
        if ($score > 60) {
            $results[] = [
                'type' => 'university',
                'name' => $uni->getName(),
                'id' => $uni->getId(),
                'score' => $score,
                'match_type' => 'similarity'
            ];
        }
        
        if (strpos($uniName, $query) !== false) {
            $results[] = [
                'type' => 'university',
                'name' => $uni->getName(),
                'id' => $uni->getId(),
                'score' => 60,
                'match_type' => 'substring'
            ];
            return $results;
        }
        
        return $results;
    }

    private static function searchUniversityByAltNames($uni, $query) {
        $results = [];
        foreach ($uni->getAltNames() as $altName) {
            if (strtolower($altName) === $query) {
                $results[] = [
                    'type' => 'university',
                    'name' => $uni->getName(),
                    'id' => $uni->getId(),
                    'score' => 100,
                    'matched_altname' => $altName
                ];
            }
        }
        return $results;
    }
    
    public static function searchPrograms($query, $programs) {
        $results = [];
        $query = strtolower(trim($query));
        $foundPrograms = [];
        
        foreach ($programs as $program) {
            $programId = $program->getId();
            
            if (isset($foundPrograms[$programId])) continue;
            
            $nameMatches = self::searchProgramByName($program, $query);
            $fieldMatches = self::searchProgramByFields($program, $query);
            $descMatches = self::searchProgramByDescription($program, $query);
            
            $allMatches = array_merge($nameMatches, $fieldMatches, $descMatches);
            if (!empty($allMatches)) {
                $results[] = $allMatches[0];
                $foundPrograms[$programId] = true;
            }
        }
        
        return $results;
    }

    private static function searchProgramByName($program, $query) {
        $results = [];
        $programName = strtolower($program->getName());
        $score = 0;
        
        similar_text($programName, $query, $score);
        if ($score > 60) {
            $results[] = [
                'type' => 'program',
                'name' => $program->getName(),
                'id' => $program->getId(),
                'university_id' => $program->getUniId(),
                'score' => $score
            ];
        } elseif (strpos($programName, $query) !== false){
            $results[] = [
                'type' => 'program',
                'name' => $program->getName(),
                'id' => $program->getId(),
                'university_id' => $program->getUniId(),
                'score' => 53
            ];
        }
        return $results;
    }

    private static function searchProgramByFields($program, $query) {
        $results = [];
        foreach ($program->getFields() as $field) {
            $score = 0;
            similar_text(strtolower($field), $query, $score);
            if ($score > 90 || strpos(strtolower($field), $query) !== false) {
                $results[] = [
                    'type' => 'program',
                    'name' => $program->getName(),
                    'id' => $program->getId(),
                    'university_id' => $program->getUniId(),
                    'score' => $score > 90 ? $score : 85,
                    'matched_field' => $field
                ];
            }
        }
        return $results;
    }

    private static function searchProgramByDescription($program, $query) {
        $results = [];
        if (strpos(strtolower($program->getDescription()), $query) !== false) {
            $results[] = [
                'type' => 'program',
                'name' => $program->getName(),
                'id' => $program->getId(),
                'university_id' => $program->getUniId(),
                'score' => 50,
                'matched_keyword' => $query
            ];
        }
        return $results;
    }
    
    public static function sortResults($results) {
        usort($results, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        return $results;
    }
}
