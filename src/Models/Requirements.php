<?php
namespace Unifind\Models;
class Requirements{

    public $id;
    public $PName;
    public $Requirements;

    public function __construct($id, $programName, $requirements) {
        $this->id = $id;
        $this->PName = $programName;
        //requirements are kept in a an array named requirements
        //see requirements.json for format
        //this kinda defeats the purpose of a single database handler since shit will immediately shift the minute we use a different db

        $this->Requirements = $requirements;
    }

    public function getId() { return $this->id; }
    public function getPName() { return $this->PName; }
    public function getRequirements() { return $this->Requirements; }

    //Naming conventions are a 10/10 good luck mainitainting this code base after a leave of absence

    public function setId($id) { $this->id = $id; }
    public function setName($pname) { $this->PName = $pname; }
    public function setRequirements($requirements) { $this->Requirements = $requirements; }

}
?>
