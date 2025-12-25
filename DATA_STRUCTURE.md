# Unifind Data Structure Documentation

## Overview

This document details the complete data structure used by the Unifind system. The application uses JSON files for data storage with a well-defined schema for universities, programs, and related entities.

## University Data Structure

### File: `unis.json`

#### Schema
```json
{
  "University Name": {
    "Name": "string (required)",
    "Id": "integer (required, unique)",
    "Website": "string (URL)",
    "Portal": "string (URL)", 
    "Email": "string (email)",
    "Contacts": {
      "Key1": "string",
      "Key2": "string",
      ...
    },
    "Addresses": {
      "Location1": "string",
      "Location2": "string",
      ...
    },
    "AltNames": ["string", "string", ...],
    "Description": "string"
  }
}
```

#### Example Entry
```json
"University of Zimbabwe": {
  "Name": "University of Zimbabwe",
  "Description": "The University of Zimbabwe, established in 1952, is the oldest and largest university in Zimbabwe...",
  "Id": 1,
  "Website": "https://www.uz.ac.zw",
  "Portal": "https://emhare.uz.ac.zw",
  "Contacts": {
    "Main Switchboard": "+263242303211",
    "Alternative Switchboard": "+263242303240",
    "General Enquiries Email": "marketingcomms@admin.uz.ac.zw",
    "Admissions Phone": "+2634303211"
  },
  "Addresses": {
    "Main Campus": "Churchill Avenue, Harare, Zimbabwe",
    "Main Campus Postal": "P.O. Box MP167, Mount Pleasant, Harare, Zimbabwe"
  },
  "Email": "admissions@uz.ac.zw",
  "AltNames": ["UZ"]
}
```

#### Field Descriptions
- **Name**: Official full name of the university
- **Id**: Unique numeric identifier (1-11 for current universities)
- **Website**: Official university website URL
- **Portal**: Student portal/login URL
- **Email**: Admissions or general contact email
- **Contacts**: Key-value pairs of contact information
- **Addresses**: Physical and postal addresses
- **AltNames**: Array of abbreviations or alternative names
- **Description**: Detailed description of the university

## Program Data Structure

### File: `programs2.json`

#### Schema
```json
{
  "Program Name": {
    "id": "integer (required, unique)",
    "Name": "string (required)",
    "Description": "string",
    "Duration": "string",
    "Faculty": "string",
    "University": "integer (references university Id)",
    "Requirements": "string",
    "Fields": ["string", "string", ...]
  }
}
```

#### Example Entry
```json
"Computer Science": {
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

#### Field Descriptions
- **id**: Unique program identifier
- **Name**: Official program name
- **Description**: Detailed program description
- **Duration**: Program duration (e.g., "4 years")
- **Faculty**: Faculty or department offering the program
- **University**: ID of the offering university (references unis.json)
- **Requirements**: Admission requirements description
- **Fields**: Array of specializations or focus areas

## Announcement Data Structure

### File: `extras/{university_id}/announcements.json`

#### Schema
```json
[
  {
    "id": "integer",
    "date": "string (YYYY-MM-DD)",
    "heading": "string",
    "body": "string"
  }
]
```

#### Example Entry
```json
[
  {
    "id": 1,
    "date": "2024-01-15",
    "heading": "New Intake Announcement",
    "body": "The university is pleased to announce the opening of applications for the 2024 academic year."
  }
]
```

## Subject Data Structure

### File: `Subjects.json`

#### Schema
```json
{
  "Subject Name": {
    "Id": "integer",
    "Name": "string",
    "Class": "string"
  }
}
```

## Requirements Data Structure

### File: `requirements.json`

#### Schema
```json
{
  "id": {
    "Name": "string",
    "Requirements": "string"
  }
}
```

## Opportunity Data Structure

### File: `opportunities.json`

#### Schema
```json
[
  {
    "id": "integer",
    "type": "string",
    "title": "string",
    "description": "string",
    "deadline": "string",
    "link": "string (URL)"
  }
]
```

## Useful Resource Data Structure

### File: `useful_resources.json`

#### Schema
```json
[
  {
    "id": "integer",
    "title": "string",
    "description": "string",
    "link": "string (URL)"
  }
]
```

## File Organization Structure

### Main Data Files
```
├── unis.json              # Primary university database (11 universities)
├── programs2.json         # Complete program catalog (500+ programs)
├── Subjects.json         # Academic subject catalog
├── requirements.json     # Admission requirements
├── requirements2.json    # Additional requirements data
├── opportunities.json    # Educational opportunities
└── useful_resources.json # Helpful resources directory
```

### University-Specific Assets
```
extras/
├── 1/                    # University of Zimbabwe (ID: 1)
│   ├── announcements.json
│   ├── campus.png
│   └── logo.jpg
├── 2/                    # NUST (ID: 2)
│   ├── announcements.json
│   ├── campus.jpg
│   └── logo.png
├── 3/                    # CUT (ID: 3)
│   └── ...
├── ...
└── 11/                   # ZOU (ID: 11)
    └── ...
