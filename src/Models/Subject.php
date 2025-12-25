<?php
namespace Unifind\Models;
class Subject {
    public $id;
    public $name;
    public $class;
    
    function __construct($id, $name, $class) {
        $this->id = (int)$id;
        $this->name = (string)$name;
        $this->class = (string)$class;
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getClass() { return $this->class; }

    public function setId($id) { $this->id = (int)$id; }
    public function setName($name) { $this->name = (string)$name; }
    public function setClass($class) { $this->class = (string)$class; }
}
?>
