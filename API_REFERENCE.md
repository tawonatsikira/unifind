
# Unifind API Reference

## Overview

Unifind provides a RESTful API for searching universities and programs. The API returns JSON responses and supports both programmatic access and human-readable HTML output.

## Base URL

All API endpoints are relative to the application root. For example:
- Local development: `http://localhost:8000/`
- Production: `https://yourdomain.com/`

## Authentication

No authentication is required for read operations. The API is publicly accessible.

## Response Formats

### HTML Response
Default format for browser requests, returns fully rendered HTML pages.

### JSON Response
For programmatic access, append `&mode=test` to any endpoint or set `Accept: application/json` header.

## Search API

### Search Endpoint
```
GET /search.php
```

Searches for universities and programs matching the query.

#### Parameters
| Parameter | Required | Type | Description | Example |
|-----------|----------|------|-------------|---------|
| q | Yes | string | Search query | `computer science` |
| mode | No | string | Response mode: `search` (HTML) or `test` (JSON) | `test` |

#### Example Request
```bash
# HTML response
curl "http://localhost:8000/search.php?q=computer%20science"

# JSON response  
curl "http://localhost:8000/search.php?q=computer%20science&mode=test"
```

#### Response Format (JSON)
```json
[
  {
    "type": "program",
    "name": "Computer Science",
    "id": 101,
    "university_id": 1,
    "score": 95,
    "match_type": "name",
    "matched_field": "Computer Science"
  },
  {
    "type": "university", 
    "name": "University of Zimbabwe",
    "id": 1,
    "score": 85,
    "match_type": "name"
  }
]
```

#### Response Fields
- **type**: `university`, `program`, or `none`
- **name**: Name of the matched item
- **id**: Unique identifier
- **score**: Match quality score (0-100)
- **match_type**: Type of match (`name`, `altname`, `field`, `keyword`)
- **university_id**: Only for programs, references university ID
- **matched_field**: For field matches, the matched field name

#### Error Response
```json
{
  "type": "none",
  "message": "No matching university or program found"
}
```

## University API

### University List Endpoint
```
GET /UniList.php
```

Returns a list of all universities.

#### Parameters
None

#### Example Request
```bash
curl "http://localhost:8000/UniList.php"
```

#### Response Format (HTML)
Returns HTML page with university listings.

### University Detail Endpoint
```
GET /ViewUniversity.php
```

Returns detailed information about a specific university.

#### Parameters
| Parameter | Required | Type | Description | Example |
|-----------|----------|------|-------------|---------|
| id | Yes | integer | University ID | `1` |

#### Example Request
```bash
curl "http://localhost:8000/ViewUniversity.php?id=1"
```

#### Response Format (HTML)
Returns HTML page with university details, programs, and announcements.

## Program API

### Program Detail Endpoint
```
GET /getProgramDetails.php
```

Returns detailed information about a specific program.

#### Parameters
| Parameter | Required | Type | Description | Example |
|-----------|----------|------|-------------|---------|
| id | Yes | integer | Program ID | `101` |

#### Example Request
```bash
curl "http://localhost:8000/getProgramDetails.php?id=101"
```

#### Response Format (JSON)
```json
{
  "id": 101,
  "Name": "Computer Science",
  "Description": "A comprehensive program covering computer science fundamentals...",
  "Duration": "4 years",
  "Faculty": "Faculty of Science",
  "University": 1,
  "Requirements": "A-Level Mathematics and any Science subject",
  "Fields": ["Programming", "Algorithms", "Data Structures", "Software Engineering"]
}
```

## Resource APIs

### Opportunities Endpoint
```
GET /Opportunities.php
```

Returns educational opportunities.

#### Parameters
None

#### Response Format (HTML)
HTML page with opportunities listing.

### Useful Resources Endpoint
```
GET /UsefulResources.php
```

Returns useful educational resources.

#### Parameters  
None