```

### Program Data Files
```
programs/
├── programs2_filled_fields_100_to_149.json
├── programs2_filled_fields_150_to_199.json
├── programs2_filled_fields_200_to_249.json
├── programs2_filled_fields_250_to_299.json
├── programs2_filled_fields_300_to_349.json
├── programs2_filled_fields_350_to_399.json
├── programs2_filled_fields_400_to_449.json
├── programs2_filled_fields_450_to_499.json
├── programs2_filled_fields_500_to_515.json
└── WUA.json              # Women's University programs
```

## Data Relationships

### University-Program Relationship
- Programs reference universities via `University` field
- One university can have multiple programs
- Programs belong to exactly one university

### ID System
- **University IDs**: 1-11 (sequential)
- **Program IDs**: Sequential numbers (101, 102, etc.)
- **Announcement IDs**: Per-university sequential
- **Other IDs**: Various numbering schemes

## Data Validation Rules

### Required Fields
- Universities: Name, Id
- Programs: id, Name, University
- Announcements: id, date, heading, body

### Data Types
- IDs: Integers only
- URLs: Valid URL format
- Emails: Valid email format
- Dates: YYYY-MM-DD format

### Constraints
- University IDs must be unique
- Program IDs must be unique
- University references must exist
- File paths must be valid and accessible

## Sample Data Export

### University Data Sample
```json
{
  "University of Zimbabwe": {
    "Name": "University of Zimbabwe",
    "Id": 1,
    "Website": "https://www.uz.ac.zw",
    "Portal": "https://emhare.uz.ac.zw",
    "Email": "admissions@uz.ac.zw",
    "Contacts": {...},
    "Addresses": {...},
    "AltNames": ["UZ"],
    "Description": "..."
  }
}
```

### Program Data Sample
```json
{
  "Computer Science": {
    "id": 101,
    "Name": "Computer Science",
    "Description": "...",
    "Duration": "4 years",
    "Faculty": "Faculty of Science",
    "University": 1,
    "Requirements": "...",
    "Fields": ["Programming", "Algorithms", ...]
  }
}
```

## Data Maintenance

### Adding New Data
1. **Universities**: Add to `unis.json` with unique ID
2. **Programs**: Add to `programs2.json` with unique ID
3. **Assets**: Create directory in `extras/{id}/`
4. **Announcements**: Add to university-specific JSON file

### Updating Data
- Modify existing JSON entries directly
- Ensure data consistency across references
- Test changes thoroughly

### Backup Procedures
- Regular backups of JSON files
- Version control for data changes
- Validation before deployment

## Data Quality Guidelines

### Consistency
- Use consistent naming conventions
- Maintain consistent field formats
- Ensure all references are valid

### Completeness
- Provide all required fields
- Include descriptive content
- Add alternative names for searchability

### Accuracy
- Verify contact information
- Check URL validity
- Validate academic information

This data structure provides a flexible foundation for the Unifind system, allowing for easy expansion and maintenance while maintaining data integrity and search functionality.
