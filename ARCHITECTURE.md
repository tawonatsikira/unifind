# Unifind Architecture Documentation

## System Overview

Unifind follows a modern, service-oriented PHP architecture. It is designed to be lightweight, using organized file-based JSON storage while maintaining a professional Object-Oriented structure with PSR-4 compatible namespacing and automated class loading.

## Directory Structure

```text
unifind/
├── bootstrap.php           # System initialization and autoloader setup
├── data/                   # Organized JSON data storage
│   ├── announcements/      # University-specific announcements ({id}.json)
│   ├── programs/           # Partial/extra program data
│   ├── universities.json   # Core university database
│   ├── programs.json       # Core program database
│   ├── subjects.json       # Subject definitions
│   ├── requirements.json   # Admission requirements
│   ├── opportunities.json  # Scholarships and internships
│   └── resources.json      # Educational resources
├── public/                 # Publicly accessible assets
│   └── assets/
│       ├── logos/          # University logos ({id}.png/jpg)
│       ├── campus/         # Campus background images ({id}.png/jpg)
│       └── help/           # Documentation screenshots
├── src/                    # Core source code (Namespaced: Unifind\)
│   ├── Core/               # Fundamental system components (Autoloader)
│   ├── Models/             # Data entities (University, Programme, etc.)
│   └── Services/           # Business logic (DataService, SearchService)
├── style.css               # Modern, premium design system
├── script.js               # Modular frontend logic (tabs, modals, scroll-sync)
└── [root].php              # View controllers (search.php, ViewUniversity.php, etc.)
```

## Technical Stack

- **Backend**: PHP 8.1+ (Object-Oriented, Namespaced)
- **Frontend**: Vanilla HTML5, CSS3 (Design System), and Modern JavaScript (ES6+)
- **Data Storage**: Organized JSON (Centralized via `DataService`)
- **Autoloading**: Custom PSR-4 implementation in `src/Core/Autoloader.php`

## Core Components

### 1. Model Layer (`src/Models/`)
All data entities are represented as classes with private properties and public getters/setters.
- `University`, `Programme`, `Announcement`, `Opportunity`, `UsefulResource`.

### 2. Service Layer (`src/Services/`)
- **`DataService`**: Centralized data access. Includes robust JSON parsing with error handling, logging, and defensive checks for missing keys.
- **`SearchService`**: Intelligent search logic with similarity scoring and multi-tiered result ranking.

### 3. Frontend Design System
The application uses a premium design system defined in `style.css`:
- **CSS Variables**: Centralized color palette, shadows, and spacing.
- **Responsive Grid**: Mobile-first layouts for search results and university profiles.
- **Micro-animations**: Smooth transitions for tabs, modals, and hover states.
- **Glassmorphism**: Subtle blur effects on modals and headers.

## Security & Stability

- **XSS Protection**: All content is escaped using `htmlspecialchars()` in PHP and a DOM-based escaping helper in JavaScript.
- **Error Handling**: `DataService` catches JSON errors and logs them to the server error log, preventing application crashes on corrupted data.
- **Defensive Coding**: Models and Services use null-coalescing operators to handle incomplete data gracefully.

## Future Considerations

- **Database Migration**: The `DataService` abstraction makes it easy to swap JSON for a relational database (SQLite/MySQL).
- **REST API**: The existing services can be easily wrapped in new controllers to provide a public JSON API.
