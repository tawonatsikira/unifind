# Unifind Developer Guide

## Getting Started

### Prerequisites
- PHP 7.0 or higher
- Web server (Apache/Nginx) or PHP built-in server
- Basic understanding of PHP, HTML, CSS, and JavaScript

### Project Setup
1. Clone or download the project files
2. Place in your web server directory
3. Ensure file permissions allow PHP execution and data file reading
4. Access via web browser

### Development Server
```bash
# Start PHP development server
php -S localhost:8000

# Access application at http://localhost:8000
```

## Code Structure Overview

### Core Files
- `index.html` - Main landing page with search form
- `search.php` - Search functionality and results display
- `DBHandler.php` - Data loading and management
- `SearchAlgorithm.php` - Search logic implementation

### Class Files (`classes/` directory)
- `University.php` - University data model
- `Programme.php` - Program data model
- `Announcement.php` - Announcement system
- `Subject.php` - Subject catalog
- `Requirements.php` - Admission requirements
- `Opportunity.php` - Educational opportunities
- `UsefulResource.php` - Resource directory

### View Files
- `ViewUniversity.php` - University profile page
- `UniList.php` - All universities listing
- `ProgramOptions.php` - Program options interface
- `UsefulResources.php` - Resources directory
- `Opportunities.php` - Opportunities listing

## Data Management

### Adding New Universities

#### Step 1: Update unis.json
```json
"New University Name": {
  "Name": "New University Name",
  "Id": 12,
  "Website": "https://newuni.ac.zw",
  "Portal": "https://portal.newuni.ac.zw",
  "Email": "admissions@newuni.ac.zw",
  "Contacts": {
    "Main Switchboard": "+263123456789"
  },
  "Addresses": {
    "Main Campus": "123 University Road, City"
  },
  "AltNames": ["NU"],
  "Description": "Description of the new university"
}
```

#### Step 2: Create Assets Directory
```bash
mkdir extras/12
```

#### Step 3: Add Logo and Images
- Place `logo.png` or `logo.jpg` in `extras/12/`
- Place `campus.png` or `campus.jpg` in `extras/12/`

#### Step 4: Create Announcements (Optional)
Create `extras/12/announcements.json`:
```json
[
  {
    "id": 1,
    "date": "2024-01-15",
    "heading": "Welcome Message",
    "body": "Welcome to our new university!"
  }
]
```

### Adding New Programs

#### Update programs2.json
```json
"New Program Name": {
  "id": 1001,
  "Name": "New Program Name",
  "Description": "Program description here",
  "Duration": "4 years",
  "Faculty": "Faculty of Science",
  "University": 12,
  "Requirements": "A-Level passes in relevant subjects",
  "Fields": ["Field1", "Field2", "Field3"]
}
```

## Customizing Search Algorithm

### Modifying Scoring Thresholds

Edit `SearchAlgorithm.php`:

```php
// Change university name similarity threshold
if ($score > 70) { // Changed from 60 to 70
    // ...
}

// Change program field similarity threshold  
if ($score > 85) { // Changed from 90 to 85
    // ...
}
```

### Adding New Search Methods

```php
private static function searchUniversityByDescription($uni, $query) {
    $results = [];
    $description = strtolower($uni->getDescription());
    
    if (strpos($description, $query) !== false) {
        $results[] = [
            'type' => 'university',
            'name' => $uni->getName(),
            'id' => $uni->getId(),
            'score' => 55,
            'match_type' => 'description'
        ];
    }
    
    return $results;
}
```

Then add to `searchUniversities()` method:
```php
$descMatches = self::searchUniversityByDescription($uni, $query);
$allMatches = array_merge($nameMatches, $altMatches, $descMatches);
```

## Styling and Theming

### CSS Structure
- `style.css` - Global styles and navigation
- Inline styles in PHP files - Page-specific styling
- Google Fonts (Inter) - Typography system

### Adding Custom Styles

#### Global Styles (style.css)
```css
/* Add to style.css */
.custom-element {
    background: #f0f0f0;
    padding: 1rem;
    border-radius: 8px;
}
```

#### Page-specific Styles
Add within `<style>` tags in PHP files:
```php
<style>
.page-specific {
    color: #007bff;
    font-weight: 600;
}
</style>
```

## API Development

### Extending API Endpoints

#### Create New Endpoint
Create `api/new-endpoint.php`:
```php
<?php
header('Content-Type: application/json');
require_once 'DBHandler.php';

// Handle request parameters
$param = $_GET['param'] ?? null;

if ($param) {
    // Process request
    $data = ['result' => 'success', 'data' => $param];
    echo json_encode($data);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Parameter required']);
}
?>
```

### API Response Formatting

Always include proper headers:
```php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // For cross-domain requests
```

## Testing and Debugging

### Debug Mode
Add debug output to PHP files:
```php
// Temporary debug output
error_log("Search query: " . $_GET['q']);
var_dump($results); // Remove before production
```

### Error Handling
```php
try {
    $data = json_decode(file_get_contents('file.json'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON parse error: ' . json_last_error_msg());
    }
} catch (Exception $e) {
    error_log("Data loading error: " . $e->getMessage());
    // Fallback or error response
}
```

## Performance Optimization

### Caching Strategies
```php
// Simple file-based caching
function getCachedData($key, $ttl = 3600) {
    $cacheFile = "cache/{$key}.cache";
    
    if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $ttl) {
        return json_decode(file_get_contents($cacheFile), true);
    }
    
    // Generate and cache data
    $data = generateExpensiveData();
    file_put_contents($cacheFile, json_encode($data));
    return $data;
}
```

### Data Loading Optimization
```php
// Load only necessary data
function getUniversityById($id) {
    $unis = getUnisList();
    return $unis[$id] ?? null;
}
```

## Security Best Practices

### Input Validation
```php
// Always sanitize user input
$query = htmlspecialchars($_GET['q'] ?? '');
$uniId = filter_var($_GET['id'] ?? 0, FILTER_VALIDATE_INT);
```

### File Operations Security
```php
// Validate file paths
$allowedPaths = ['extras/', 'data/'];
$requestedPath = $_GET['file'] ?? '';

if (!in_array(dirname($requestedPath), $allowedPaths)) {
    die('Invalid file path');
}
```

## Deployment Checklist

### Pre-deployment
- [ ] Test all search functionality
- [ ] Verify university and program data loading
- [ ] Check responsive design on multiple devices
- [ ] Validate JSON files for syntax errors
- [ ] Test API endpoints

### Server Configuration
- [ ] PHP version >= 7.0
- [ ] File permissions set correctly
- [ ] Error reporting disabled in production
- [ ] Proper MIME types configured

### Post-deployment
- [ ] Monitor error logs
- [ ] Test search performance
- [ ] Verify all images load correctly
- [ ] Check cross-browser compatibility

## Troubleshooting

### Common Issues

**JSON Parse Errors:**
```bash
# Check JSON syntax
php -l file.json
```

**File Permission Issues:**
```bash
# Set correct permissions
chmod 644 *.json
chmod 755 extras/
```

**PHP Errors:**
- Check `error_log` for details
- Enable error reporting in development:
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### Performance Issues
- Large JSON files may cause slow loading
- Consider splitting data into multiple files
- Implement caching for frequently accessed data

## Contributing Guidelines

### Code Style
- Use descriptive variable names
- Follow PHP PSR-12 coding standards
- Add comments for complex logic
- Include PHPDoc for functions and classes

### Testing
- Test new features thoroughly
- Verify backward compatibility
- Test edge cases and error conditions

### Documentation
- Update relevant documentation files
- Add comments for new functionality
- Include examples for new features
