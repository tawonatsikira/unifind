# Unifind - University and Program Search System

## Overview

Unifind is a comprehensive web application designed to help students search and discover universities and academic programs in Zimbabwe. The system provides a user-friendly interface for exploring university information, program details, announcements, and educational resources.

## Features

- **Search Functionality**: Advanced search algorithm for universities and programs
- **University Profiles**: Detailed university information with contact details, addresses, and descriptions
- **Program Catalog**: Comprehensive program listings with fields, durations, and requirements
- **Announcements System**: University-specific announcements and updates
- **Resource Directory**: Useful educational resources and opportunities
- **Responsive Design**: Mobile-friendly interface with smooth navigation

## System Architecture

### Frontend
- **HTML/CSS/JavaScript**: Clean, responsive web interface
- **Bootstrap-inspired Design**: Modern UI with smooth transitions
- **Modal System**: Interactive program detail modals
- **Side Navigation**: Collapsible menu for easy navigation

### Backend
- **PHP**: Server-side processing and data handling
- **JSON Data Storage**: File-based data persistence
- **Object-Oriented Design**: Clean class structure for data models
- **RESTful API**: Search API with JSON responses

### Data Models

#### University Class
- ID, Name, Description
- Contact Information (Website, Portal, Email, Phone)
- Addresses and Locations
- Alternative Names (abbreviations)
- Logo and Campus Images

#### Programme Class
- ID, Name, Description
- Duration, Faculty, University ID
- Admission Requirements
- Fields/Specializations

#### Additional Models
- Announcement: News and updates
- Subject: Academic subjects
- Requirements: Admission criteria
- Opportunity: Educational opportunities
- UsefulResource: Helpful resources

## File Structure

```
unifind/
├── index.html              # Main landing page
├── search.php             # Search functionality
├── SearchAlgorithm.php    # Search algorithm implementation
├── DBHandler.php          # Database/data handler
├── ViewUniversity.php     # University profile view
├── UniList.php           # All universities listing
├── ProgramOptions.php     # Program options page
├── UsefulResources.php    # Resources directory
├── Opportunities.php      # Opportunities listing
├── Us.php                # About us page
├── help.php              # Help documentation
├── getProgramDetails.php  # Program detail API
├── script.js             # Frontend JavaScript
├── style.css             # Global styles
├── SEARCH_API_DOCS.md    # API documentation
│
├── classes/              # PHP class definitions
│   ├── University.php
│   ├── Programme.php
│   ├── Announcement.php
│   ├── Subject.php
│   ├── Requirements.php
│   ├── Opportunity.php
│   └── UsefulResource.php
│
├── extras/               # University-specific assets
│   ├── 1/               # University 1 (UZ)
│   │   ├── announcements.json
│   │   ├── campus.png
│   │   └── logo.jpg
│   ├── 2/               # University 2 (NUST)
│   │   └── ...
│   └── help/            # Help screenshots
│
├── programs/             # Program data files
│   ├── programs2_filled_fields_*.json
│   └── WUA.json
│
├── test/                 # Test data and files
│   └── ...
│
└── Data Files:
    ├── unis.json                # University database
    ├── programs2.json           # Program database
    ├── Subjects.json           # Subject catalog
    ├── requirements.json       # Admission requirements
    ├── requirements2.json      # Additional requirements
    ├── opportunities.json      # Educational opportunities
    └── useful_resources.json   # Helpful resources
```

## Search Algorithm

### Search Types
1. **University Search**
   - Name similarity matching (>60% score)
   - Alternative name exact matching (100% score)
   - Substring matching (60% score)

2. **Program Search**
   - Name similarity matching (>60% score)
   - Field/specialization matching (>90% score)
   - Description keyword matching (50% score)

### Scoring System
- **100**: Perfect match (alternative names)
- **90-99**: High similarity (fields/specializations)
- **60-89**: Good match (primary names)
- **50**: Keyword match (descriptions)

### Result Processing
- Results are merged and sorted by score (highest first)
- Each program appears only once with its best match
- Duplicate prevention by ID tracking

## API Documentation

### Search Endpoint
```
GET /search.php?q={query}&mode={search|test}
```

**Parameters:**
- `q`: Search query (required)
- `mode`: Response mode (optional, default: search)

**Response Formats:**
- `search`: HTML page with results
- `test`: JSON response for API testing

### JSON Response Structure
```json
[
  {
    "type": "university|program|none",
    "name": "Result Name",
    "id": "Unique ID",
    "score": "Match Score",
    "match_type": "Match Type",
    // Additional fields based on type
  }
]
```

## Data Management

### University Data (unis.json)
```json
{
  "University Name": {
    "Name": "Full Name",
    "Id": 1,
    "Website": "https://example.com",
    "Portal": "https://portal.example.com",
    "Email": "admissions@example.com",
    "Contacts": {"Phone": "+1234567890"},
    "Addresses": {"Main": "123 Main St"},
    "AltNames": ["Abbreviation"],
    "Description": "University description"
  }
}
```

### Program Data (programs2.json)
```json
{
  "Program Name": {
    "id": 1,
    "Name": "Program Name",
    "Description": "Program description",
    "Duration": "4 years",
    "Faculty": "Faculty Name",
    "University": 1,
    "Requirements": "Admission requirements",
    "Fields": ["Field1", "Field2"]
  }
}
```

## Setup and Installation

### Requirements
- PHP 7.0 or higher
- Web server (Apache, Nginx, or built-in PHP server)
- Modern web browser

### Quick Start
1. Clone or extract the project files to your web server directory
2. Ensure PHP is properly configured
3. Access the application through your web browser
4. The system uses file-based storage, no database setup required

### Development Server
```bash
# Start PHP development server
php -S localhost:8000

# Access application at http://localhost:8000
```

## Usage

### Searching
1. Enter search
