<?php
namespace Unifind\Models;
/**
 * Represents an Opportunity entity such as scholarship, internship, apprenticeship
 */
class Opportunity {
    private $Id;
    private $Type;
    private $Title;
    private $Description;
    private $Deadline;
    private $Link;

    function __construct($Id, $Type, $Title, $Description, $Deadline, $Link){
        $this->Id = $Id;
        $this->Type = $Type;
        $this->Title = $Title;
        $this->Description = $Description;
        $this->Deadline = $Deadline;
        $this->Link = $Link;
    }

    // Getters
    public function getId() { return $this->Id; }
    public function getType() { return $this->Type; }
    public function getTitle() { return $this->Title; }
    public function getDescription() { return $this->Description; }
    public function getDeadline() { return $this->Deadline; }
    public function getLink() { return $this->Link; }

    // Setters
    public function setId($Id) { $this->Id = $Id; }
    public function setType($Type) { $this->Type = $Type; }
    public function setTitle($Title) { $this->Title = $Title; }
    public function setDescription($Description) { $this->Description = $Description; }
    public function setDeadline($Deadline) { $this->Deadline = $Deadline; }
    public function setLink($Link) { $this->Link = $Link; }
}
?>
