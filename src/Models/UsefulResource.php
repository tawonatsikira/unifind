<?php
namespace Unifind\Models;
/**
 * Represents a Useful Resource entity such as links to platforms, articles, and materials
 */
class UsefulResource {
    private $Id;
    private $Title;
    private $Description;
    private $Link;

    function __construct($Id, $Title, $Description, $Link){
        $this->Id = $Id;
        $this->Title = $Title;
        $this->Description = $Description;
        $this->Link = $Link;
    }

    // Getters
    public function getId() { return $this->Id; }
    public function getTitle() { return $this->Title; }
    public function getDescription() { return $this->Description; }
    public function getLink() { return $this->Link; }

    // Setters
    public function setId($Id) { $this->Id = $Id; }
    public function setTitle($Title) { $this->Title = $Title; }
    public function setDescription($Description) { $this->Description = $Description; }
    public function setLink($Link) { $this->Link = $Link; }
}
?>
