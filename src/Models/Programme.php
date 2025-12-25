<?php
namespace Unifind\Models;
/**
 * Represents an academic Programme with all related properties
 */
class Programme {
    /** @var int $Id The unique identifier for the programme */
    private $Id;
    
    /** @var string $Name The full name of the programme */
    private $Name;
    
    /** @var string $Description A detailed description of the programme */
    private $Description;
    
    /** @var string $Duration The standard duration of the programme */
    private $Duration;
    
    /** @var string $faculty The faculty/department offering the programme */
    private $faculty;
    
    /** @var int $uniId The ID of the university offering this programme */
    private $uniId;
    
    /** @var string $requirements The admission requirements for the programme */
    private $requirements;
    
    /** @var string[] $fields The available fields/specializations within the programme */
    private $fields;
    
    function __construct($Id, $Name, $Description, $Duration, $faculty, $uniId, $requirements, $fields) {
        $this->Id = $Id;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Duration = $Duration;
        $this->faculty = $faculty;
        $this->uniId = $uniId;
        $this->requirements = $requirements;
        $this->fields = $fields;
    }

    // Getters
    public function getId() { return $this->Id; }
    public function getName() { return $this->Name; }
    public function getDescription() { return $this->Description; }
    public function getDuration() { return $this->Duration; }
    public function getFaculty() { return $this->faculty; }
    public function getUniId() { return $this->uniId; }
    public function getRequirements() { return $this->requirements; }
    public function getFields() { return $this->fields ?? []; }

    // Setters
    public function setId($Id) { $this->Id = $Id; }
    public function setName($Name) { $this->Name = $Name; }
    public function setDescription($Description) { $this->Description = $Description; }
    public function setDuration($Duration) { $this->Duration = $Duration; }
    public function setFaculty($faculty) { $this->faculty = $faculty; }
    public function setUniId($uniId) { $this->uniId = $uniId; }
    public function setRequirements($requirements) { $this->requirements = $requirements; }
    public function setFields($fields) { $this->fields = $fields; }
}
?>
