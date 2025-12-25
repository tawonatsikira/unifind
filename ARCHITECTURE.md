# Unifind Architecture Documentation

## System Overview

Unifind follows a modern, service-oriented PHP architecture. It is designed to be lightweight, using file-based JSON storage while maintaining a professional Object-Oriented structure with PSR-4 compatible namespacing and automated class loading.

## Directory Structure

```text
unifind/
├── bootstrap.php           # System initialization and autoloader setup
├── src/                    # Core source code
│   ├── Core/               # Fundamental system components
│   │   └── Autoloader.php  # PSR-4 compatible class loader
│   ├── Models/             # Data entities (University, Programme, etc.)
│   └── Services/           # Business logic (DataService, SearchService)
├── public/                 # Static assets (CSS, JS, Images)
├── extras/                 # University-specific assets (logos, announcements)
├── unis.json               # University database
├── programs2.json          # Program database
└── [root].php              # View controllers (search.php, ViewUniversity.php, etc.)
```

## Technical Stack

- **Backend**: PHP 8.1+ (Object-Oriented, Namespaced)
- **Frontend**: Vanilla HTML5, CSS3 (Inter font), and Modern JavaScript (ES6+)
- **Data Storage**: Flat-file JSON (Centralized via `DataService`)
- **Autoloading**: Custom PSR-4 implementation in `src/Core/Autoloader.php`

## Core Components

### 1. Model Layer (`src/Models/`)
All data entities are represented as classes with private properties and public getters/setters.
- `University`: Core university data and contact info.
- `Programme`: Academic program details and requirements.
- `Announcement`: University news updates.
- `Opportunity`: Scholarships and internships.

### 2. Service Layer (`src/Services/`)
- **`DataService`**: The single point of contact for all data operations. It handles reading/writing JSON files and converting them into Model objects.
- **`SearchService`**: Contains the intelligent search logic, including similarity scoring and result ranking.

### 3. Search Algorithm
The search engine uses a multi-tiered scoring system:
- **Exact Match (100)**: Matches against university abbreviations/alternative names.
- **Similarity Match (60-99)**: Uses `similar_text()` for fuzzy matching on names and fields.
- **Substring Match (60)**: Direct substring checks for partial name matches.
- **Keyword Match (50)**: Searches within program descriptions.

Results are merged, de-duplicated by ID, and sorted by score in descending order.

## Data Flow

1.  **Request**: User interacts with a root PHP file (e.g., `search.php`).
2.  **Bootstrap**: `bootstrap.php` is included, initializing the autoloader.
3.  **Service Call**: The view controller calls a Service method (e.g., `DataService::getUnisList()`).
4.  **Data Retrieval**: The Service reads the JSON file and returns an array of Model objects.
5.  **Logic**: If searching, `SearchService` processes the objects and returns ranked results.
6.  **Response**: The view controller renders the HTML using the data objects.

## Security & Stability

- **XSS Protection**: All user-generated and database content is escaped using `htmlspecialchars()` before rendering.
- **Defensive Programming**: Services include null-coalescing checks to handle incomplete or corrupted JSON data gracefully.
- **Namespacing**: The `Unifind\` namespace prevents naming collisions and ensures a clean codebase.

## Future Considerations

- **Database Migration**: The service-oriented design allows for an easy transition to SQLite or MySQL by simply updating the `DataService` class.
- **API Expansion**: The current structure easily supports adding RESTful JSON endpoints by creating new controllers that use the existing Services.
