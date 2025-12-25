<?php
namespace Unifind\Models;
/**
 * Represents a University entity with all related properties
 */
class University {
    /** @var string $Name The full name of the university */
    private $Name;
    
    /** @var int $Id The unique identifier for the university */
    private $Id;
    
    /** @var string $Website The official website URL */
    private $Website;
    
    /** @var string $Portal The student portal URL */
    private $Portal;
    
    /** @var string $Email The admissions email address */
    private $Email;
    
    /** @var array $Contacts Additional contact information */
    private $Contacts;
    
    /** @var string[] $AltNames Alternative names or abbreviations for the university */
    private $AltNames;

    /** @var string[] $Addresses Addresses for the university */
    private $Addresses;

    /** @var string $Description The history and description of the university */
    private $Description;

    function __construct($Name, $Id, $Website, $Portal, $Email, $Contacts, $AltNames, $Addresses, $Description) {
        $this->Name = $Name;
        $this->Id = $Id;
        $this->Website = $Website;
        $this->Portal = $Portal;
        $this->Email = $Email;
        $this->Contacts = $Contacts;
        $this->AltNames = $AltNames;
        $this->Addresses = $Addresses;
        $this->Description = $Description;
    }

    // Getters
    public function getName() { return $this->Name; }
    public function getId() { return $this->Id; }
    public function getWebsite() { return $this->Website; }
    public function getPortal() { return $this->Portal; }
    public function getEmail() { return $this->Email; }
    public function getContacts() { return $this->Contacts; }
    public function getAltNames() { return $this->AltNames; }
    public function getAddresses() { return $this->Addresses; }
    public function getDescription() { return $this->Description; }

    // Setters
    public function setName($Name) { $this->Name = $Name; }
    public function setId($Id) { $this->Id = $Id; }
    public function setWebsite($Website) { $this->Website = $Website; }
    public function setPortal($Portal) { $this->Portal = $Portal; }
    public function setEmail($Email) { $this->Email = $Email; }
    public function setContacts($Contacts) { $this->Contacts = $Contacts; }
    public function setAltNames($AltNames) { $this->AltNames = $AltNames; }
    public function setAddresses($Addresses) { $this->Addresses = $Addresses; }
    public function setDescription($Description) { $this->Description = $Description; }
}
?>
