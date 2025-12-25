# Search API Documentation

## Overview
The search API provides functionality to search through universities and academic programs. It returns ranked results based on match quality, with detailed information about each match.

## API Endpoint
```
GET /search.php?q={query}
```

## Request Parameters
| Parameter | Required | Description |
|-----------|----------|-------------|
| q         | Yes      | Search query string |

## Response Format
The API returns JSON with the following structure:

### Successful Response
```json
[
    {
        "type": "university" | "program" | "none",
        "name": "string",
        "id": "number",
        "score": "number",
        "match_type": "string",
        // Additional fields depending on match type
        ...
    }
]
```

### No Results Response
```json
{
    "type": "none",
    "message": "No matching university or program found"
}
```

## Search Functions

### `searchQuery(query)`
Main entry point that orchestrates the search process.

**Parameters:**
- `query`: Search term string

**Flow:**
1. Calls `searchUniversities()` and `searchPrograms()`
2. Merges and sorts results
3. Returns formatted response

### `searchUniversities(query, unis)`
Searches through university data.

**Parameters:**
- `query`: Normalized search term
- `unis`: Array of University objects

**Returns:** Array of university match results

### `searchUniversityByName(uni, query)`
Searches university by primary name using similarity scoring.

**Scoring:**
- Similarity score > 60 = match
- Returns score between 60-100

### `searchUniversityByAltNames(uni, query)`
Searches university by alternative names.

**Scoring:**
- Exact match only
- Returns score of 100

### `searchPrograms(query, programs)`
Searches through program data while preventing duplicates.

**Parameters:**
- `query`: Normalized search term
- `programs`: Array of Program objects

**Behavior:**
- Tracks already found programs by ID
- Combines matches from name, fields and description
- Returns only the highest scoring match per program
- Prevents duplicate entries of same program

**Returns:** Array of unique program matches (best match per program)

### `searchProgramByName(program, query)`
Searches program by name using similarity scoring.

**Scoring:**
- Similarity score > 60 = match
- Returns score between 60-100

### `searchProgramByFields(program, query)`
Searches program by field/specialization names.

**Scoring:**
- Similarity score > 90 = match
- Returns score between 90-100

### `searchProgramByDescription(program, query)`
Searches program by description keywords.

**Scoring:**
- Partial word match
- Returns score of 50

### `sortResults(results)`
Sorts results by score (highest first).

## Example Requests

### Basic Search
```bash
curl "http://example.com/search.php?q=computer%20science"
```

### Expected Response
```json
[
    {
        "type": "program",
        "name": "Computer Science",
        "id": 42,
        "university_id": 5,
        "score": 95,
        "match_type": "name"
    },
    {
        "type": "university",
        "name": "Tech University",
        "id": 5,
        "score": 85,
        "match_type": "name"
    }
]
```

### Exact University Match
```bash
curl "http://example.com/search.php?q=MIT"
```

### Expected Response
```json
[
    {
        "type": "university",
        "name": "Massachusetts Institute of Technology",
        "id": 1,
        "score": 100,
        "match_type": "altname",
        "matched_altname": "MIT"
    }
]
```

### No Results
```bash
curl "http://example.com/search.php?q=unknownquery"
```

### Expected Response
```json
{
    "type": "none",
    "message": "No matching university or program found"
}
```

## Match Types

| Type | Description | Score Range |
|------|-------------|-------------|
| name | Primary name match | 60-100 |
| altname | Alternative name exact match | 100 |
| field | Program field/specialization match | 70-100 |
| keyword | Description keyword match | 50 |

**Note:** Each program appears only once in results with its highest scoring match type.

## Implementation Notes
- All searches are case-insensitive
- Scores represent match quality (100 = perfect match)
- Results are always sorted by score (highest first)
- Single exact matches return just that result
- Each program appears only once with its best match