#### Response Format (HTML)
HTML page with resources listing.

## Search Algorithm Details

### Scoring System

#### University Scoring
- **Name Similarity**: 60-100% (using `similar_text()`)
- **Alternative Name Exact Match**: 100%
- **Substring Match**: 60%

#### Program Scoring
- **Name Similarity**: 60-100%
- **Field Similarity**: 90-100% 
- **Description Keyword**: 50%

### Match Types

| Type | Description | Score Range |
|------|-------------|-------------|
| name | Primary name match | 60-100 |
| altname | Alternative name exact match | 100 |
| field | Program field/specialization match | 90-100 |
| keyword | Description keyword match | 50 |

### Result Processing
- Results merged from university and program searches
- Sorted by score descending
- Each program appears only once with best match
- Duplicate prevention by ID tracking

## Usage Examples

### Basic Search
```javascript
// JavaScript example
async function searchUnifind(query) {
  const response = await fetch(`/search.php?q=${encodeURIComponent(query)}&mode=test`);
  const results = await response.json();
  
  if (results.type === 'none') {
    console.log('No results found');
    return;
  }
  
  results.forEach(result => {
    console.log(`${result.name} (Score: ${result.score})`);
  });
}
```

### Get Program Details
```javascript
async function getProgramDetails(programId) {
  const response = await fetch(`/getProgramDetails.php?id=${programId}`);
  const program = await response.json();
  console.log(program);
}
```

### University Information
```javascript
async function getUniversityInfo(universityId) {
  // Note: This returns HTML, not JSON
  const response = await fetch(`/ViewUniversity.php?id=${universityId}`);
  const html = await response.text();
  // Parse HTML or use for display
}
```

## Error Handling

### HTTP Status Codes
- **200**: Success
- **400**: Bad request (missing parameters)
- **404**: Not found (invalid ID)
- **500**: Server error

### Error Responses
All error responses include a JSON object with error details:
```json
{
  "error": "Error message",
  "code": 400
}
```

## Rate Limiting

No rate limiting is currently implemented. For production use, consider implementing:
- Request throttling
- API key authentication
- Usage quotas

## CORS Support

Cross-Origin Resource Sharing is enabled for all endpoints:
```php
header('Access-Control-Allow-Origin: *');
```

## Data Freshness

- Data is loaded from JSON files on each request
- No caching implemented by default
- For high traffic, implement caching mechanism

## Versioning

No versioning system currently implemented. All endpoints are at v1.

## Deprecation Policy

No deprecated endpoints currently. Changes will be communicated through:
- API documentation updates
- Versioned endpoints for breaking changes

## Best Practices

### Client-Side Usage
```javascript
// Always encode query parameters
const query = encodeURIComponent(searchTerm);
const url = `/search.php?q=${query}&mode=test`;

// Handle errors properly
try {
  const response = await fetch(url);
  if (!response.ok) {
    throw new Error(`HTTP error: ${response.status}`);
  }
  const data = await response.json();
  // Process data
} catch (error) {
  console.error('API request failed:', error);
}
```

### Server-Side Usage
```php
// PHP example using cURL
$query = urlencode('computer science');
$url = "http://unifind.example.com/search.php?q={$query}&mode=test";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

$response = curl_exec($ch);
$data = json_decode($response, true);

if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    print_r($data);
}

curl_close($ch);
```

## Limitations

- No pagination support for large result sets
- No filtering or sorting parameters
- No bulk operations
- File-based storage may have performance limits with large datasets

## Future Enhancements

Planned API improvements:
- Pagination support
- Advanced filtering
- Bulk operations
- Real-time updates via WebSocket
- Authentication system
- Rate limiting
- API versioning
- Comprehensive error codes
- Response compression
- Request logging
- Analytics endpoints

This API reference provides comprehensive documentation for integrating with the Unifind system. For additional questions or support, refer to the main documentation or contact the development team.
