<?php
namespace Unifind\Models;
class Announcement {
    private $Id;
    private $Date;
    private $Heading;
    private $Body;

    function __construct($Id, $Date, $Heading, $Body){
        $this->Id = $Id;
        $this->Date = $Date;
        $this->Heading = $Heading;
        $this->Body = $Body;
    }

    //Getters for getting stuff like duh
    public function getId() { return $this->Id; }
    public function getDate() { return $this->Date; }
    public function getHeading() { return $this->Heading; }
    public function getBody() { return $this->Body; }

    //Setters to set stuff bruuuuuuuuuh
    public function setId($Id) { $this->Id = $Id; }
    public function setWebsite($Website) { $this->Website = $Website; }
    public function setPortal($Portal) { $this->Portal = $Portal; }
    public function setEmail($Email) { $this->Email = $Email; }
}
?>
