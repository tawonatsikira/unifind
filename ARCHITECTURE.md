# Unifind Architecture Documentation

## System Overview

Unifind is built on a client-server architecture with a PHP backend serving a responsive HTML/CSS/JavaScript frontend. The system uses file-based JSON storage instead of a traditional database, making it lightweight and easy to deploy.

## Technical Stack

### Frontend Technologies
- **HTML5**: Semantic markup structure
- **CSS3**: Modern styling with flexbox and grid layouts
- **JavaScript (ES6+)**: Interactive functionality and API calls
- **Google Fonts (Inter)**: Typography system
- **Responsive Design**: Mobile-first approach

### Backend Technologies
- **PHP 7.0+**: Server-side processing
- **JSON**: Data storage and serialization
- **Object-Oriented Programming**: Clean class structure

## Data Flow

### Search Process
1. User enters query in search form
2. Form submits to `search.php` via GET request
3. `search.php` loads data through `DBHandler.php`
4. `SearchAlgorithm.php` processes the query
5. Results are sorted and returned as HTML or JSON
6. Frontend displays results with interactive elements

### University View Process
1. User clicks on university link
2. `ViewUniversity.php` loads university data
3. Related programs and announcements are fetched
4. Page renders with tabs for different information sections
5. JavaScript handles tab switching and modal interactions

## Class Structure

### University Class
```php
class University {
    private $Name, $Id, $Website, $Portal, $Email;
    private $Contacts, $AltNames, $Addresses, $Description;
    
    // Getters and setters for all properties
    public function getName(), setId(), etc.
}
```

### Programme Class
```php
class Programme {
    private $Id, $Name, $Description, $Duration;
    private $faculty, $uniId, $requirements, $fields;
    
    // Getters and setters
    public function getId(), getName(), getFields(), etc.
}
```

### Supporting Classes
- **Announcement**: News and updates system
- **Subject**: Academic subject catalog
- **Requirements**: Admission criteria
- **Opportunity**: Educational opportunities
- **UsefulResource**: Helpful resources directory

## Search Algorithm Implementation

### SearchAlgorithm Class Methods

#### University Search
```php
public static function searchUniversities($query, $unis)
private static function searchUniversityByName($uni, $query)
private static function searchUniversityByAltNames($uni, $query)
```

#### Program Search
```php
public static function searchPrograms($query, $programs)
private static function searchProgramByName($program, $query)
private static function searchProgramByFields($program, $query)
private static function searchProgramByDescription($program, $query)
```

#### Utility Methods
```php
public static function sortResults($results) // Sorts by score descending
```

### Scoring Mechanism

**University Scoring:**
- Name similarity: 60-100% (using similar_text())
- Alternative name exact match: 100%
- Substring match: 60%

**Program Scoring:**
- Name similarity: 60-100%
- Field similarity: 90-100%
- Description keyword: 50%

## Data Storage Structure

### File Organization
```
data/
├── unis.json              # Primary university database
├── programs2.json         # Complete program catalog
├── Subjects.json         # Academic subjects
├── requirements.json     # Admission requirements
├── opportunities.json    # Educational opportunities
└── useful_resources.json # Helpful resources

extras/
├── {university_id}/      # University-specific assets
│   ├── announcements.json # University announcements
│   ├── campus.{png|jpg}  # Campus images
│   └── logo.{png|jpg}    # University logos
└── help/                 # Documentation assets
```

### JSON Schema Examples

**University Schema:**
```json
{
  "University Name": {
    "Name": "String",
    "Id": "Integer",
    "Website": "URL",
    "Portal": "URL",
    "Email": "Email",
    "Contacts": {"Key": "Value"},
    "Addresses": {"Location": "Address"},
    "AltNames": ["String"],
    "Description": "String"
  }
}
```

**Program Schema:**
```json
{
  "Program Name": {
    "id": "Integer",
    "Name": "String",
    "Description": "String",
    "Duration": "String",
    "Faculty": "String",
    "University": "Integer",
    "Requirements": "String",
    "Fields": ["String"]
  }
}
```

## API Endpoints

### Primary Endpoints
- `GET /search.php?q=query` - Search functionality
- `GET /ViewUniversity.php?id=123` - University profile
- `GET /UniList.php` - All universities list
- `GET /getProgramDetails.php?id=456` - Program details API

### Response Modes
- **HTML Mode**: Full page rendering with styling
- **JSON Mode**: API responses for programmatic access

## Security Considerations

- Input sanitization using `htmlspecialchars()`
- File existence checks before operations
- JSON data validation
- No SQL injection risk (file-based storage)

## Performance Optimizations

- Object caching through PHP object instances
- Efficient scoring algorithms
- Lazy loading of program details
- Responsive image handling

## Extension Points

### Adding New Universities
1. Add entry to `unis.json`
2. Create directory in `extras/{id}/`
3. Add logo and campus images
4. Create announcements.json if needed

### Adding New Programs
1. Add entry to `programs2.json`
2. Ensure university ID matches existing university

### Customizing Search
- Modify scoring thresholds in `SearchAlgorithm.php`
- Add new search methods as needed
- Adjust result sorting criteria

## Deployment Considerations

### Server Requirements
- PHP 7.0 or higher
- Write permissions for data directories
- Web server with PHP support

### File Permissions
- Read access for all JSON files
- Write access for announcement/resource addition features
- Execute permissions for PHP files

### Scaling Considerations
- Current implementation suitable for small-medium datasets
- For larger datasets, consider database migration
- Caching mechanisms for improved performance
